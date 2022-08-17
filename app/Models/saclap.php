<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saclap extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'desc'];

    public function productos()
    {
        return $this->belongsToMany(producto::class, 'saclap_productos');
    }

    public function informaciones()
    {
        return $this->hasMany(indicadorEntidadCpcuSaclap::class,'saclap_id', 'id');
    }
}
