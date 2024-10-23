<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class MeetingItem extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function meetingitemtype(){
        return $this->hasOne('App\Models\MeetingItemType', 'id', 'meeting_type_id');
    }

    public static function addMeetingItem($request){
        $model = new MeetingItem;
        $model->meeting_id = $request->meeting_id;
        $model->meeting_type_id = $request->type_id;
        $model->user_id = Auth::id();
        $model->item = $request->input[$request->type_id];
        if(!$model->save()){
            Log::error("Couldn't save meeting item for meeting #".$request->meeting_id);
            return false;
        }
        return $model;
    }
    public static function getItemsByMeetingId($meeting_id){
        $meeting_items = [];
        $items = MeetingItem::with('user', 'meetingitemtype')->where('meeting_id', $meeting_id)->get();
        foreach($items as $item){
            $meeting_items[$item->meeting_type_id][] = $item;
        }

        return $meeting_items;
    }
}
