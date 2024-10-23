<?php

namespace App\Listeners;

use App\Events\LineDeliveryDateChanged;
use App\Models\Supplierscore;
use DateTime;
use App\Models\Touchpoint;
use App\Models\Activity;
use Auth;

class LineDeliveryDateChangedListener
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
    public function handle(LineDeliveryDateChanged $event): void
    {
        //date difference
        $previous_delivery_date = new DateTime($event->previous_line->delivery_date);
        $current_delivery_date = new DateTime($event->current_line->delivery_date);
        $date_diff = date_diff($current_delivery_date, $previous_delivery_date);



        //get the touchpoint
        $code = "ddchge";
        $touchpoint = Touchpoint::getByCode($code);

        //save the supplier score
        $supplier_score = Supplierscore::addScore($event->current_line->supplier_id, $touchpoint, $event->ingestion_id, $event->delta->id);

        //add the activity
        Activity::addActivity($event->current_line->identifier, 0, $event->current_line->supplier_id, $event->current_line->po_id, $event->current_line->sku_id, $event->current_line->line, $touchpoint->id, $supplier_score->id, 0);

        //save the change

        $a=1;
    }
}
