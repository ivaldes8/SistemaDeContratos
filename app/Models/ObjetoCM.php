<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjetoCM extends Model
{
    use HasFactory;
    protected $table = 'objeto_c_m_s';
    protected $fillable = [
        'id',
        'nombre'
    ];
}
