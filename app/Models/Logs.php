<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'element', 'type'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
