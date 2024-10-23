<?php

namespace App\Models;

use App\Imports\SupplierColumnMapNeededImport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Events\SupplierColumnMapNeeded;
class SupplierColumnMap extends Model
{
    use HasFactory;

    public static function addSupplierColumnMap($supplier_id, $json){
        $model = new SupplierColumnMap();
        $model->supplier_id = $supplier_id;
        $model->column_map = $json;

        if(!$model->save()){
            Log::error("Unable to save column map for supplier ".$supplier_id);
            return false;
        }
        return $model;
    }
    public static function doesSupplierMapExist($supplier_id){
        $count = SupplierColumnMap::where('supplier_id', $supplier_id)->count();
        return ($count==0) ? false : true;
    }
    public static function createMap($request){
        session()->forget(['supplier_id', 'columns']);
        session(['supplier_id'=>$request->supplier_id]);

        //$x = SupplierColumnMapNeeded::dispatch($request);
        $file = $request->file('file');
        $file = $file[0];
        $import = (new SupplierColumnMapNeededImport)->toCollection($file->store('oors'));
        $columns = Ingestion::getColumnNames($import[0][0]);
        return redirect()->route('supplier.mapcolumns', ['columns'=>$columns, 'supplier_id'=>$request->supplier_id]);
    }
}
