<?php

namespace App\Console\Commands;

use App\Models\Line;
use App\Models\Order;
use App\Models\Sku;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Supplier;
use Faker\Factory;
class createTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates test data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faker = \Faker\Factory::create();

        //$suppliers = Supplier::get();
        $suppliers = Supplier::where('parent_id', '!=', 0)->get();
        foreach($suppliers as $supplier){
            $num_of_suppliers = rand(2,10);

            for($i=0;$i<=$num_of_suppliers;$i++){
                $num_of_lines = rand(1,50);

                $new_supplier_name = $faker->company();
                $new_supplier = new Supplier();
                $new_supplier->supplier_id = rand(1,1000);
                $new_supplier->parent_id = $supplier->id;
                $new_supplier->name = $new_supplier_name;
                $new_supplier->slug = strtolower(str_replace("", "-", $new_supplier_name));
                $new_supplier->url = $faker->url();
                if(!$new_supplier->save()){
                    Log::error("Couldn't create new supplier for Supplier #".$supplier->id);
                }

                for($i=0;$i<=$num_of_lines; $i++){
                    $document_date = $faker->dateTimeBetween("-1 month", now());
                    $delivery_date = $faker->dateTimeBetween(now(), "+".$i*rand(2,4)." week");
                    $commit_date = (rand(1,100) % 2 ==0) ? $faker->dateTimeBetween(now(), "+".$i*rand(1,3)." week") : null;
                    $lead_time = $faker->randomNumber(2);
                    $stat_rel_del_date = date("Y-m-d", strtotime($document_date->format('Y-m-d')." +".$lead_time." days"));
                    //import the POs
                    $order = Order::create([
                        "PO"=>"PO_".$faker->randomNumber(5),
                        "plant_id"=>null,
                        "supplier_id"=>$new_supplier->id,
                        "document_date"=>$document_date
                    ]);

                    //import the SKUs
                    $material = $faker->randomNumber(4);
                    $existing_sku = Sku::exists($material);
                    if(!$existing_sku){
                        $sku = Sku::create([
                            "sku"=>$material,
                            "short_text"=>$faker->sentence(5),
                            "lead_time_days"=>$faker->randomNumber(2),
                        ]);
                    }
                    else{
                        //TODO - check if the lead time has changed
                        $sku = Sku::where('sku', $material)->first();
                    }

                    //import the lines
                    $identifier = $order->id."-".$sku->id."-".$i;

                    $line = Line::create([
                        "ingestion_id"=>0,
                        "active"=>"y",
                        "supplier_id"=>$new_supplier->id,
                        "identifier"=>$identifier,
                        "po_id"=>$order->id,
                        "sku_id"=>$sku->id,
                        "line"=>$i,
                        "line_activity_id"=>0,
                        "document_date"=>$document_date,
                        "delivery_date"=>$delivery_date,
                        "commit_date"=>$commit_date,
                        "stat_del_date"=>$stat_rel_del_date,
                        "qty"=>rand(1,50),
                        "order_unit"=>"each",
                        "order_price_unit"=>$faker->randomFloat(2),
                        "net_price"=>$faker->randomFloat(2),
                        "currency"=>"USD"
                    ]);

                    $b=1;
                }

            }
        }



        return false;
    }
}
