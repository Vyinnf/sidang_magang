<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      Schema::create('riwayat_kenaikan_pangkats', function (Blueprint $table) {
         $table->id();
         $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
         $table->foreignId('golongan_lama_id')->nullable()->constrained('golongans')->nullOnDelete();
         $table->foreignId('golongan_baru_id')->constrained('golongans')->onDelete('cascade');
         $table->integer('masa_kerja_golongan_lama_tahun')->nullable();
         $table->integer('masa_kerja_golongan_lama_bulan')->nullable();
         $table->integer('masa_kerja_golongan_baru_tahun');
         $table->integer('masa_kerja_golongan_baru_bulan');
         $table->date('tmt_sk');
         $table->string('nomor_sk')->nullable();
         $table->date('tanggal_sk')->nullable();
         $table->string('pejabat_sk')->nullable();
         $table->string('sk_path'); // path final SK kenaikan pangkat yang disetujui
         $table->enum('status_sk', ['lengkap', 'tidak_lengkap'])->default('tidak_lengkap');
         $table->timestamps();
      });
   }

   public function down(): void
   {
      Schema::dropIfExists('riwayat_kenaikan_pangkats');
   }
};
