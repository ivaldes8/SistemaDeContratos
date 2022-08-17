<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entidad extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'dpa', 'siglas', 'direccion', 'codREU', 'codNIT', 'codFormOrg', 'formOrg','org_id', 'osde_id'];

    public function organismo()
    {
        return $this->hasOne(organismo::class, 'id', 'org_id');
    }

    public function osde()
    {
        return $this->hasOne(osde::class, 'id', 'osde_id');
    }

    public function informaciones()
    {
        return $this->hasMany(indicadorEntidadCpcuSaclap::class,'entidad_id', 'id');
    }
}


