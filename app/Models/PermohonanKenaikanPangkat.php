<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanKenaikanPangkat extends Model
{
   protected $fillable = [
      'pegawai_id',
      'sk_kenaikan_path',
      'tanggal_pengajuan',
      'catatan_pegawai',
      'status',
      'catatan_operator',
      'diproses_oleh',
      'tanggal_disetujui',
      'tanggal_ditolak',
   ];

   protected $casts = [
      'tanggal_pengajuan' => 'date',
      'tanggal_disetujui' => 'datetime',
      'tanggal_ditolak' => 'datetime',
   ];

   public function pegawai()
   {
      return $this->belongsTo(Pegawai::class);
   }

   public function diprosesOleh()
   {
      return $this->belongsTo(User::class, 'diproses_oleh');
   }

   public function riwayat()
   {
      return $this->hasOne(RiwayatKenaikanPangkat::class, 'permohonan_kenaikan_pangkat_id');
   }
}
