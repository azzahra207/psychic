<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HasilTesDetail extends Model
{
    protected $table = 'hasil_tes_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'hasil_tes_id',
        'soal_id',
        'jawaban_id'
    ];
}