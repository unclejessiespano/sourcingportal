<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = array(
            array('admin'=>'y','name'=>'Kevin Ruiz', 'email'=>'kruiz@corbus.com', 'password'=>Hash::make('abcd.1234')),
        );

        foreach($items as $item){
            $count = DB::table('users')->where('email', $item['email'])->count();
            if($count==0){
                DB::table('users')->insert($item);
            }

        }
    }
}
