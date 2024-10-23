<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Supplier;
class addSubtierSuppliers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-subtier-suppliers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates subtier supplier, for testing purposes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faker = \Faker\Factory::create();

        $suppliers = Supplier::all();

        foreach($suppliers as $supplier){
            for($i=0; $i<=$faker->randomDigit(); $i++){
                $company = $faker->company();
                $model = new Supplier();
                $model->supplier_id = $faker->randomNumber(4);
                $model->parent_id = $supplier->id;
                $model->name = $company;
                $model->slug = strtolower(str_replace(" ", "-", $company));
                $model->url = $faker->url();

                if(!$model->save()){
                    Log::error("Couldn't create subtier suppliler.");
                    return false;
                }
            }
        }
    }
}
