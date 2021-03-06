<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadGO extends Model
{
    use HasFactory;
    protected $table = 'entidad_g_o_s';
    public $timestamps = FALSE;
    protected $fillable = [
        'id',
        'idClientGO',
        'idGrupo',
        'idOrganismo'
    ];
    public function organismos(){
        return $this->belongsTo(Organismo::class, 'idOrganismo', 'id');
    }
    public function grupos(){
        return $this->belongsTo(Grupo::class, 'idGrupo', 'id');
    }
    public function entidades(){
        return $this->belongsTo(ClienteProveedor::class, 'idClientGO', 'identidad');
    }
}
