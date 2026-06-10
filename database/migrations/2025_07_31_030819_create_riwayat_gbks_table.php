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
        Schema::create('riwayat_gbks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');

                // sk baru
                $table->date('tmt_sk')->nullable();
                $table->date('tanggal_sk')->nullable();
                $table->string('nomor_sk')->nullable();
                $table->string('pejabat_sk')->nullable();
            
            // sk lama
            $table->date('tmt_sk_lama')->nullable();
            $table->date('tanggal_sk_lama')->nullable();
            $table->string('nomor_sk_lama')->nullable();
            $table->string('pejabat_sk_lama')->nullable();

            // path sk yang di buat oleh sistem
            $table->string('sk_path')->nullable();

            $table->foreignId('golongan_lama_id')->nullable()->constrained('golongans')->onDelete('cascade');
            $table->integer('masa_kerja_golongan_lama_tahun')->nullable();
            $table->integer('masa_kerja_golongan_lama_bulan')->nullable();
            $table->unsignedBigInteger('gaji_pokok_lama')->nullable();

            $table->foreignId('golongan_baru_id')->constrained('golongans')->onDelete('cascade');
            $table->integer('masa_kerja_golongan_baru_tahun');
            $table->integer('masa_kerja_golongan_baru_bulan');
            $table->unsignedBigInteger('gaji_pokok_baru');

            $table->enum('status_sk', ['lengkap', 'tidak_lengkap'])->default('tidak_lengkap');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_gbks');
    }
};
