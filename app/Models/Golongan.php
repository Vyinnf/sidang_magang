<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    protected $fillable = ['golongan', 'pangkat', 'asn'];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function gajis()
    {
        return $this->hasMany(Gaji::class);
    }

    public function skCpnsPppks()
    {
        return $this->hasMany(SkCpnsPppk::class, 'golongan_id');
    }
}
