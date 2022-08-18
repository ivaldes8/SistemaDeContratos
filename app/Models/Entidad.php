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

    public function ClienteProveedor()
    {
        return $this->hasOne(entidadClientProvider::class, 'entidad_id', 'identidad');
    }

    public function GrupoOrgnanismo()
    {
        return $this->hasOne(entidadGrupoOrganismo::class, 'entidad_id', 'identidad');
    }
}
