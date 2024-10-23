<?php

namespace App\Imports;

use App\Mail\DataIngested;
use App\Models\Email;
use App\Models\Meeting;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Sku;
use App\Models\Line;
use App\Models\Column_Map;
use App\Models\Ingestion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Importable;
class FirstSheetImportSupplierColumnMapNeeded implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        //save the columns to the session
        $columns = Ingestion::getColumnNames($rows[0]);
        session(['columns'=>$columns]);
        return $rows[0];

    }

    public function chunkSize(): int
    {
        return 1;
    }
}
