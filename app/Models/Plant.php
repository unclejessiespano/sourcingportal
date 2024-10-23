<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Plant extends Model
{
    use HasFactory;
    protected $fillable = ['plant'];

    public function orders(){
        return $this->hasMany('App\Models\Order', 'plant_id', 'id');
    }
    public static function exists($plant){
        $model = Plant::where('plant', $plant)->first();
        return (!empty($model)) ? $model->id : false;
    }
    public static function getMapMarkers($plants){
        $markers = [];
        foreach($plants as $plant){
            $markers[] = ["position"=>["lat"=>floatval($plant->lat), "lng"=>floatval($plant->lng)], "title"=>$plant->plant, "label"=>"A"];
        }
        return $markers;
    }
    public static function getPlants(){
        $suppliers = [];
        $plants = Plant::with('orders.lines', 'orders.supplier')->get();
        foreach($plants as $key=>$plant){
            foreach($plant->orders as $order){
                $suppliers[] = array('id'=>$order->supplier->id, 'supplier_id'=>$order->supplier->supplier_id, 'name'=>$order->supplier->name);
            }
            $plant->suppliers = $suppliers;
            $plant->marker = ["position"=>["lat"=>floatval($plant->lat), "lng"=>floatval($plant->lng)], "title"=>$plant->plant, "label"=>(string) $key];
        }
        return $plants;
    }
    public static function import($row){
        $plant_map = Column_Map::getColumnByColumnID('plant');
        if(!empty($row[$plant_map])){
            $plant = $row[$plant_map];

            if(!empty($plant)){
                $existing_plant = Plant::exists($plant);
                if(!$existing_plant){
                    $model = Plant::create([
                        "plant"=>$plant
                    ]);

                    return $model->id;
                }
                else{
                    return $existing_plant;
                }
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }

    }
    public static function savePlant($request){
        $model = new Plant();
        $model->plant = $request->plant_name;
        $model->address = $request->address;
        $model->city = $request->city;
        $model->state = $request->state;
        $model->zip = $request->zip;
        $model->country = $request->country;
        $model->lat = $request->lat;
        $model->lng = $request->lng;
        $model->coordinates = "'(".$request->lat.", ".$request->lng.")'";
        if(!$model->save()){
            Log::error("Couldn't save plant ".$request->plant_name);
            return false;
        }
        return $model;
    }
}
