<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Events\ScoreChanged;
class Supplierscore extends Model
{
    use HasFactory;

    public function ingestion(){
        return $this->hasOne('App\Models\Ingestion', 'id', 'ingestion_id');
    }
    public function touchpoint(){
        return $this->hasOne('App\Models\Touchpoint', 'id', 'touchpoint_id');
    }

    public static function addScore($supplier_id, $touchpoint, $ingestion_id='0', $delta=''){
        if(empty($touchpoint->id)){
            $touchpointModel = $touchpoint->get();
            $touchpoint = $touchpointModel[0];
        }
        if(is_string($delta)){
            $a=1;
        }
        $delta_id = (($delta !="") and ($delta !=0)) ? $delta : 0;
        //check to make sure we haven't already given a supplier their initial 100
        if($touchpoint->code=="supadd"){
            $count = Supplierscore::where('supplier_id', $supplier_id)->where('touchpoint_id', $touchpoint->id)->count();
            if($count==0){
                //let's give the supplier their 100
                $model = new Supplierscore();
                $model->ingestion_id = $ingestion_id;
                $model->supplier_id = $supplier_id;
                $model->touchpoint_id = $touchpoint->id;
                $model->value = $touchpoint->value;
                $model->delta_id = $delta_id;
                if(!$model->save()){
                    Log::error("Couldn't add score. Supplier ID:".$supplier_id." Touchpoint ID:".$touchpoint->id);
                    return false;
                }
                ScoreChanged::dispatch($model);
            }
        }
        else{
            if($touchpoint->code !=="lindlv"){
                $a=1;
            }
            $model = new Supplierscore();
            $model->ingestion_id = $ingestion_id;
            $model->supplier_id = $supplier_id;
            $model->touchpoint_id = $touchpoint->id;
            $model->value = $touchpoint->value;
            $model->delta_id = $delta_id;
            if(!$model->save()){
                Log::error("Couldn't add score. Supplier ID:".$supplier_id." Touchpoint ID:".$touchpoint->id);
                return false;
            }
            ScoreChanged::dispatch($model);
        }



        return (!empty($model)) ? $model :null;
    }
    public static function deleteScoresFromIngestion($ingestion_id){
        $items = Supplierscore::where('ingestion_id', $ingestion_id)->get();
        foreach($items as $item){
            $item->delete();
        }

        return false;
    }
    public static function getScoreData($supplier_id){
        $scores = Supplierscore::where('supplier_id', $supplier_id)->where('value', '!=', 0)->orderBy('created_at')->get();

        if(count($scores)>=1){
            //get the values
            $supplier_score = 0;
            foreach($scores as $score){
                //$supplier_score = $supplier_score+($score->value);
                $values[] = array("x"=>date('Y-m-d', strtotime($score->created_at)), "y"=>$score->value);

            }
            $x = [];
            foreach($values as $value){
                $x[$value['x']][] = $value['y'];
            }

            $y = [];
            foreach($x as $key=>$value){
                $supplier_score = $supplier_score+array_sum($value);
                $y[] = array("x"=>$key, "y"=>$supplier_score);
            }
        }
        else{
            $y = [0];
        }

        return $y;
    }
}
