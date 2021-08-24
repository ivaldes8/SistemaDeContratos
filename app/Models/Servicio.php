<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    public $timestamps = FALSE;
    protected $table = 'dbo.ServicesView';
    protected $fillable = [
        'idservicio',
        'Expr3',
        'Descripcion',
        'codigo'
    ];
}
