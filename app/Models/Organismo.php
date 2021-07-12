<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organismo extends Model
{
    use HasFactory;
    protected $table = 'organismos';
    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'siglas',
        'activo',
    ];
}
