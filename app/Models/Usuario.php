<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'password', 'role', 'api_token'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
