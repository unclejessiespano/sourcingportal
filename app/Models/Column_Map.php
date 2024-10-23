<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SupplierColumnMap;
class Column_Map extends Model
{
    use HasFactory;
    protected $table = "column_maps";
    protected $fillable = ['column_id', 'column'];
    public static function getColumnByColumnID($column_id){
        $supplier_id = session('supplier_id');
        if(empty($supplier_id)){
            $model = Column_Map::where('column_id', $column_id)->first();
        }
        else{
            $model = SupplierColumnMap::select("column_map->$column_id as column")->where("supplier_id", $supplier_id)->first();
        }
        return (!empty($model)) ? $model->column : null;
    }
    public static function getMappedColumn($column){
        $model = Column_Map::where('column', $column)->first();
        return $model;
    }
    public static function mapColumn($request){
        $map_column = strtolower(str_replace(" ", "_", str_replace("/", "", str_replace(".", "", $request->map_column))));
        $model = Column_Map::updateOrCreate(
            ['column_id'=>$request->column_name],
            ['column'=>$map_column]
        );
        return $model;
    }
    public static function mapColumns($rows){
        $mapped_columns = [];
        $unmapped_columns = [];
        foreach($rows as $column=>$value){
            $mapped_column = Column_Map::getMappedColumn($column);

            if(!empty($mapped_column)){
                $mapped_columns[] = $mapped_column->column_id;
            }
            else{
                $unmapped_columns[] = $column;
            }
        }

        //if the unmapped_columns array isn't zero...we need to map the columns.
        return array("mapped_columns"=>$mapped_columns, "unmapped_columns"=>$unmapped_columns);
    }

}
