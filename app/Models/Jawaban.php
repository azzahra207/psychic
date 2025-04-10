<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Jawaban extends Model
{
    protected $table = 'jawaban';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'soal_id',
        'huruf',
        'jawaban',
        'nilai',
        'tipe_id'
    ];
} 