<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
   {
      Schema::create('demande_remboursements', function (Blueprint $table) {
         $table->id();
         $table->string('contrat_id')->nullable();
         $table->string('beneficiare_id')->nullable();
         $table->string('reference')->nullable();
         $table->date('date_reclamation')->nullable();
         $table->string('statut')->nullable();
         $table->string('total')->nullable();
         $table->string('montant_rembourse')->nullable();
         $table->string('motif_refus')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }


   public function down(): void
   {
      Schema::dropIfExists('demande_remboursements');
   }
};
