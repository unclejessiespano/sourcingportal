<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Touchpoint extends Model
{
    use HasFactory;
    public function lineactivity(){
        return $this->hasOne('App\Models\LineActivity', 'touchpoint', 'code');
    }
    public function comment(){
        return $this->hasOne('App\Models\Comment', 'activity_id', 'id');
    }
    public static function getTouchpoints(){
        $model = Touchpoint::all();
        return $model;
    }
    public static function getTouchpointsNegativelyAffectingScore($activities){
        $data = [];
        foreach($activities as $activity){
            if(!empty($activity->supplierscore) && $activity->supplierscore->value <0){
                $data[$activity->supplierscore->touchpoint->touchpoint][$activity->sku->id][] = $activity;
            }

        }

        $x = [];
        foreach($data as $touchpoint_type=>$touchpoints){
            foreach($touchpoints as $sku_id=>$value){
                $sku = Sku::find($sku_id);
                $x[$touchpoint_type][count($value)][] = $sku;
                krsort($x[$touchpoint_type]);
            }
        }

        return array("summary"=>$data, "details"=>$x);
    }
    public static function createTouchpoint($request){
        $model = new Touchpoint();
        $model->code = $request->code;
        $model->touchpoint = $request->touchpoint;
        $model->value = $request->touchpoint_value;
        $model->description = $request->description;
        if(!$model->save()){
            Log::error("Could not create touchpoint.");
            return false;
        }
        return $model;
    }
    public static function getByCode($code){
        $model = Touchpoint::where('code', $code)->first();
        return $model;
    }
    public static function getTouchpoint($id){
        $model = Touchpoint::find($id);
        return $model;
    }
    public static function updateTouchpoint($request){
        $model = Touchpoint::find($request->touchpoint_id);
        $model->code = $request->code;
        $model->touchpoint = $request->touchpoint;
        $model->value = $request->touchpoint_value;
        $model->description = $request->description;
        if(!$model->save()){
            Log::error("Could not update touchpoint #".$request->touchpoint_id);
            return false;
        }
        return $model;
    }
}
