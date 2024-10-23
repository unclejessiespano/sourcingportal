<?php

namespace App\Exports;
use Generator;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DateTime;
class RandomOORExport implements FromGenerator
{
    use Exportable;


    /**
    * @return \Illuminate\Support\Collection
    */
    public function generator(): Generator
    {
        $data = [];
        $date_format = "m/d/Y";
        yield array(
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
                $commit_date = ($faker->boolean()) ? $faker->dateTimeBetween("+1 week", "+6 months") : "";

                if($faker->boolean()){
                    $commit_date = Date::dateTimeToExcel($faker->dateTimeBetween("+1 week", "+6 months"));
                }
                else{
                    $commit_date = "";
                }

                $order_date = $faker->dateTimeBetween("-1 month", now());
                $lead_time = $faker->randomNumber(2);
                $stat_rel_del_date = new DateTime();
                $stat_rel_del_date->modify("+".$lead_time." days");
                yield array(
                    "",
                    "",
                    "PO_".$faker->randomNumber(5),
                    $faker->numberBetween(1, 15),
                    "",
                    $supplier_id,
                    $supplier,
                    "SKU_".$faker->randomNumber(4),
                    $faker->sentence(5),
                    Date::dateTimeToExcel($faker->dateTimeBetween("-1 month", now())),
                    Date::dateTimeToExcel($faker->dateTimeBetween("-1 month", "+3 months")),
                    $commit_date,
                    Date::dateTimeToExcel($stat_rel_del_date),
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
    }
}
