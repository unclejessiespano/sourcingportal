<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Supplier;
use Faker\Factory;
class createTestSuppliers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-suppliers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //$qty = $this->argument('qty');
        $data = [];
        $data[] = array(
            "item_category",
            "plant",
            "purchasing_document",
            "line",
            "purchasing_group",
            "vendor_id",
            "vendor_name",
            "material",
            "description",
            "order_date",
            "due_date",
            "commit_date",
            "stat_rel_del_date",
            "qty_scheduled",
            "qty_received",
            "qty_outstanding",
            "order_unit",
            "order_unit_price",
            "price_unit",
            "net_price",
            "currency",
            "purchase_requisition",
            "lead_time"
        );

        $suppliers = array(
            "1"=>"Schinner-Mueller",
            "2"=>"Schuppe LLC",
            "3"=>"Pagac and Hintz",
            "4"=>"Hessel LLC",
            "5"=>"Cummings Group",
            "6"=>"Conroy-Tillman",
            "7"=>"Schimmel",
            "8"=>"Wintheiser & Sons",
            "9"=>"EB Lockman",
            "10"=>"Wisoky-Kemmer"
        );

        $faker = \Faker\Factory::create();
        foreach($suppliers as $supplier_id=>$supplier){
            for($i=0;$i<=$faker->randomNumber(2); $i++){
                $commit_date = ($faker->boolean()) ? $faker->dateTimeBetween("+1 week", "+6 months")->format("Y-m-d") : "";
                $order_date = $faker->dateTimeBetween("-1 month", now());
                $lead_time = $faker->randomNumber(2);
                $stat_rel_del_date = date("Y-m-d", strtotime($order_date->format('Y-m-d')." +".$lead_time." days"));
                $data[] = array(
                    "",
                    "",
                    "PO_".$faker->randomNumber(5),
                    $faker->numberBetween(1, 15),
                    "",
                    $supplier_id,
                    $supplier,
                    "SKU_".$faker->randomNumber(4),
                    $faker->sentence(5),
                    $faker->dateTimeBetween("-1 month", now())->format('Y-m-d'),
                    $faker->dateTimeBetween("-1 month", "+3 months")->format('Y-m-d'),
                    $commit_date,
                    $stat_rel_del_date,
                    $faker->randomNumber(2),
                    "",
                    "",
                    "PCS",
                    "",
                    $faker->randomFloat(2),
                    $faker->randomFloat(2),
                    "USD",
                    "",
                    $lead_time
                );

            }
        }

        return $data;
    }
}
