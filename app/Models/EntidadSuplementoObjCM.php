<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadSuplementoObjCM extends Model
{
    use HasFactory;
    protected $table = 'entidad_suplemento_obj_c_m';
    
    protected $fillable = [
        'id',
        'idSupCM',
        'idObjCM'
    ];

    public function SupCMs(){
        return $this->belongsTo(SuplementoCM::class, 'idSupCM', 'id');
    }

    public function ObjCMSups(){
        return $this->belongsTo(ObjetoSuplementoCM::class, 'idObjCM', 'id');
    }
}
