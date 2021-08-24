<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organismo extends Model
{
    use HasFactory;
    public $timestamps = FALSE;
    protected $table = 'organismos';
    protected $fillable = [
        'id',
        'codigoO',
        'nombreO',
        'siglasO',
        'activoO',
    ];
}
