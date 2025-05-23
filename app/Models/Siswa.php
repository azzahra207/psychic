<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'NIS';
protected $Fillable = [
    'NIS',
    'NamaLengkap',
    'Alamat',
    'Jurusan',
    'TahunMasuk',
    'Telepon',
    'JenisTinggal'
    ]
;
}