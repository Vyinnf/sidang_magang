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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gaji_pokok');
            $table->integer('masa_kerja');
            $table->enum('asn', ['PNS', 'PPPK']);
            $table->foreignId('golongan_id')->constrained('golongans')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['golongan_id', 'masa_kerja', 'asn']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
