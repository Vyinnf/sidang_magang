<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      Schema::table('riwayat_kenaikan_pangkats', function (Blueprint $table) {
         if (!Schema::hasColumn('riwayat_kenaikan_pangkats', 'permohonan_kenaikan_pangkat_id')) {
            $table->foreignId('permohonan_kenaikan_pangkat_id')
               ->nullable()
               ->constrained('permohonan_kenaikan_pangkats')
               ->nullOnDelete();
         }
      });
   }

   public function down(): void
   {
      Schema::table('riwayat_kenaikan_pangkats', function (Blueprint $table) {
         if (Schema::hasColumn('riwayat_kenaikan_pangkats', 'permohonan_kenaikan_pangkat_id')) {
            $table->dropConstrainedForeignId('permohonan_kenaikan_pangkat_id');
         }
      });
   }
};
