<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKeberangkatan extends Model
{
    protected $guarded = [];

    public function paketHaji()
    {
        return $this->belongsTo(PaketHaji::class);
    }

    public function calonJemaah()
    {
        return $this->hasMany(CalonJemaah::class);
    }
}
