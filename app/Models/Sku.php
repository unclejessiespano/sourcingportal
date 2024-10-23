<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Sku extends Model
{
    use HasFactory;

    protected $fillable = ['sku', 'material', 'short_text', 'lead_time_days'];

    public function detail(){
        return $this->hasOne('App\Models\Skudetail', 'sku_id', 'id');
    }
    public function lines(){
        return $this->hasMany('App\Models\Line', 'sku_id', 'id');
    }
    public static function addSkuToFinishedPart($sku_id, $finishedgood_id){
        $model = new FinishedPart();
        $model->sku_id = $sku_id;
        $model->parent_id = $finishedgood_id;
        if(!$model->save()){
            Log::error("Could not add SKU ".$sku_id." to finished part ".$finishedgood_id);
            return false;
        }
        return true;
    }
    public static function exists($sku){
        $model = Sku::where('sku', $sku)->first();
        return (!empty($model)) ? $model->id : false;
    }
    public static function getLeadTimeBySkuID($sku_id){
        $model = Sku::find($sku_id);
        return $model->lead_time_days;
    }
    public static function getParts(){
        $parts = Sku::with('detail', 'lines')->get();
        foreach($parts as $part){
            $late_lines = [];
            $committed_lines = [];
            foreach($part->lines as $line){
                if($line->delivery_date < date('Y-m-d')){
                    $late_lines[] = $line->delivery_date;
                }
                if(!empty($line->commit_date)){
                    $committed_lines[] = $line->commit_date;
                }

                $part->percent_pastdue = round(count($late_lines)/count($part->lines)*100, 2);
                $part->percent_committed = round(count($committed_lines)/count($part->lines)*100, 2);
            }
        }
        return $parts;
    }
    public static function getSku($id){
       $model = Sku::with('detail', 'lines.supplier', 'lines.order')->find($id);

       return $model;
    }
    public static function import($supplier_id, $po_id, $row){
        $material = Column_Map::getColumnByColumnID('material');
        $short_text = Column_Map::getColumnByColumnID('short_text');
        $lead_time = Column_Map::getColumnByColumnID('lead_time');
        $lead_time_value = (!empty($lead_time)) ? $row[$lead_time] : 0;
        $lead_time_value_ = (!empty($lead_time_value)) ? $lead_time_value : 0;
        $short_text_description = (!empty($short_text)) ? $row[$short_text] : "";
        $existing_sku = Sku::exists($row[$material]);
        if(!$existing_sku){
            $model = Sku::create([
                "sku"=>$row[$material],
                "short_text"=>$short_text_description,
                "lead_time_days"=>$lead_time_value_,
            ]);
            return $model->id;
        }
        else{
            //TODO - check if the lead time has changed
            $a=1;
        }
        return $existing_sku;
    }
    public static function updateLeadTime($sku, $leadtime){
        $model = Sku::where('sku', $sku)->first();
        $model->lead_time_days = $leadtime;
        if(!$model->save()){
            Log::error("Could not update leadtime for SKU ".$sku);
            return false;
        }
        return true;
    }
}
