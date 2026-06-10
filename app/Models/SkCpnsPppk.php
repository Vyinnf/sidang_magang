<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkCpnsPppk extends Model
{
    protected $fillable = [
        'pegawai_id',
        'nomor_sk',
        'tanggal_sk',
        'tmt',
        'pejabat_sk',
        'golongan_id',
        'tahun_masa_kerja_pra_pengangkatan',
        'bulan_masa_kerja_pra_pengangkatan',
        'gaji_pokok',
        'sk_path'
    ];

    public $casts = [
        'tanggal_sk' => 'date',
        'tmt' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }
}
