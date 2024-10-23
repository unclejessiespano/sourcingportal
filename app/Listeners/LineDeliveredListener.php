<?php

namespace App\Listeners;

use App\Events\LineDelivered;
use App\Models\Activity;
use App\Models\Supplierscore;
use App\Models\Touchpoint;
use Auth;

class LineDeliveredListener
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
    public function handle(LineDelivered $event): void
    {
        $touchpoint = Touchpoint::getByCode("lindlv");

        //add the score
        $supplier_score = Supplierscore::addScore($event->line->supplier_id, $touchpoint, 0);

        //add the activity
        $activity = Activity::addActivity($event->line->identifier, 0, $event->line->supplier_id, $event->line->po_id, $event->line->sku_id, $event->line->line, $touchpoint->id, $supplier_score->id, 0);
    }
}
