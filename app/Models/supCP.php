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

    public function objeto()
    {
        return $this->hasOne(objSupCP::class, 'id', 'obj_sup_id');
    }
}
