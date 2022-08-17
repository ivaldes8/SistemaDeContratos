<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cpcu extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'codigo', 'desc'];


    public function productos()
    {
        return $this->belongsToMany(producto::class, 'cpcu_productos');
    }

    public function informaciones()
    {
        return $this->hasMany(indicadorEntidadCpcuSaclap::class,'cpcu_id', 'id');
    }
}
