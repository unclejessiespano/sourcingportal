<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SimulateActivityDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:simulateActivityDates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulates activity dates to make test data look more authentic.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $activities = \App\Models\Supplierscore::all();
        foreach($activities as $activity){
            $randomDate = date('Y-m-d h:i:s', mt_rand(strtotime('6 months ago'),strtotime('+180 days') ));
            $activity->created_at = $randomDate;
            if(!$activity->save()){
                $a=1;
            }
        }
    }
}
