<?php

namespace App\Listeners;

use App\Events\SupplierAdded;
use App\Models\Activity;
use App\Models\Supplierscore;
use App\Models\Touchpoint;
use Auth;

class SupplierAddedListener
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
    public function handle(SupplierAdded $event): void
    {
        //get the touchpoint - supapp
        $touchpoint = Touchpoint::getByCode("supadd");

        //add the score
        $supplier_score = Supplierscore::addScore($event->supplier->id, $touchpoint, $event->ingestion_id, 0);

        //add the activity
        if(!empty($suplier_score)){
            $activity = Activity::addActivity("", 0, $event->supplier->id, 0, 0, 0, $touchpoint->id, $supplier_score->id);
        }

    }
}
