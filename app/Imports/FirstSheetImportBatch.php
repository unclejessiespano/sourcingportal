<?php
namespace App\Imports;

use App\Models\Column_Map;
use App\Models\Ingestion;
use App\Models\Line;
use App\Models\Meeting;
use App\Models\Order;
use App\Models\Sku;
use App\Models\Supplier;
use App\Models\Email;
use App\Models\User;
use App\Models\TempOOR;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class FirstSheetImportBatch implements ToModel, WithBatchInserts, WithHeadingRow
{
    public function model(array $row){


        return new TempOOR([
            "ingestion_id"=>0,
            "row_data"=>json_encode($row)
        ]);
    }

    public function batchSize(): int{
        return 100;
    }
}
