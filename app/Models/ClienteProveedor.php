<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClienteProveedor extends Model
{
    use HasFactory;
    protected $table = 'dbo.ClientsView';
    public $timestamps = FALSE;
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
    public function organismos(){
        return $this->belongsTo(EntidadGO::class,'identidad','idClientGO');
    }
}
