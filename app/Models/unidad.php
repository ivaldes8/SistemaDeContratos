<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unidad extends Model
{
    use HasFactory;

    protected $fillable = ['desc'];

    public function informaciones()
    {
        return $this->hasMany(indicadorEntidadCpcuSaclap::class,'unidad_id', 'id');
    }
}
