<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = array(
            array('permission_id'=>2,'role_id'=>2),
            array('permission_id'=>1,'role_id'=>4),
            array('permission_id'=>2,'role_id'=>4),
        );

        foreach($items as $item){
            $count = DB::table('role_has_permissions')->where('permission_id', $item['permission_id'])->where('role_id', $item['role_id'])->count();
            if($count==0){
                DB::table('role_has_permissions')->insert($item);
            }

        }
    }
}
