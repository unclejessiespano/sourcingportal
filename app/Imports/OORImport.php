<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class OORImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new FirstSheetImportBatch()
        ];
    }
}
