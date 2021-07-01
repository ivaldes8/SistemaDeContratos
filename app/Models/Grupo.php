<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $table = 'grupos';
    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'siglas',
        'id_Organismo',
        'activo',
        'id_Client'
    ];
    public function organismos(){
        return $this->belongsTo(Organismo::class,'id_Organismo','id');
    }
}
