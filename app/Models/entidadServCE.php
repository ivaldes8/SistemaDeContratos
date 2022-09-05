<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entidadServCE extends Model
{
    use HasFactory;

    protected $fillable = ['serv_id', 'ce_id'];

    public function servicio()
    {
        return $this->hasOne(Servicio::class, 'idservicio', 'serv_id');
    }

}
