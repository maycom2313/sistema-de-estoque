<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;
    protected $fillable =[
        'produto_id', 'vendidos'
    ];

    public function produtos(){
        return $this->hasMany(Produto::class, 'id', 'prduto_id');
    }
}
