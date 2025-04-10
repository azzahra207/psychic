<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Tipe extends Model
{
    protected $table = 'tipe';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'tipe_kepribadian',
        'logo',
        'icon',
        'video',
        'content',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6'
    ];
} 