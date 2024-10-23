<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineActivity extends Model
{
    use HasFactory;

    public function touchpoint(){
        return $this->hasOne('App\Models\Touchpoint', 'code', 'touchpoint');
    }
    public function touchpointmodel(){
        return $this->hasOne('App\Models\Touchpoint', 'code', 'touchpoint');
    }
}
