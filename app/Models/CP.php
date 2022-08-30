<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CP extends Model
{
    use HasFactory;

    protected $fillable = ['noContrato', 'monto', 'fechaFirma', 'fechaVenc', 'recibidoPor', 'contacto', 'email', 'observ', 'entidad_id', 'tipo_id', 'estado_id', 'user_id'];

    public function proveedor()
    {
        return $this->hasOne(entidadClientProvider::class, 'id', 'entidad_id');
    }

    public function grupoOrg()
    {
        return $this->hasOne(entidadGrupoOrganismo::class, 'entidad_id', 'entidad_id');
    }

    public function tipo()
    {
        return $this->hasOne(tipoCP::class, 'id', 'tipo_id');
    }

    public function estado()
    {
        return $this->hasOne(estadoCP::class, 'id', 'estado_id');
    }

    public function file()
    {
        return $this->hasOne(CPFile::class, 'cp_id', 'id');
    }
}
