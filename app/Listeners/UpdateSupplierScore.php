<?php

namespace App\Listeners;

use App\Events\CommitReceived;
use App\Models\Activity;
use App\Models\Supplierscore;
use App\Models\Touchpoint;
use Auth;

class UpdateSupplierScore
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
    public function handle(CommitReceived $event): void
    {
        $touchpoint = Touchpoint::getByCode("commit");

        //add the score
        $supplier_score = Supplierscore::addScore($event->line->order->supplier->id, $touchpoint);

        //add the activity
        $activity = Activity::addActivity($event->line->identifier, Auth::id(), $event->line->order->supplier->id, $event->line->po_id, $event->line->sku_id, $event->line->line, $touchpoint->id, $supplier_score->id, 0);
        $boom = $event->line;
        $b=1;
    }
}
