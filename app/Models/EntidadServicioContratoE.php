<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadServicioContratoE extends Model
{
    use HasFactory;
    protected $table = 'entidad_servicio_contrato_e_s';
    protected $fillable = [
        'id',
        'idServicio',
        'idContratoEspecifico'
    ];
}
