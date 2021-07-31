<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoEspecifico extends Model
{
    protected $table = 'contrato_especificos';
    protected $fillable = [
        'idCEspecifico',
        'idCM',
        'idAreaCE',
        'noContratoEspecifico',
        'estado',
        'fechaIniCE',
        'fechaEndCE',
        'ejecutorName',
        'clienteName',
        'observaciones',
        'monto'
    ];
    public $timestamps = false;
    public function areas(){
        return $this->belongsTo(Area::class, 'idAreaCE', 'idarea');
    }
    public function CMs(){
        return $this->belongsTo(ContratoMarco::class,'idCM','id');
    }
    
}
