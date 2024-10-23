<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Auth;
class Taskcomment extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function task(){
        return $this->hasOne('App\Models\Task', 'id', 'task_id');
    }

    public static function addComment($task_id, $comment){
        $model = new Taskcomment();
        $model->task_id = $task_id;
        $model->user_id = Auth::id();
        $model->comment = $comment;
        if(!$model->save()){
            Log::error("Couldn't add comment for task #".$task_id);
            return false;
        }

        return $model;
    }
    public static function getTaskComments($tasks){
        $task_comments = [];
        foreach($tasks as $task){
            $task_comments[$task->id] = Taskcomment::with('user', 'task')->where('task_id', $task->id)->get();
        }
        return $task_comments;
    }
}
