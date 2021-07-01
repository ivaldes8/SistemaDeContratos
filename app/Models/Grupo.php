<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $table = 'grupos';
    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'siglas',
        'organismo',
        'activo',
        'id_Client'
    ];
}
