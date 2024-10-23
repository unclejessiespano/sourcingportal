<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TouchpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = array(
            array('code'=>'called','touchpoint'=>'Called the supplier', 'description'=>'', 'value'=>'0'),
            array('code'=>'reqmee','touchpoint'=>'Request a meeting', 'description'=>'', 'value'=>'0'),
            array('code'=>'nrw48','touchpoint'=>'Failed to reply to email within 48 hours', 'description'=>'', 'value'=>'-3'),
            array('code'=>'commit','touchpoint'=>'Gave a commit date', 'description'=>'', 'value'=>'1'),
            array('code'=>'supadd','touchpoint'=>'Supplier addded to the system', 'description'=>'', 'value'=>'100'),
            array('code'=>'noship','touchpoint'=>'Unable to ship line', 'description'=>'', 'value'=>'-10'),
            array('code'=>'requpd','touchpoint'=>'Requested an update', 'description'=>'', 'value'=>'0'),
            array('code'=>'linshi','touchpoint'=>'Line shipped', 'description'=>'', 'value'=>'0'),
            array('code'=>'lindel','touchpoint'=>'Line delayed', 'description'=>'', 'value'=>'-5'),
            array('code'=>'linesc','touchpoint'=>'Line escalated', 'description'=>'', 'value'=>'-5'),
            array('code'=>'comlin','touchpoint'=>'Comment on a line', 'description'=>'', 'value'=>'0'),
            array('code'=>'ddchge','touchpoint'=>'Delivery date changed', 'description'=>'', 'value'=>'0'),
            array('code'=>'linelt','touchpoint'=>'Line late', 'description'=>'', 'value'=>'-5'),
            array('code'=>'lindlv','touchpoint'=>'Line delivered', 'description'=>'', 'value'=>'5'),
        );

        foreach($items as $item){
            $count = DB::table('touchpoints')->where('code', $item['code'])->count();
            if($count==0){
                DB::table('touchpoints')->insert($item);
            }

        }
    }
}
