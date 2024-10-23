<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ColumnSeeder::class,
            LineActivitySeeder::class,
            MeetingItemTypesSeeder::class,
            PermissionsSeeder::class,
            RolesSeeder::class,
            ModelHasPermissionsSeeder::class,
            ModelHasRolesSeeder::class,
            RoleHasPermissionsSeeder::class,
            TouchpointSeeder::class,
            UserSeeder::class
        ]);
        //$plants = \App\Models\Plant::factory(3)->create();
        //$suppliers = \App\Models\Supplier::factory(10)->create();

        //create the orders
        /*
        for($i=0; $i<100; $i++){
            $plant = \App\Models\Plant::inRandomOrder()->limit(1)->get();
            $supplier = \App\Models\Supplier::find(8);
            $orders = \App\Models\Order::factory()->create([
                'plant_id'=>$plant[0]->id,
                'supplier_id'=>$supplier->id
            ]);
        }
        */
        //create the skus
        for($i=0; $i<10; $i++){
            //$skus = \App\Models\Sku::factory()->create();
        }

        //create the lines
        /*
        for($i=0; $i<2500; $i++){
            $coin = rand(1,2);
            //$plant = \App\Models\Plant::inRandomOrder()->limit(1)->get();
            //$supplier = \App\Models\Supplier::inRandomOrder()->limit(1)->get();
            $order = \App\Models\Order::inRandomOrder()->limit(1)->get();
            $sku = \App\Models\Sku::inRandomORder()->limit(1)->get();
            $line = rand(1,5);
            $id = $order[0]->PO."-".$sku[0]->sku."-".$line;
            $stat_del_date = \Carbon\Carbon::create(date('Y', strtotime($order[0]->document_date)),date('m', strtotime($order[0]->document_date)), date('d', strtotime($order[0]->document_date)))->addDays($sku[0]->lead_time_days);

            if($coin==1){
                $delivery_date = \Carbon\Carbon::create(date('Y', strtotime($order[0]->document_date)),date('m', strtotime($order[0]->document_date)), date('d', strtotime($order[0]->document_date)))->addDays($sku[0]->lead_time_days)->addDays(rand(1,50));
            }
            else{
                $delivery_date = \Carbon\Carbon::create(date('Y', strtotime($order[0]->document_date)),date('m', strtotime($order[0]->document_date)), date('d', strtotime($order[0]->document_date)))->addDays($sku[0]->lead_time_days)->subDays(rand(1,50));
            }


            $count = \App\Models\Line::find($id);
            if(empty($count)){
                $lines = \App\Models\Line::factory()->create([
                    'id'=>$id,
                    'po_id'=>$order[0]->PO,
                    'sku_id'=>$sku[0]->sku,
                    'line'=>$line,
                    'document_date'=>$order[0]->document_date,
                    'delivery_date'=>$delivery_date,
                    'stat_del_date'=>$stat_del_date,
                ]);
            }


        }
        */
        $x = 1;
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
