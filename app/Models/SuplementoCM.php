<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuplementoCM extends Model
{
    use HasFactory;
    public $timestamps = FALSE;
    protected $table = 'suplemento_c_m_s';
    protected $fillable = [
        'id',
        'idCMSuplemto',
        'noSupCM',
        'fechaIniSup',
        'fechaEndSup',
        'ejecutorSup',
        'observacionesSup'
    ];
    public function CMs(){
        return $this->belongsTo(ContratoMarco::class,'idCMSuplemto','id');
    }
}
