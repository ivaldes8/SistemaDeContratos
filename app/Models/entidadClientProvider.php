<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entidadClientProvider extends Model
{
    use HasFactory;

    protected $fillable = ['entidad_id', 'isClient','isProvider'];

    public function entidad()
    {
        return $this->hasOne(Entidad::class, 'identidad', 'entidad_id');
    }
}
