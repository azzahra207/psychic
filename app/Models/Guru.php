<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    
    protected $table = 'guru';
    public $timestamps =false;
    protected $primaryKey = 'ID';
protected $fillable = [
    'ID',
    'NamaGuru',
    'Alamat',
    'HP'
    ];
}