<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoMarco extends Model
{
    use HasFactory;
    protected $table = 'contrato_marcos';
    public $timestamps = FALSE;
    protected $fillable = [
        'id',
        'noContrato',
        'objeto',
        'organismo',
        'grupo',
        'idClient',
        'estado',
        'fechaIni',
        'fechaEnd',
        'nombreContacto',
        'emailContacto',
        'elaboradoPor',
        'observaciones',
        'idFile'
    ];
    public function cliente(){
        return $this->belongsTo(ClienteProveedor::class, 'idClient', 'identidad');
    }
    public function organismos(){
        return $this->belongsTo(Organismo::class,'organismo', 'id');
    }
    public function grupos(){
        return $this->belongsTo(Grupo::class,'grupo','id');
    }
    public function files(){
        return $this->belongsTo(CMfile::class,'idFile','id');
    }
}
