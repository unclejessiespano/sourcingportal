<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //delete activities
        \App\Models\Activity::truncate();

        //delete comments
        \App\Models\Comment::truncate();

        //delete contacts
        \App\Models\Contact::truncate();

        //delete lines
        \App\Models\Line::truncate();

        //delete orders
        \App\Models\Order::truncate();

        //delete plants
        \App\Models\Plant::truncate();

        //delete shipments
        \App\Models\Shipment::truncate();

        //delete shippinglocationcontacts
        \App\Models\Shippinglocationcontact::truncate();

        //delete shippinglocations
        \App\Models\Shippinglocation::truncate();

        //delete skus
        \App\Models\Sku::truncate();

        //delete suppliers
        \App\Models\Supplier::truncate();

        //delete supplierscores
        \App\Models\Supplierscore::truncate();

        //delete meetings
        \App\Models\Meeting::truncate();

        //delete agendaitems
        \App\Models\Agendaitem::truncate();

        //delete ingestions
        \App\Models\Ingestion::truncate();

        //delete escalationss
        \App\Models\Escalation::truncate();
    }
}
