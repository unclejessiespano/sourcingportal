<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;

    public function column_map(){
        return $this->hasOne('App\Models\Column_Map', 'column_id', 'column_name');
    }
    public static function getColumns(){
        $columns = Column::with('column_map')->get();
        foreach($columns as $column){
            $column->column_id = (!empty($column->column_map)) ? $column->column_map->column : "";
        }

        return $columns;
    }
    public static function makeSupplierColumnMap($columns, $supplier_columns){
        $map = [];
        foreach($columns as $index=>$column){
            $value = (!empty($supplier_columns[$index])) ? $supplier_columns[$index] : null;
            $map[$column->column_name] = $value;
        }
        return json_encode($map);
    }
}
