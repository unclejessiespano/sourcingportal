<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Auth;
class Activity extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function supplier(){
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }
    public function touchpoint(){
        return $this->hasOne('App\Models\Touchpoint', 'id', 'touchpoint_id');
    }
    public function order(){
        return $this->hasOne('App\Models\Order', 'id', 'po_id');
    }
    public function sku(){
        return $this->hasOne('App\Models\Sku', 'id', 'sku_id');
    }
    public function line(){
        return $this->hasOne('App\Models\Line', 'id', 'line_id');
    }
    public function liner(){
        return $this->hasOne('App\Models\Line', 'id', 'line_id');
    }
    public function supplierscore(){
        return $this->hasOne('App\Models\Supplierscore', 'id', 'supplierscore_id');
    }
    public function shipment(){
        return $this->hasOne('App\Models\Shipment', 'id', 'shipment_id');
    }
    public function comment(){
        return $this->belongsTo('App\Models\Comment', 'comment_id', 'id');
    }
    public static function addActivity($identifier, $user_id, $supplier_id, $po_id="", $sku_id="", $line="", $touchpoint_id, $supplierscore_id, $shipment_id="0", $comment_id="0"){
        $model = new Activity();
        $model->identifier = $identifier;
        $model->user_id = $user_id;
        $model->supplier_id = $supplier_id;
        $model->po_id = $po_id;
        $model->sku_id = $sku_id;
        $model->line_id = $line;
        $model->touchpoint_id = $touchpoint_id;
        $model->supplierscore_id = $supplierscore_id;
        $model->shipment_id = $shipment_id;
        if(!$model->save()){
            Log::error("Could not add activity. Supplier ID:".$supplier_id." Touchpoint ID:".$touchpoint_id);
            return false;
        }

        return $model;
    }
    public static function addCommentToActivity($comment_id, $activity){

        $activity->comment_id = $comment_id;
        if(!$activity->save()){
            Log::error("Could not save comment ".$comment_id." to activity ".$activity->id);
            return false;
        }
        return true;
    }
    public static function getActivity($supplier_id="", $po_id="", $sku_id="", $line_id=""){


        if(!empty($supplier_id)){
            $model = Line::with('order','sku','activity.user', 'activity.shipment','activity.comment', 'activity.touchpoint.lineactivity')->where('supplier_id', $supplier_id);
        }
        else{
            $model = Activity::with('shipment','user', 'supplier', 'comment', 'touchpoint.lineactivity','order','sku','line','supplierscore');
            if(!empty($po_id)){
                $model = $model->where('po_id', $po_id);
            }
            if(!empty($po_id) && !empty($sku_id)){
                $model = $model->where('po_id', $po_id)->where('sku_id', $sku_id);
            }
            if(!empty($po_id) && !empty($sku_id) && !empty($line_id)){
                $model = $model->where('po_id', $po_id)->where('sku_id', $sku_id)->where('line_id', $line_id);
            }


        }

        $model = $model->orderBy('created_at', 'asc')->get();
        return $model;
    }
}
