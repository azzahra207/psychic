<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Campus extends Model
{
    protected $table = 'campus';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'title',
        'content',
        'files',
        'activated',
        'logo',
        'status',
        'biaya',
        'lokasi',
        'alamat',
        'akreditasi',
        'website',
        'dayaTampung',
        'profil'
    ];
}