<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadCP extends Model
{
    use HasFactory;
    protected $table = 'entidad_c_p_s';
    protected $fillable = [
        'id',
        'idClient',
        'cliente',
        'proveedor'
    ];
}
