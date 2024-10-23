<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class Task extends Model
{
    use HasFactory;

    public static function getTasksByIdentifier($identifier){
        $model = Task::where('identifier', $identifier)->get();

        return $model;
    }
    public static function updateTaskStatus($task_id, $taskcolumn_id){
        $model = Task::find($task_id);
        $model->taskcolumn_id = $taskcolumn_id;
        if(!$model->save()){
            Log::error("Couldn't update task column for task #".$task_id);
            return false;
        }
        return true;
}
}
