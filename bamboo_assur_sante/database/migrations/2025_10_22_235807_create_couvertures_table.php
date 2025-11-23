<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
   {
      Schema::create('couvertures', function (Blueprint $table) {
         $table->id();
         $table->string('nom')->nullable();
         $table->string('id_souscripteur')->nullable();
         $table->string('duree')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }


   public function down(): void
   {
      Schema::dropIfExists('couvertures');
   }
};
