<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\Supplier;
use Auth;

class Meeting extends Model
{
    use HasFactory;
    public function agendaitems(){
        return $this->hasMany('App\Models\Agendaitem', 'meeting_id', 'id');
    }
    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function supplier(){
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }
    public static function createMeeting($rows){

        foreach($rows as $row){
            $row = json_decode($row->row_data, true);
            $supplier = Supplier::findOrGetSupplier($row);
            $suppliers[] = $supplier['supplier_id'];
        }

        $unique_suppliers = array_unique($suppliers);

        foreach($unique_suppliers as $supplier_id){
            $supplier = Supplier::find($supplier_id);

            $model = new Meeting();
            $model->supplier_id = $supplier_id;
            $model->user_id = Auth::id();
            $model->name = "Weekly touchpoint - ".$supplier->name;
            if(!$model->save()){
                Log::error("Couldn't create meeting for ".$supplier->name);
                return false;
            }

            $meetings[$supplier_id] = $model->id;
        }

        return $meetings;
    }
    public static function generateAttendees($meeting){
        $attendees = [];
        $attendees[] = $meeting->user;
        foreach($meeting->supplier->contacts as $contact){
            $attendees[] = $contact;
        }
        return $attendees;
    }
}
