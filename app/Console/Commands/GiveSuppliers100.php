<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Supplier;
use App\Models\Supplierscore;
use App\Models\Touchpoint;
use App\Models\Activity;
class GiveSuppliers100 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:give-suppliers100';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gives suppliers 100 points to start';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $suppliers = Supplier::all();
        $code = "supadd";
        //get the touchpoint - supapp
        $touchpoint = Touchpoint::getByCode($code);

        foreach($suppliers as $supplier){
            //add the score
            $supplier_score = Supplierscore::addScore($supplier->id, $touchpoint);

            //add the activity
            //$identifier, $user_id, $supplier_id, $po_id="", $sku_id="", $line="", $touchpoint_id, $supplierscore_id, $shipment_id="0"
            $activity = Activity::addActivity($supplier->id, 0, $supplier->id, 0, 0, 0, $touchpoint->id, 0);

        }

        return false;
    }
}
