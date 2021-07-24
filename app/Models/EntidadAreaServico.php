<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadAreaServico extends Model
{
    use HasFactory;
    protected $table = "entidad_area_servicos";
    protected $fillable = [
        'id',
        'idServicio',
        'idArea',
    ];
    public function servicios(){
        return $this->belongsTo(Servicio::class, 'idServicio', 'idservicio');
    }
    public function areas(){
        return $this->belongsTo(Area::class, 'idArea', 'idarea');
    }
}