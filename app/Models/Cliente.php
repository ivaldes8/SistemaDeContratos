<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'dbo.ClientsView';
    protected $fillable = [
        'identidad',
        'codigo',
        'codigoreu',
        'nombre',
        'abreviatura',
        'direccion',
        'activo',
        'email',
        'telefono',
        'NIT',
        'provincia',
        'pais'
    ];
}
