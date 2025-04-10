<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HasilTes extends Model
{
    protected $table = 'hasil_tes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'tipe_id',
        'hasil',
        'user_id',
        'sesi',
        'status'
    ];
}