<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoEspecifico extends Model
{
    protected $table = 'contrato_especificos';
    protected $fillable = [
        'id',
        'idCM',
        'idArea',
        'noContratoEspecifico',
        'estado',
        'fechaIni',
        'fechaEnd',
        'ejecutorName',
        'clienteName',
        'observaciones',
        'monto'
    ];
    public function areas(){
        return $this->belongsTo(Area::class, 'idArea', 'idarea');
    }
    public function CMs(){
        return $this->belongsTo(ContratoMarco::class,'idCM','id');
    }
    
}
