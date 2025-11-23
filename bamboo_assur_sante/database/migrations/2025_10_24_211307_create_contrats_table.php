<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
   {
      Schema::create('contrats', function (Blueprint $table) {
         $table->id();
         $table->date('date_debut')->nullable();
         $table->date('date_fin')->nullable();
         $table->string('mode_paiement')->nullable();
         $table->string('tiers_payant')->nullable();
         $table->string('id_souscripteur')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }


   public function down(): void
   {
      Schema::dropIfExists('contrats');
   }
};
