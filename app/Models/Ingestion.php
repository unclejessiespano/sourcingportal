<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Events\LineDeliveryDateChanged;
use App\Events\LineQuantityChanged;
use App\Events\LineNetPriceChanged;
use App\Events\LeadTimeChanged;
use App\Events\CommentChanged;
use Illuminate\Validation\Rules\In;

class Ingestion extends Model
{
    use HasFactory;

    public function lines(){
        return $this->hasMany('App\Models\Line', 'ingestion_id', 'id');
    }

    public static function add($filename){
        $model = new Ingestion();
        $model->filename = $filename;
        if(!$model->save()){
            Log::error("Could not save the ingestion record for file ".$filename);
            return false;
        }

        return $model;
    }
    public static function getColumnNames($row){
        $columns = [];
        foreach($row as $key=>$value){
            $columns[] = $key;
        }
        return $columns;
    }
    public static function getIngestions(){
        $ingestions = Ingestion::with('lines.sku')->get();
        foreach($ingestions as $ingestion){
            $commit_dates = [];
            $late_lines = [];
            foreach($ingestion->lines as $line){
                if(!empty($line->commit_date)){
                    $commit_dates[] = $line->commit_date;
                }
                if($line->delivery_date > date("Y-m-d")){
                    $late_lines[] = $line->delivery_date;
                }
            }

            if(count($ingestion->lines) >=1){
                $ingestion->commit_percent = round((count($commit_dates)/count($ingestion->lines)*100),0);
                $ingestion->percentageLateLines = round((count($late_lines)/count($ingestion->lines)*100),0);
            }

        }

        return $ingestions;
    }
    public static function getLastTwoIngestions(){
        $model = Ingestion::with('lines.sku')->orderBy('id')->take(2)->get();
        return $model;
    }
    public static function deleteIngestion($ingestion_id){
        //delete the ingestion
        $model = Ingestion::find($ingestion_id);
        $model->delete();

        //get the next ingestion
        $ingestion = Ingestion::orderBy('id', 'desc')->first();
        return $ingestion->id;
    }
    public static function updateSupplierScores($ingestion_id){
        $order_date = Column_Map::getColumnByColumnID('order_date');
        $due_date = Column_Map::getColumnByColumnID('due_date');
        $commit_date_map = Column_Map::getColumnByColumnID('commit_date');
        $lead_time = Column_Map::getColumnByColumnID('lead_time');
        $qty_scheduled = Column_Map::getColumnByColumnID('qty_scheduled');
        $comment = Column_Map::getColumnByColumnID('comment');

        $fields = array(
            "document_date"=>$order_date,
            "delivery_date"=>$due_date,
            "commmit_date"=>$commit_date_map,
            "qty"=>$qty_scheduled,
            "lead_time"=>$lead_time,
            "comment"=>$comment
        );

        $ingestions = Ingestion::getLastTwoIngestions();
        foreach($ingestions as $ingestion){
            foreach($ingestion->lines as $line){
                $lines = Line::getLinesByIdentifier($line->identifier);
                if(count($lines)>1){
                    $current_line = $lines[count($lines)-1];
                    $prev_line = $lines[count($lines)-2];

                    if($current_line->delivery_date != $prev_line->delivery_date){
                        $delta = Delta::recordChange($prev_line, $current_line, "delivery_date");
                        LineDeliveryDateChanged::dispatch($ingestion_id, $prev_line, $current_line, $delta);

                    }
                    if($current_line->qty != $prev_line->qty){
                        $delta = Delta::recordChange($prev_line, $current_line, "qty");
                        LineQuantityChanged::dispatch($ingestion_id, $prev_line, $current_line, $delta);

                    }
                    if($current_line->net_price != $prev_line->net_price){
                        $delta = Delta::recordChange($prev_line, $current_line, "net_price");
                        LineNetPriceChanged::dispatch($ingestion_id, $prev_line, $current_line, $delta);

                    }
                    if($current_line->sku->lead_time_days != $prev_line->sku->lead_time_days){
                        $delta = Delta::recordChange($prev_line, $current_line, "lead_time_days");
                        LeadTimeChanged::dispatch($ingestion_id, $prev_line, $current_line, $delta);

                    }
                    //What about comments?
                    /*
                    if($current_line->sku->lead_time_days != $prev_line->sku->lead_time_days){
                        LeadTimeChanged::dispatch($prev_line, $current_line);
                    }
                    */
                    $a=1;
                }
            }
        }
    }
}
