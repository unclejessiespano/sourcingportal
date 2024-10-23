<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use DateTime;
class Delta extends Model
{
    use HasFactory;

    public static function calculateChange($prev_value, $current_value, $column){
        $change = "";
        switch($column){
            case "order_date":
                break;
            case "due_date":
                $previous_delivery_date = new DateTime($prev_value->$column);
                $current_delivery_date = new DateTime($current_value->$column);
                $change = date_diff(new DateTime($current_delivery_date), new DateTime($previous_delivery_date));

                break;
            case "commit_date":
                break;
            case "lead_time":
                break;
            case "qty_scheduled":
                $change = $current_value->$column-$prev_value->$column;
                break;
            case "comment":
                break;
        }

        return $change;
    }
    public static function doesDeltaExist($ingestion_id, $identifier){
        $model = Delta::where('ingestion_id', $ingestion_id)->where('identifier', $identifier)->first();
        return (!empty($model)) ? $model : false;
    }
    public static function recordChange($prev_line, $current_line, $column){
        $delta = Delta::doesDeltaExist($current_line->ingestion_id, $current_line->identifier);
        if(!$delta){
            $change = Delta::calculateChange($prev_line, $current_line, $column);

            $model = new Delta();
            $model->ingestion_id = $current_line->ingestion_id;
            $model->identifier = $current_line->identifier;
            $model->po_id = $current_line->po_id;
            $model->sku_id = $current_line->sku_id;
            $model->line = $current_line->line;
            $model->column_name = $column;
            $model->prev_value = $prev_line->$column;
            $model->current_value = $current_line->$column;
            $model->change = $change;
            if(!$model->save()){
                Log::error("Unable to save change for ".$current_line->identifier);
                return false;
            }
            return $model;
        }
        return $delta;
    }
}
