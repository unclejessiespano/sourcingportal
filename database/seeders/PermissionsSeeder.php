<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = array(
            array('name'=>'upload oor','guard_name'=>'web'),
            array('name'=>'assign suppliers','guard_name'=>'web'),
        );

        foreach($permissions as $permission){
            $count = DB::table('permissions')->where('name', $permission['name'])->count();
            if($count==0){
                DB::table('permissions')->insert($permission);
            }

        }
    }
}
