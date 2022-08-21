<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CM extends Model
{
    use HasFactory;

    protected $fillable = ['noContrato', 'fechaFirma', 'fechaVenc', 'recibidoPor', 'contacto', 'email', 'observ', 'entidad_id', 'tipo_id', 'estado_id', 'user_id'];
}
