<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CM extends Model
{
    use HasFactory;

    protected $fillable = ['noContrato', 'fechaFirma', 'fechaVenc', 'recibidoPor', 'contacto', 'email', 'observ', 'entidad_id', 'tipo_id', 'estado_id', 'user_id'];

    public function cliente()
    {
        return $this->hasOne(entidadClientProvider::class, 'entidad_id', 'entidad_id');
    }

    public function grupoOrg()
    {
        return $this->hasOne(entidadGrupoOrganismo::class, 'entidad_id', 'entidad_id');
    }

    public function tipo()
    {
        return $this->hasOne(tipoCM::class, 'id', 'tipo_id');
    }

    public function estado()
    {
        return $this->hasOne(estadoCM::class, 'id', 'estado_id');
    }

    public function file()
    {
        return $this->hasOne(CMFile::class, 'cm_id', 'id');
    }
}
