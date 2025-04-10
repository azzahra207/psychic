<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    
    protected $table = 'buku';
    public $timestamps =false;
    protected $primaryKey = 'ID';
protected $fillable = [
    'ID',
    'Judul',
    'Penerbit',
    'Pengarang',
    'Tahun',
    'Sinopsis',
    'Jumlah',
    
    ];
}
