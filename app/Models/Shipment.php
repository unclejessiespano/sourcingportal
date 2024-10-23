<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Shipment extends Model
{
    use HasFactory;

    public static function recordShipment($request){

        if($request->qty){
            $model = new Shipment();
            $model->identifier = $request->identifier;
            $model->supplier_id = $request->supplier_id;
            $model->qty_shipped = $request->qty;
            $model->qty_remaining = $request->line_qty-$request->qty;
            $model->date_shipped = date('Y-m-d');
            $model->tracking_code = $request->tracking;


            if(!$model->save()){
                Log::error("Couldn't save shipment for identifier: ".$request->indentifier);
                return false;
            }

            return $model;
        }
        else{
            return (object)['id'=>0];
        }
    }
}
