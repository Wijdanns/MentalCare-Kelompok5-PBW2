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
        Schema::create('review_psikolog', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_konsultasi')->constrained('konsultasi')->onDelete('cascade');
        $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_psikolog')->constrained('psikolog')->onDelete('cascade');
        $table->tinyInteger('rating'); // Skala 1 - 5 bintang
        $table->text('ulasan')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_psikologs');
    }
};
