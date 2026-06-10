<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   /**
    * Run the migrations.
    */
   public function up(): void
   {
      Schema::create('permohonan_kenaikan_pangkats', function (Blueprint $table) {
         $table->id();
         $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
         // dokumen SK kenaikan pangkat yang diajukan (upload wajib)
         $table->string('sk_kenaikan_path');
         $table->date('tanggal_pengajuan')->default(now());
         $table->text('catatan_pegawai')->nullable();
         $table->enum('status', ['diajukan', 'diproses', 'disetujui', 'ditolak'])->default('diajukan');
         $table->text('catatan_operator')->nullable();
         $table->foreignId('diproses_oleh')->nullable()->constrained('users')->nullOnDelete();
         $table->timestamp('tanggal_disetujui')->nullable();
         $table->timestamp('tanggal_ditolak')->nullable();
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('permohonan_kenaikan_pangkats');
   }
};
