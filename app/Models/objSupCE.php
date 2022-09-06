<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class objSupCE extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'activo'];

    public function suplementos()
    {
        return $this->belongsToMany(supCE::class, 'entidad_sup_obj_c_e_s');
    }
}
