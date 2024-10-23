<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = array(
            array('name'=>'user','guard_name'=>'web'),
            array('name'=>'manager','guard_name'=>'web'),
            array('name'=>'client','guard_name'=>'web'),
            array('name'=>'admin','guard_name'=>'web'),
        );

        foreach($items as $item){
            $count = DB::table('roles')->where('name', $item['name'])->count();
            if($count==0){
                DB::table('roles')->insert($item);
            }

        }
    }
}
