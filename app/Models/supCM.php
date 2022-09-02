<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supCM extends Model
{
    use HasFactory;

    protected $fillable = ['cm_id', 'obj_sup_id', 'noSupCM', 'fechaIni', 'fechaEnd', 'ejecutor', 'observ'];

    public function cm()
    {
        return $this->hasOne(CM::class, 'id', 'cm_id');
    }

    public function objetos()
    {
        return $this->belongsToMany(objSupCM::class, 'sup_obj_c_m_s');
    }
}
