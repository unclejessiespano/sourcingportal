<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\OORImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(){
        $tenant = tenant('id');
        $x = storage_path();
        Excel::import(new OORImport, storage_path('app/data/oor_'.$tenant.'.xlsx'));
        return true;
    }
}
