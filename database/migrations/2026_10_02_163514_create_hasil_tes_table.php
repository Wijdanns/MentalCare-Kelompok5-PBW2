<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_tes', function (Blueprint $table) {
           $table->id();
           $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
           $table->foreignId('id_tes')->constrained('tes_psikologis')->onDelete('cascade');
           $table->integer('total_poin');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_tes');
    }
};
