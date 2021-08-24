<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjetoSuplementoCE extends Model
{
    use HasFactory;
    public $timestamps = FALSE;
    protected $fillable = [
        'id',
        'ObjetoSuplementoCE',
    ];
}
