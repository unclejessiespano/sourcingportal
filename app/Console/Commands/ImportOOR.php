<?php

namespace App\Console\Commands;

use App\Events\OORUploaded;
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
use Illuminate\Console\Command;
use App\Imports\OORImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportOOR extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:oor {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports an OOR';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        $filepath = 'app/oors/'.$filename;
        $file = storage_path($filepath);

        //turn all the lines in the database to active='n'
        Line::deactivateAllLines();
        $this->info("Lines deactivated");

        //processes the logic for ingesting the data
        TempOOR::truncate();
        $this->info("Temp OOR table truncated");

        Excel::import(new OORImport, $file, 'local', \Maatwebsite\Excel\Excel::XLSX);
        $this->info("OOR imported");

        //Ingest the data
        //IngestData::dispatch();


        $rows = TempOOR::all();
        $bar = $this->output->createProgressBar(count($rows));
        $bar->start();
        //are the columns mapped?
        $mapped_columns = Column_Map::mapColumns(json_decode($rows[0]->row_data));

        if(count($mapped_columns['unmapped_columns']) > 0){
            //return to_route("map-columns");
        }

        //award the points for lines that are no longer in the oor...assume they're closed?
        Line::awardPointsClosedLines($rows);
        $this->info("Closed lines awarded points");

        //create the meeting for the new lines
        $meetings = Meeting::createMeeting($rows);
        $this->info("Meetings created");

        //create the ingestion
        $ingestion = Ingestion::add($_FILES['file']['name'][0]);
        $this->info("Ingestion created");

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

            $bar->advance();
        }
        $this->info("Rows processed");

        //update the scores
        Ingestion::updateSupplierScores($ingestion->id);
        $this->info("Supplier scores updated");

        //fire off the email
        Email::sendDataIngestedEmail();
        $this->info("Email sent");

        $bar->finish();

        //Excel::import(new OORImport, storage_path('app/data/oor_jci.xlsx'));
    }
}
