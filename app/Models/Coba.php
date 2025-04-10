<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coba extends Model
{
    
    protected $table = 'coba';
    public $timestamps =false;
    protected $primaryKey = 'ID';
protected $fillable = [
    'ID',
    'CobaCoba',
    'Tes',
    'Berhasil'
    ];
}