<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class indicador extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'desc'];

    public function informaciones()
    {
        return $this->hasMany(indicadorEntidadCpcuSaclap::class,'indicador_id', 'id');
    }
}
