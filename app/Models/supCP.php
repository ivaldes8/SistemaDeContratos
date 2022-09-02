<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supCP extends Model
{
    use HasFactory;

    protected $fillable = ['cp_id', 'obj_sup_id', 'noSupCP', 'fechaIni', 'fechaEnd', 'ejecutor', 'observ'];

    public function cp()
    {
        return $this->hasOne(CP::class, 'id', 'cp_id');
    }

    public function objetos()
    {
        return $this->belongsToMany(objSupCP::class, 'sup_obj_c_p_s');
    }
}
