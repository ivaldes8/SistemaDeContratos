<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entidadGrupoOrganismo extends Model
{
    use HasFactory;

    protected $fillable = ['entidad_id', 'grupo_id','org_id'];

    public function organismo()
    {
        return $this->hasOne(Organismo::class, 'id', 'org_id');
    }

    public function grupo()
    {
        return $this->hasOne(Grupo::class, 'id', 'grupo_id');
    }

    public function entidad()
    {
        return $this->hasOne(Entidad::class, 'identidad', 'entidad_id');
    }
}
