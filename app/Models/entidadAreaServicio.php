<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entidadAreaServicio extends Model
{
    use HasFactory;

    protected $fillable = ['area_id', 'servicio_id'];

    public function servicio()
    {
        return $this->hasOne(Servicio::class, 'idservicio', 'servicio_id');
    }

    public function area()
    {
        return $this->hasOne(Area::class, 'idarea', 'area_id');
    }
}
