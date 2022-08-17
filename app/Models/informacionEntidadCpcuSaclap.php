<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informacionEntidadCpcuSaclap extends Model
{
    use HasFactory;

    protected $fillable = ['cpcu_id','saclap_id','entidad_id', 'unidad_id','value', 'date', 'plan', 'year'];

    public function indicador()
    {
        return $this->hasOne(indicador::class, 'id', 'indicador_id');
    }
    public function cpcu()
    {
        return $this->hasOne(cpcu::class, 'id', 'cpcu_id');
    }
    public function saclap()
    {
        return $this->hasOne(saclap::class, 'id', 'saclap_id');
    }
    public function entidad()
    {
        return $this->hasOne(entidad::class, 'id', 'entidad_id');
    }
    public function unidad()
    {
        return $this->hasOne(unidad::class, 'id', 'unidad_id');
    }
}
