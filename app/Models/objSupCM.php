<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class objSupCM extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'activo'];

    public function suplementos()
    {
        return $this->belongsToMany(supCM::class, 'sup_obj_c_m_s');
    }
}
