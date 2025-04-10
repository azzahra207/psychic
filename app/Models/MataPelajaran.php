<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    
    protected $table = 'matapelajaran';
    public $timestamps =false;
    protected $primaryKey = 'ID';
protected $fillable = [
    'ID',
    'MataPelajaran',
    'Jurusan',
    'SKS'
    ];
}