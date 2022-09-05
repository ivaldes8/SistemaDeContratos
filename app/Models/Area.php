<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'dbo.AreasView';
    protected $fillable = [
        'idarea',
        'activa',
        'descripcion',
    ];

    public function AreaServicio()
    {
        return $this->hasMany(entidadAreaServicio::class, 'area_id', 'idarea');
    }
}
