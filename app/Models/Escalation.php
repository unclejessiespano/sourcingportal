<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use DateTime;
class Escalation extends Model
{
    use HasFactory;
    public function supplier(){
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }
    public function line(){
        return $this->hasOne('App\Models\Line', 'identifier', 'identifier');
    }
    public static function doesEscalationLineExist($identifier){
        return (Escalation::where('identifier', $identifier)->count() >=1) ? true : false;
    }
    public static function EscalateSupplier($supplier){
        foreach($supplier->lines_ as $line){
            if(($line->active=='y') && ($line->delivery_date < date('Y-m-d')) or (is_null($line->commit_date))){
                if(!Escalation::doesEscalationLineExist($line->identifier)){
                    Escalation::EscalateSupplierLine($line);
                }

            }

        }
        return true;
    }
    public static function EscalateSupplierLine($line){
        $model = new Escalation();
        $model->supplier_id = $line->supplier_id;
        $model->identifier = $line->identifier;
        if(!$model->save()){
            Log::error("Unable to escalate supplier #".$line->supplier_id);
        }
        return $model;
    }
    public static function EscalateSuppliers(){
        $suppliers_in_escalation = Supplier::getSuppliersBelowScore(60);
        foreach($suppliers_in_escalation as $supplier){
            Escalation::EscalateSupplier($supplier);
        }

        return false;
    }
    public static function generateAIPrompt($escalation, $touchpoints_negative, $line=""){
        $escalationThreshold = 60;
        $supplier_score = Supplier::calculateSupplierScore($escalation->scores);
        $pointsIntoEscalation = $escalationThreshold-$supplier_score;
        $date_of_escalation = new DateTime(date('Y-m-d', strtotime($escalation->created_at)));
        $days_in_escalation = $date_of_escalation->diff(new DateTime(date('Y-m-d')))->days;
        $dayDays = ($days_in_escalation >1) ? "days" : "day";

        $facts = [];

        //{supplier} was placed into escalation on {date}. They have been in escalation for {days} days.


        if(!empty($line)){
            foreach($line->activity as $activity){

                if($activity->touchpoint->code=="linelt"){
                    $due_date = new DateTime(date('Y-m-d', strtotime($line->delivery_date)));
                    $days_late = $due_date->diff(new DateTime(date('Y-m-d')))->days;
                    $facts[] = "Part ".$line->sku->sku." (".$line->sku->short_text.") from ".$escalation->supplier->name." was due on ".date('F jS, Y', strtotime($line->delivery_date)).". It is ".$days_late." days late.";
                }

                //no commit
                if(empty($line->commit_date)){
                    $facts[] = $escalation->supplier->name." has not provided a commit date.";
                }

                //shipments?
                if(!empty($activity->shipment)){

                }
                else{
                    $facts[] = "There have not been any shipments.";
                }
            }

        }
        else{
            $facts[] = $escalation->name." was placed into escalation on ".date('F j, Y', strtotime($escalation->created_at)).".";
            $facts[] = "Their supplier score is ".$supplier_score.". They are ".$pointsIntoEscalation." points below the escalation threshold.";
            $facts[] = "They have been in escalation for ".$days_in_escalation." ".$dayDays.".";
            $facts[] = "The main reason their supplier score has been negatively affected is due to ".array_key_first($touchpoints_negative)." There are ".count($touchpoints_negative[array_key_first($touchpoints_negative)])." instances.";

            foreach($touchpoints_negative['details'] as $tp_detail){
                //$facts[] = "These ".count($tp_detail[array_key_first($tp_detail)])." parts have been particularly problematic.";
                $facts[] = "Parts ";

                $count = 0;
                foreach($tp_detail[array_key_first($tp_detail)] as $x){
                    $part = $x->sku." (".$x->short_text.")";
                    if($count < count($tp_detail)){
                        $part = $part.", ";
                    }
                    $facts[] = $part;
                    $count++;
                }

                $facts[] = " have been particularly problematic.";
            }
        }


        $fact_string = "";
        foreach($facts as $fact){
            $fact_string = $fact_string." ".$fact;
        }

        return $fact_string;
    }
    public static function generateExecutiveSummary($escalation){
        $date_of_escalation = new DateTime(date('Y-m-d', strtotime($escalation->created_at)));
        $days_in_escalation = $date_of_escalation->diff(new DateTime(date('Y-m-d')))->days;
        return false;
    }
    public static function getEscalatedSuppliers(){
        $suppliers = [];
        $escalations = Escalation::getEscalations();
        $lines = Line::where('active','y')->with('supplier.network', 'supplier.scores', 'supplier.escalation', 'supplier.lines_')->get();

        foreach($lines as $line){
            if($line->supplier->parent_id ==0){
                if(!empty($line->supplier->scores)){
                    $score = Supplier::calculateSupplierScore($line->supplier->scores);

                    if($score <= $target_score){
                        $line->supplier->score = $score;
                        $suppliers[$line->supplier->id] = $line->supplier;

                        if($line->supplier->escalation){
                            $suppliers[$line->supplier->id]['escalation_id'] = $line->supplier->escalation->id;
                        }

                        //$x = Touchpoint::getTouchpointsNegativelyAffectingScore($line->supplier->activity);
                        //count($x['summary'])
                        $suppliers[$line->supplier->id]['reason_count'] = 1;

                    }
                }
            }
        }


        return $suppliers;
    }
    public static function getEscalationsForEmail(){

        $y = [];
        $escalations = Escalation::with('supplier')->get();
        foreach($escalations as $escalation){
            $y[$escalation->supplier->name][] = $escalation;
        }
        return $y;
    }
    public static function getEscalations(){

        $escalations = [];
        $lines = Escalation::with('supplier.scores', 'line')->orderBy('created_at')->get();

        foreach($lines as $line){


            if($line->supplier->parent_id ==0){
                if(!empty($line->supplier->scores)){

                    $score = Supplier::calculateSupplierScore($line->supplier->scores);
                    $escalations[$line->supplier->name]['score'] = $score;
                    $escalations[$line->supplier->name]['lines'][] = $line;

                }
            }
        }

        foreach($escalations as $supplier=>$escalation){
            $touchpoints = Touchpoint::getTouchpointsNegativelyAffectingScore($escalation['lines'][0]->supplier->activity);
            $escalations[$supplier]['escalation_date'] = $escalation['lines'][0]->created_at->toDateString();
            $escalations[$supplier]['reason_count'] = count($touchpoints['summary']);
        }
        return $escalations;
    }
    public static function getStats($escalations){
        $stats = [];


        $scores = [];
        $lines = [];
        $suppliers = [];
        foreach($escalations as $supplier=>$escalation){
            $scores[$supplier] = $escalation['score'];

            foreach($escalation['lines'] as $line){
                $suppliers[$supplier][] = $supplier;
                $lines[] = $line;
            }

        }
        $stats['count'] = count($suppliers);
        $stats['average_supplier_score'] = round(array_sum($scores)/count($suppliers),2);
        $stats['total_lines'] = count($lines);
        return $stats;
    }
}
