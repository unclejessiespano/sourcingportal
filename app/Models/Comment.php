<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Auth;
class Comment extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public static function addComment($activity_id, $line_id, $po_id, $sku_id, $line, $identifier, $comment){
        $model = new Comment();
        $model->activity_id = $activity_id;
        $model->user_id = Auth::id();
        $model->identifier = $identifier;
        $model->po_id = $po_id;
        $model->sku_id = $sku_id;
        $model->line_id = $line_id;
        $model->comment = nl2br($comment);
        if(!$model->save()){
            Log::error("Could add a comment for identifier ".$identifier);
            return false;
        }
        return $model;
    }
}
