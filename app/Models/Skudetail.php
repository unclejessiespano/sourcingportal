<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Skudetail extends Model
{
    use HasFactory;

    public static function addImage($skudetail_id, $image){
        $model = Skudetail::find($skudetail_id);
        $model->image = $image;
        if(!$model->save()){
            Log::error("Could not update skudetail id ".$skudetail_id);
            return false;
        }
        return true;
    }
    public static function getOrCreate($sku_id){
        $skudetail = Skudetail::where('sku_id', $sku_id)->first();
        if(empty($skudetail)){
            $skudetail = new Skudetail();
            $skudetail->sku_id = $sku_id;
            if(!$skudetail->save()){
                Log::error("Couldn't create sku detail for sku_id: ".$sku_id);
                return false;
            }
        }
        return $skudetail;
    }
    public static function saveImage($sku_id, $image){
        //get or create sku detail record
        $sku_detail = Skudetail::getOrCreate($sku_id);

        //save the image
        Skudetail::addImage($sku_detail->id, $image);

        return false;
    }
}
