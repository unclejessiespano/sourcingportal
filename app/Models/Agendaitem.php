<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Auth;

class Agendaitem extends Model
{
    use HasFactory;
    public function line(){
        return $this->hasOne('App\Models\Line', 'identifier', 'identifier');
    }
    public static function formatAgendaItems($items){
        $agendaItems = [];
        foreach($items as $item){
            $agendaItems['stats'][$item->item][] = $item;
            $agendaItems['orders'][$item->identifier][] = $item;
        }
        return $agendaItems;
    }
    public static function create($meeting_id, $identifier, $item){
        $model = new Agendaitem();
        $model->meeting_id = $meeting_id;
        $model->assigned_to = Auth::id();
        $model->identifier = $identifier;
        $model->item = $item;
        if(!$model->save()){
            Log::error("Unable to create agenda item for meeting #".$meeting_id);
            return false;
        }

        return $model;
    }
}
