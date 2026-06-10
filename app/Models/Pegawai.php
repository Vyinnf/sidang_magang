<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'user_id',
        'golongan_id',
        'nip',
        'asn',
        'jabatan',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_kenaikan_gaji_berkala_berikutnya'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tmt_cpns_pppk' => 'date',
        'tanggal_kenaikan_gaji_berkala_berikutnya' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Golongan
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    // Relasi ke Riwayat SK GBK
    public function riwayatGbks()
    {
        return $this->hasMany(RiwayatGbk::class, 'pegawai_id');
    }

    public function permohonanSks()
    {
        return $this->hasMany(PermohonanSk::class, 'pegawai_id');
    }

    public function getTmtSkTerbaruAttribute()
    {
        return $this->riwayatGbks()->latest()->first()?->tmt_sk;
    }

    public function skCpnsPppk()
    {
        return $this->hasOne(SkCpnsPppk::class, 'pegawai_id');
    }

    public function permohonanKenaikanPangkats()
    {
        return $this->hasMany(PermohonanKenaikanPangkat::class, 'pegawai_id');
    }

    public function riwayatKenaikanPangkats()
    {
        return $this->hasMany(RiwayatKenaikanPangkat::class, 'pegawai_id');
    }
}
