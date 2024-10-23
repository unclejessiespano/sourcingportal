<?php

namespace App\Listeners;

use App\Events\LeadTimeChanged;
use App\Models\Supplierscore;
use DateTime;
use App\Models\Touchpoint;
use App\Models\Activity;
use App\Models\Sku;
use Auth;

class LeadTimeChangedListener
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
    public function handle(LeadTimeChanged $event): void
    {
        //TODO - how do I best communicate lead time changes? Do I need to?

        //save the new leadtime
        $sku = $event->current_line->sku->sku;
        Sku::updateLeadtime($sku, $event->current_line->new_leadtime);

        $a=1;
    }
}
