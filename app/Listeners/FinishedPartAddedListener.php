<?php

namespace App\Listeners;

use App\Events\FinishedPartAdded;
use App\Models\FinishedPart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class FinishedPartAddedListener
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
    public function handle(FinishedPartAdded $event): void
    {
        $img = "";
        if(!empty($request->file)){
            $img = FinishedPart::uploadPartImage($event);
        }

        $finished_part = FinishedPart::addFinishedPart($event->request, $img);
        $a=1;
    }
}
