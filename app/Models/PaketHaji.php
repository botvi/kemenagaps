<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketHaji extends Model
{
    protected $guarded = [];

    public function calonJemaahs()
    {
        return $this->hasMany(CalonJemaah::class);
    }
}
