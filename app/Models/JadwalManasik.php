<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalManasik extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_kegiatan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'pemateri',
        'moderator',
        'status',
        'jenis_manasik',
        'pertemuan_ke',
    ];
}
