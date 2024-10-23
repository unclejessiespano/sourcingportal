<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeetingItemTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = array(
            array('order'=>'1','type'=>'Accomplishments', 'description'=>'What did you accomplish? All wins welcome - both big and small.', 'icon'=>'🏆', 'placeholder'=>'What went well this week?'),
            array('order'=>'2','type'=>'Next Week', 'description'=>"What's on the horizon for next week? Are are we aiming for?", 'icon'=>'🔜', 'placeholder'=>"What's on the horizon for next week?"),
            array('order'=>'3','type'=>'Obstacles', 'description'=>"What's in our way?", 'icon'=>'🛑', 'placeholder'=>"What's blocking progress?"),
            array('order'=>'4','type'=>'Talking Points', 'description'=>'Anything to add?', 'icon'=>'🤔', 'placeholder'=>"Anything else to add?"),
        );

        foreach($items as $item){
            $count = DB::table('meeting_item_types')->where('type', $item['type'])->count();
            if($count==0){
                DB::table('meeting_item_types')->insert($item);
            }

        }
    }
}
