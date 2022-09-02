<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estadoCE extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'activo'];
}
