<?php

namespace App\Listeners;

use App\Events\ScoreChanged;
use App\Models\Activity;
use App\Models\Escalation;
use App\Models\Supplierscore;
use App\Models\Touchpoint;
use App\Models\Supplier;
use Auth;

class ScoreChangedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ScoreChanged $event): void
    {
        //get the supplier
        $supplier = Supplier::with('scores', 'lines_')->find($event->supplierscore->supplier_id);

        //calculate the supplier score
        $supplier_score = Supplier::calculateSupplierScore($supplier->scores);

        if($supplier_score <60){
            //the supplier score is less than 60, add them to the escalation table
            Escalation::EscalateSupplier($supplier);
        }
        $a=1;

    }
}
