<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
   {
      Schema::create('frais', function (Blueprint $table) {
         $table->id();
         $table->date('dates')->nullable();
         $table->string('montant')->nullable();
         $table->string('lieu')->nullable();
         $table->string('divers')->nullable();
         $table->string('personne_id')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }


   public function down(): void
   {
      Schema::dropIfExists('frais');
   }
};
