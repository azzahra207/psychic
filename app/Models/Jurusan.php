<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'title',
        'content',
        'files',
        'activated',
        'tipeSatu',
        'tipeDua',
        'tipeTiga'
    ];
}