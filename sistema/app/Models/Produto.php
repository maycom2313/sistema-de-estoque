<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $fillable =[
        'name', 'prici', 'sexo', 'image','size', 'quantity', 'category', 'category_id', 'sexo_id'
    ];

    public function getPriceAttribute()
    {
        return "R$ " . $this->attributes['price']->strtr('prici', ',', '.');
    }
    public function setPriceAttribute($attr)
    {
        return "R$ " . $this->attributes['price']->strtr($attr, ',', '.');
    }
    public function venda(){
        return $this->belongsTo(Venda::class, 'produto_id', 'id');
    }
    public function category(){
        return $this->hasMany(Category::class, 'category_id', 'id');
    }
    public function sexo(){
        return $this->hasOne(Sexo::class, 'sexo_id', 'id');
    }

}
