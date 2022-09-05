<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CE extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'noCE', 'fechaFirma', 'fechaVenc', 'ejecutor', 'cliente', 'observ', 'c_m_id', 'estado_c_e_id', 'area_id', 'servicio_id', 'monto'];

    public function cm()
    {
        return $this->hasOne(CM::class, 'id', 'c_m_id');
    }

    public function area()
    {
        return $this->hasOne(Area::class, 'idarea', 'area_id');
    }

    public function estado()
    {
        return $this->hasOne(estadoCE::class, 'id', 'estado_c_e_id');
    }

    public function servicios()
    {
        return $this->hasMany(entidadServCE::class, 'ce_id', 'id');
    }
}
