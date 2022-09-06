<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supCE extends Model
{
    use HasFactory;

    protected $fillable = ['ce_id', 'obj_sup_id', 'noSupCE', 'fechaIni', 'fechaEnd', 'ejecutor', 'observ'];

    public function ce()
    {
        return $this->hasOne(CE::class, 'id', 'ce_id');
    }

    public function objetos()
    {
        return $this->belongsToMany(objSupCE::class, 'entidad_sup_obj_c_e_s');
    }
}
