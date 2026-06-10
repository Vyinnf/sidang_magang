<?php

namespace App\Models;

use App\Models\Golongan;
use App\Models\Pegawai;
use App\Models\PermohonanSk;
use Illuminate\Database\Eloquent\Model;

class RiwayatGbk extends Model
{
    protected $fillable = ['pegawai_id', 'tmt_sk', 'tanggal_sk', 'nomor_sk', 'pejabat_sk', 'tmt_sk_lama', 'tanggal_sk_lama', 'nomor_sk_lama', 'pejabat_sk_lama', 'sk_path', 'golongan_lama_id', 'masa_kerja_golongan_lama_tahun', 'masa_kerja_golongan_lama_bulan', 'gaji_pokok_lama', 'golongan_baru_id', 'masa_kerja_golongan_baru_tahun', 'masa_kerja_golongan_baru_bulan', 'gaji_pokok_baru', 'status_sk'];

    protected $casts = [
        'tmt_sk' => 'datetime',
        'tanggal_sk' => 'datetime',
        'tmt_sk_lama' => 'datetime',
        'tanggal_sk_lama' => 'datetime',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function golonganLama()
    {
        return $this->belongsTo(Golongan::class, 'golongan_lama_id');
    }

    public function golonganBaru()
    {
        return $this->belongsTo(Golongan::class, 'golongan_baru_id');
    }

    public function permohonanSk()
    {
        return $this->hasOne(PermohonanSk::class, 'riwayat_gbk_id');
    }
}
