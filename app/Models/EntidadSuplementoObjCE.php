<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadSuplementoObjCE extends Model
{
    use HasFactory;
    protected $table = 'entidad_suplemento_obj_c_e';
    public $timestamps = FALSE;
    protected $fillable = [
        'id',
        'idSupCE',
        'idObjCE'
    ];

    public function SupCEs(){
        return $this->belongsTo(SuplementoCE::class, 'idSupCE', 'id');
    }

    public function ObjCESups(){
        return $this->belongsTo(ObjetoSuplementoCE::class, 'idObjCE', 'id');
    }
}
