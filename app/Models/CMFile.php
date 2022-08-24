<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMFile extends Model
{
    use HasFactory;

    protected $fillable = ['cm_id', 'path', 'file1', 'file2', 'file3', 'file4'];
}
