<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $fillable = ['gaji_pokok', 'masa_kerja', 'asn', 'golongan_id'];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}
