<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
   {
      Schema::create('frais_medicals', function (Blueprint $table) {
         $table->id();
         $table->string('demande_remboursement_id')->nullable();
         $table->string('type_frais')->nullable();
         $table->string('montant')->nullable();
         $table->text('description')->nullable();
         $table->string('justificatif')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }


   public function down(): void
   {
      Schema::dropIfExists('frais_medicals');
   }
};
