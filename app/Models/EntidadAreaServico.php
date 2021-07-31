<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadAreaServico extends Model
{
    use HasFactory;
    protected $table = "entidad_area_servicios";
    protected $fillable = [
        'id',
        'idServicioS',
        'idAreaA',
    ];
    public function servicios(){
        return $this->belongsTo(Servicio::class, 'idServicioS', 'idservicio');
    }
    public function areas(){
        return $this->belongsTo(Area::class, 'idAreaA', 'idarea');
    }
}