<?php

namespace App\Models;

use App\Models\Pegawai;
use App\Models\RiwayatGbk;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PermohonanSk extends Model
{
    protected $fillable = ['pegawai_id', 'riwayat_gbk_id', 'tanggal_pengajuan', 'catatan_pegawai', 'dokumen_pendukung', 'status', 'catatan_operator', 'diproses_oleh', 'tanggal_disetujui', 'tanggal_ditolak', 'sk_path'];

    /**
     * Atribut yang harus diubah ke tipe data tertentu.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_disetujui' => 'datetime',
        'tanggal_ditolak' => 'datetime',
        'dokumen_pendukung' => 'array',
    ];

    /**
     * Relasi ke model Pegawai.
     * Sebuah Permohonan SK dimiliki oleh satu Pegawai.
     *
     * @return BelongsTo
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    /**
     * Relasi ke model User (untuk operator yang memproses).
     * Sebuah Permohonan SK diproses oleh satu User.
     *
     * @return BelongsTo
     */
    public function diprosesOleh()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function riwayatGbk()
    {
        return $this->belongsTo(RiwayatGbk::class, 'riwayat_gbk_id');
    }
}
