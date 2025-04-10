<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Testimoni extends Model
{
    protected $table = 'testimoni';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'title',
        'content',
        'files',
        'activated',
        'Alamat'
    ];
}