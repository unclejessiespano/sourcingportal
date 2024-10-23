<?php

namespace App\Providers;

use App\Events\CommitReceived;
use App\Events\LineDeliveryDateChanged;
use App\Events\LineLate;
use App\Events\LineNetPriceChanged;
use App\Events\LineQuantityChanged;
use App\Events\OORUploaded;
use App\Events\SupplierOORUploaded;
use App\Events\LineDelivered;
use App\Events\PartImageUploaded;
use App\Events\SupplierAdded;
use App\Events\SupplierColumnMapNeeded;
use App\Events\LeadTimeChanged;
use App\Events\CommentChanged;
use App\Events\ScoreChanged;
use App\Events\FinishedPartAdded;
use App\Listeners\LineDeliveryDateChangedListener;
use App\Listeners\LineLateListener;
use App\Listeners\LineNetPriceChangedListener;
use App\Listeners\LineQuantityChangedListener;
use App\Listeners\OORUploadedListener;
use App\Listeners\SupplierColumnMapNeededListener;
use App\Listeners\SupplierOORUploadedListener;
use App\Listeners\UpdateSupplierScore;
use App\Listeners\LineDeliveredListener;
use App\Listeners\SupplierAddedListener;
use App\Listeners\PartImageUploadedListener;
use App\Listeners\LeadTimeChangedListener;
use App\Listeners\CommentChangedListener;
use App\Listeners\ScoreChangedListener;
use App\Listeners\FinishedPartAddedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommitReceived::class => [
            UpdateSupplierScore::class
        ],
        OORUploaded::class => [
            OORUploadedListener::class
        ],
        SupplierColumnMapNeeded::class => [
            SupplierColumnMapNeededListener::class
        ],
        SupplierOORUploaded::class => [
            SupplierOORUploadedListener::class
        ],
        LineQuantityChanged::class => [
            LineQuantityChangedListener::class
        ],
        LineDeliveryDateChanged::class => [
            LineDeliveryDateChangedListener::class
        ],
        LineNetPriceChanged::class => [
            LineNetPriceChangedListener::class
        ],
        LineLate::class => [
            LineLateListener::class
        ],
        LineDelivered::class => [
            LineDeliveredListener::class
        ],
        SupplierAdded::class => [
            SupplierAddedListener::class
        ],
        PartImageUploaded::class => [
            PartImageUploadedListener::class
        ],
        LeadTimeChanged::class => [
            LeadTimeChangedListener::class
        ],
        CommentChanged::class => [
            CommentChangedListener::class
        ],
        ScoreChanged::class => [
            ScoreChangedListener::class
        ],
        FinishedPartAdded::class =>[
            FinishedPartAddedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
