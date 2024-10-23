<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempOOR extends Model
{
    use HasFactory;

    protected $fillable = ["ingestion_id", "row_data"];
    protected $table = "temp_oors";

    public static function ingestData(){
        $rows = TempOOR::all();

        //are the columns mapped?
        $mapped_columns = Column_Map::mapColumns(json_decode($rows[0]->row_data));

        if(count($mapped_columns['unmapped_columns']) > 0){
            //return to_route("map-columns");
        }

        //award the points for lines that are no longer in the oor...assume they're closed?
        Line::awardPointsClosedLines($rows);

        //create the meeting for the new lines
        $meetings = Meeting::createMeeting($rows);

        //create the ingestion
        $ingestion = Ingestion::add($_FILES['file']['name'][0]);
        foreach ($rows as $item)
        {
            $row = json_decode($item->row_data, true);
            //import the plant
            $plant_id = Plant::import($row);

            //import the supplier
            $supplier_id = Supplier::import($ingestion->id, $row);

            //import the POs
            $po_id = Order::import($supplier_id, $row);

            //import the SKUs
            $sku_id = SKU::import($supplier_id, $po_id, $row);

            //import the lines
            Line::import($ingestion->id, $plant_id, $supplier_id, $po_id, $sku_id, $row, $meetings);

            //delete the line from the temp_oors table
            $item->delete();
        }

        //update the scores
        Ingestion::updateSupplierScores($ingestion->id);
    }
}
