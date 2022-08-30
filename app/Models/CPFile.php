<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CPFile extends Model
{
    use HasFactory;

    protected $fillable = ['cp_id', 'path', 'file1', 'file2', 'file3', 'file4'];
}
