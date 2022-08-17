<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    use HasFactory;

    protected $table = 'dbo.EntidadesView';
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
