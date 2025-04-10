<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TesUji extends Model
{
    protected $table = 'soal';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'soal'
    ];
} 