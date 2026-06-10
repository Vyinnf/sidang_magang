<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sk_cpns_pppks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->date('tmt')->nullable();
            $table->string('pejabat_sk')->nullable();
            $table->foreignId('golongan_id')->nullable()->constrained('golongans')->onDelete('cascade');
            $table->integer('tahun_masa_kerja_pra_pengangkatan')->nullable();
            $table->integer('bulan_masa_kerja_pra_pengangkatan')->nullable();
            $table->integer('gaji_pokok')->nullable();
            $table->string('sk_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_cpns_pppks');
    }
};
