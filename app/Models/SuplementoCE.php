<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuplementoCE extends Model
{
    use HasFactory;
    public $timestamps = FALSE;
    protected $table = 'suplemento_c_e_s';
    protected $fillable = [
        'id',
        'idCESuplemto',
        'noSupCE',
        'fechaIniSup',
        'fechaEndSup',
        'ejecutorSup',
        'observacionesSup'
    ];
    public function CEs(){
        return $this->belongsTo(ContratoEspecifico::class,'idCESuplemto','idCEspecifico');
    }
}
