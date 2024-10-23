<?php

namespace App\Jobs;

use App\Models\Column_Map;
use App\Models\Email;
use App\Models\Ingestion;
use App\Models\Line;
use App\Models\Meeting;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Sku;
use App\Models\Supplier;
use App\Models\TempOOR;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class IngestData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("IngestData");
    }
}
