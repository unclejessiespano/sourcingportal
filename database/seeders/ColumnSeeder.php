<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $columns = array(

            array("name"=>"Item Category", "column_name"=>"item_category", "type"=>null, "description"=>null),
            array("name"=>"Plant", "column_name"=>"plant", "type"=>null, "description"=>null),
            array("name"=>"Purchasing Document", "column_name"=>"purchasing_document", "type"=>null, "description"=>null),
            array("name"=>"Line", "column_name"=>"line", "type"=>null, "description"=>"The line on the PO."),
            array("name"=>"Purchasing Group", "column_name"=>"purchasing_group", "type"=>null, "description"=>null),
            array("name"=>"Vendor ID", "column_name"=>"vendor_id", "type"=>null, "description"=>null),
            array("name"=>"Vendor Name", "column_name"=>"vendor_name", "type"=>null, "description"=>null),
            array("name"=>"Material", "column_name"=>"material", "type"=>null, "description"=>null),
            array("name"=>"Description", "column_name"=>"description", "type"=>null, "description"=>null),
            array("name"=>"Order Date", "column_name"=>"order_date", "type"=>null, "description"=>"The date the order was placed."),
            array("name"=>"Due Date", "column_name"=>"due_date", "type"=>null, "description"=>"The date the order is due."),
            array("name"=>"Commit Date", "column_name"=>"commit_date", "type"=>null, "description"=>"The date the supplier has committed to delivering the order."),
            array("name"=>"Statistical Delivery Date", "column_name"=>"statistical_delivery_date", "type"=>null, "description"=>"The date the order should arrived based on the order date and the supplier's lead time."),
            array("name"=>"Quantity Scheduled", "column_name"=>"qty_scheduled", "type"=>null, "description"=>"The amount ordered."),
            array("name"=>"Quantity Received", "column_name"=>"qty_received", "type"=>null, "description"=>"The amount received."),
            array("name"=>"Quantity Outstanding", "column_name"=>"qty_outstanding", "type"=>null, "description"=>"The amount still to be received."),
            array("name"=>"Order Unit", "column_name"=>"order_unit", "type"=>null, "description"=>null),
            array("name"=>"Order Unit Price", "column_name"=>"order_unit_price", "type"=>null, "description"=>null),
            array("name"=>"Price Unit", "column_name"=>"price_unit", "type"=>null, "description"=>null),
            array("name"=>"Net Price", "column_name"=>"net_price", "type"=>null, "description"=>null),
            array("name"=>"Currency", "column_name"=>"currency", "type"=>null, "description"=>null),
            array("name"=>"Purchase Requisition", "column_name"=>"purchase_requisition", "type"=>null, "description"=>null),
            array("name"=>"Lead Time", "column_name"=>"lead_time", "type"=>null, "description"=>"The supplier agreed upon number of days it takes to delivery a material once it's been ordered."),
        );

        foreach($columns as $column){
            $count = DB::table('columns')->where('name', $column['name'])->count();
            if($count==0){
                DB::table('columns')->insert([
                    'name'=>$column['name'],
                    'column_name'=>$column['column_name'],
                    'type'=>$column['type'],
                    'description'=>$column['description']
                ]);
            }

        }
    }
}
