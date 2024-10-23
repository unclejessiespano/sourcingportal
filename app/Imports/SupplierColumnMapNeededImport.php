<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Importable;
class SupplierColumnMapNeededImport implements WithMultipleSheets
{
    use Importable;
    public function sheets(): array
    {
        return [
            new FirstSheetImportSupplierColumnMapNeeded()
        ];
    }
}
