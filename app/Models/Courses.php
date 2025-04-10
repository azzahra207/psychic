<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Courses extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'title',
        'content',
        'files',
        'activated'
    ];
}