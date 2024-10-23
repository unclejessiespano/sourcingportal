<?php

namespace App\Imports;

use App\Mail\DataIngested;
use App\Models\Email;
use App\Models\Meeting;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Sku;
use App\Models\Line;
use App\Models\Column_Map;
use App\Models\Ingestion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
class FirstSheetImport implements ToCollection, WithHeadingRow
{

    /*
         * Array
(
    [0] => Document Date
    [1] => Item Category
    [2] => Plant
    [3] => Purchasing Document
    [4] => Item
    [5] => Purchasing Group
    [6] => Name of Vendor
    [7] => Material
    [8] => Short Text
    [9] => Delivery Date
    [10] => Scheduled Quantity
    [11] => Quantity Received
    [12] => Still to be delivered (qty)
    [13] => Still to be delivered (value)
    [14] => Order Unit
    [15] => Order Price Unit
    [16] => Price Unit
    [17] => Net price
    [18] => Currency
    [19] => Purchase Requisition
    [20] => Req. Tracking Number
    [21] => Stat.-Rel. Del. Date
)

         * */


    public function collection(Collection $rows)
    {
        //are the columns mapped?
        $mapped_columns = Column_Map::mapColumns($rows[0]);

        if(count($mapped_columns['unmapped_columns']) > 0){
            //return to_route("map-columns");
        }

        //award the points for lines that are no longer in the oor...assume they're closed?
        Line::awardPointsClosedLines($rows);

        //create the meeting for the new lines
        $meetings = Meeting::createMeeting($rows);

        //create the ingestion
        $ingestion = Ingestion::add($_FILES['file']['name'][0]);
        foreach ($rows as $row)
        {
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
        }

        //update the scores
        Ingestion::updateSupplierScores($ingestion->id);

        /*
        $date = Email::getDateForWeeklyUpdate();
        $linestats = Line::getStats();
        $lineChanges = Line::getLineChangeStats(2);
        $tablePastDue = Line::getEmailData_PercentPastDueSuppliers();
        $tableCommits = Line::getEmailData_PercentCommitSuppliers();
        $markdown_table_percentPastDueSuppliers = View::make('emails.table.percentPastDueSuppliers', ['data'=>$tablePastDue])->render();
        $markdown_table_percentCommitsSuppliers = View::make('emails.table.percentCommitsSuppliers', ['data'=>$tableCommits])->render();
        Mail::to('kruiz@corbus.com')->send(new DataIngested(
            $date,
            $markdown_table_percentPastDueSuppliers,
            $markdown_table_percentCommitsSuppliers,
            $lineChanges
        ));
        */
    }

    public function chunkSize(): int
    {
        return 1;
    }
}
