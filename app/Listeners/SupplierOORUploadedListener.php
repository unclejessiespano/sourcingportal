<?php

namespace App\Listeners;

use App\Events\OORUploaded;
use App\Events\SupplierOORUploaded;
use App\Imports\OORImport;
use App\Imports\SupplierOORImport;
use App\Models\Ingestion;
use App\Models\Meeting;
use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Excel as ExcelExcel;
use Illuminate\Support\Facades\Storage;
class SupplierOORUploadedListener
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
    public function handle(SupplierOORUploaded $event): void
    {
        $file = $event->request->file('file');
        $file = $file[0];

        Excel::import(new SupplierOORImport, $file->store('oors'), 'local', \Maatwebsite\Excel\Excel::XLSX);
    }
}
