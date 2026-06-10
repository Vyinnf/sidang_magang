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
        Schema::create('permohonan_sks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('riwayat_gbk_id')->nullable()->constrained('riwayat_gbks')->onDelete('cascade');

            $table->date('tanggal_pengajuan')->default(now());
            $table->text('catatan_pegawai')->nullable();

            $table->enum('status', ['diajukan', 'disetujui', 'ditolak', 'diproses'])->default('diajukan');
            $table->text('catatan_operator')->nullable();

            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->timestamp('tanggal_ditolak')->nullable();

            $table->string('sk_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_sks');
    }
};
