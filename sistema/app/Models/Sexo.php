<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    use HasFactory;
    public function produtos(){
        return $this->hasMany(Produto::class, 'sexo_id', 'id');
    }
}
