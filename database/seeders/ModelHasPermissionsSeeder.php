<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = array(
            array('permission_id'=>'1','model_type'=>'App\Models\User', 'model_id'=>'1'),
            array('permission_id'=>'2','model_type'=>'App\Models\User', 'model_id'=>'1'),
        );

        foreach($items as $item){
            $count = DB::table('model_has_permissions')->where('permission_id', $item['permission_id'])->where('model_id', $item['model_id'])->count();
            if($count==0){
                DB::table('model_has_permissions')->insert($item);
            }

        }
    }
}
