<?php

namespace App\Listeners;

use App\Events\OORUploaded;
use App\Events\SupplierColumnMapNeeded;
use App\Imports\OORImport;
use App\Imports\SupplierColumnMapNeededImport;
use App\Models\Ingestion;
use App\Models\Meeting;
use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Excel as ExcelExcel;
use Illuminate\Support\Facades\Storage;
class SupplierColumnMapNeededListener
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
    public function handle(SupplierColumnMapNeeded $event): void
    {
        $file = $event->request->file('file');
        $file = $file[0];

        $x = (new SupplierColumnMapNeededImport)->toCollection($file->store('oors'));

    }
}
