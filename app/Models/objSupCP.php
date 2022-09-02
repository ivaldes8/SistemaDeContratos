<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class objSupCP extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'activo'];

    public function suplementos()
    {
        return $this->belongsToMany(supCP::class, 'sup_obj_c_p_s');
    }
}
