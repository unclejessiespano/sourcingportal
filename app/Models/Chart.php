<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    public static function formatData($chart, $data){
        switch($chart){
            case "guage":
                break;
        }
    }
}
