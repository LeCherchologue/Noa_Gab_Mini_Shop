<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
   {
      Schema::create('regle_remboursements', function (Blueprint $table) {
         $table->id();
         $table->string('garantie_id')->nullable();
         $table->string('plafond')->nullable();
         $table->string('franchise')->nullable();
         $table->string('taux_remboursement')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }


   public function down(): void
   {
      Schema::dropIfExists('regle_remboursements');
   }
};
