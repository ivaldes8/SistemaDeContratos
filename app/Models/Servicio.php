<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'dbo.ServicesView';
    protected $fillable = [
        'idservicio',
        'Expr3',
        'Descripcion',
        'codigo'
    ];
}
