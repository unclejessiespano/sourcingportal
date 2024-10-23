<?php

namespace App\Listeners;

use App\Events\OORUploaded;
use App\Imports\OORImport;
use App\Mail\DataIngested;
use App\Jobs\IngestData;
use App\Models\Column_Map;
use App\Models\Email;
use App\Models\Ingestion;
use App\Models\Line;
use App\Models\Meeting;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Sku;
use App\Models\Supplier;
use App\Models\TempOOR;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Excel as ExcelExcel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
class OORUploadedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OORUploaded $event): void
    {
        $file = $event->request->file('file');
        $file = $file[0];

        TempOOR::truncate();

        Excel::import(new OORImport, $file->store('oors'), 'local', \Maatwebsite\Excel\Excel::XLSX);

        //Ingest the data
        //IngestData::dispatch();


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

        //fire off the email
        Email::sendDataIngestedEmail();


        //Do we need to escalate any lines or suppliers?

        //create the meeting for the new lines
        //$meetings = Meeting::createMeeting($rows);

        //create the ingestion
        //$ingestion = Ingestion::add($_FILES['file']['name'][0]);
    }
}
