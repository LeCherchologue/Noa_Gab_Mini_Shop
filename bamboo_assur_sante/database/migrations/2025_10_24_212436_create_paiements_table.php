<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
   {
      Schema::create('paiements', function (Blueprint $table) {
         $table->id();
         $table->string('reference')->nullable();
         $table->string('montant_total')->nullable();
         $table->string('type_paiement')->nullable();
         $table->string('statut')->nullable();
         $table->string('moyen_paiement')->nullable();
         $table->date('date_paiement')->nullable();
         $table->string('id_contrat')->nullable();
         $table->string('client_bamboo_emf')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }


   public function down(): void
   {
      Schema::dropIfExists('paiements');
   }
};
