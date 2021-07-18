<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMfile extends Model
{
    use HasFactory;
    protected $table = 'cm_files';
    protected $fillable = [
        'id',
        'id_CM',
        'file1',
        'file2',
        'file3',
        'file4',
        'path'

    ];
    public function contrato(){
        return $this->belongsTo(ContratoMarco::class, 'id_CM', 'id');
    }
}
