<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class osde extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'siglas', 'codigo'];

    public function entidad()
    {
        return $this->hasMany(entidad::class);
    }
}
