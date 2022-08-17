<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = ['codigo','nombre','siglas', 'activo','org_id'];

    public function organismo()
    {
        return $this->hasOne(Organismo::class, 'id', 'org_id');
    }
}
