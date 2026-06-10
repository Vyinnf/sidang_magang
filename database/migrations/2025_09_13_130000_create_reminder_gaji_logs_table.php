<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
   {
      Schema::create('reminder_gaji_logs', function (Blueprint $table) {
         $table->id();
         $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
         $table->date('tmt'); // TMT gaji berkala berikutnya
         $table->smallInteger('window'); // selisih hari sebelum TMT (30,7,1)
         $table->timestamp('sent_at');
         $table->timestamps();
         $table->unique(['pegawai_id', 'tmt', 'window'], 'reminder_gaji_unique');
         $table->index(['tmt', 'window']);
      });
   }

   public function down(): void
   {
      Schema::dropIfExists('reminder_gaji_logs');
   }
};
