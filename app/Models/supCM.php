<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supCM extends Model
{
    use HasFactory;

    protected $fillable = ['cm_id', 'obj_sup_id', 'noSupCM', 'fechaIni', 'fechaEnd', 'ejecutor', 'observ'];
}
