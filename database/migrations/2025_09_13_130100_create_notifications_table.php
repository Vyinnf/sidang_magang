<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
   {
      Schema::create('notifications', function (Blueprint $table) {
         $table->uuid('id')->primary();
         $table->string('type');
         // morphs() already creates notifiable_type, notifiable_id and an index
         $table->morphs('notifiable');
         $table->text('data');
         $table->timestamp('read_at')->nullable();
         $table->timestamps();
         // Removed redundant manual index to prevent duplicate key error on MySQL
      });
   }

   public function down(): void
   {
      Schema::dropIfExists('notifications');
   }
};
