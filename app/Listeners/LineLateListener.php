<?php

namespace App\Listeners;

use App\Events\LineLate;
use App\Models\Activity;
use App\Models\Supplierscore;
use App\Models\Touchpoint;
use App\Models\Agendaitem;
use Auth;

class LineLateListener
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
    public function handle(LineLate $event): void
    {
        $touchpoint = Touchpoint::getByCode("linelt");

        //add the agenda item
        $agenda_item = Agendaitem::create($event->meeting_id, $event->line->identifier, "Inquire why line is late");

        //add the score
        $supplier_score = Supplierscore::addScore($event->line->supplier_id, $touchpoint, $event->ingestion_id, $event->delta_id);

        //add the activity
        $activity = Activity::addActivity($event->line->identifier, 0, $event->line->supplier_id, $event->line->po_id, $event->line->sku_id, $event->line->line, $touchpoint->id, $supplier_score->id, 0);
    }
}
