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
      Schema::table('permohonan_sks', function (Blueprint $table) {
         $table->json('dokumen_pendukung')->nullable()->after('catatan_pegawai');
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::table('permohonan_sks', function (Blueprint $table) {
         $table->dropColumn('dokumen_pendukung');
      });
   }
};
