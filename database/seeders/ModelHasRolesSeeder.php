<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = array(
            array('role_id'=>'4','model_type'=>'App\Models\User', 'model_id'=>'1'),
        );

        foreach($items as $item){
            $count = DB::table('model_has_roles')->where('role_id', $item['role_id'])->where('model_id', $item['model_id'])->count();
            if($count==0){
                DB::table('model_has_roles')->insert($item);
            }

        }
    }
}
