<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadServicioContratoE extends Model
{
    use HasFactory;
    protected $table = 'entidad_servicio_contrato_e_s';
    public $timestamps = FALSE;
    protected $fillable = [
        'id',
        'idServicioS',
        'idContratoEspecifico'
    ];
    public function servicios(){
        return $this->belongsTo(Servicio::class, 'idServicioS', 'idservicio');
    }
    public function CE(){
        return $this->belongsTo(Servicio::class, 'idContratoEspecifico', 'id');
    }
}
