<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
   {
      Schema::create('souscripteurs', function (Blueprint $table) {
         $table->id();
         $table->string('nom')->nullable();
         $table->string('prenom')->nullable();
         $table->string('tel')->nullable();
         $table->integer('nb_enfant')->nullable();
         $table->string('assurance')->nullable();
         $table->string('adresse')->nullable();
         $table->string('beneficiaire')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }


   public function down(): void
   {
      Schema::dropIfExists('souscripteurs');
   }
};
