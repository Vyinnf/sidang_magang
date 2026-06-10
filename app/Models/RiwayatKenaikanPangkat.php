<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKenaikanPangkat extends Model
{
   protected $fillable = [
      'pegawai_id',
      'golongan_lama_id',
      'golongan_baru_id',
      'masa_kerja_golongan_lama_tahun',
      'masa_kerja_golongan_lama_bulan',
      'masa_kerja_golongan_baru_tahun',
      'masa_kerja_golongan_baru_bulan',
      'tmt_sk',
      'nomor_sk',
      'tanggal_sk',
      'pejabat_sk',
      'sk_path',
      'status_sk',
      'permohonan_kenaikan_pangkat_id'
   ];

   protected $casts = [
      'tmt_sk' => 'date',
      'tanggal_sk' => 'date',
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

   public function permohonan()
   {
      return $this->belongsTo(PermohonanKenaikanPangkat::class, 'permohonan_kenaikan_pangkat_id');
   }
}
