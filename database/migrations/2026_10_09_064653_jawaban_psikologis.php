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
         Schema::create('jawaban_psikologis', function (Blueprint $table) {
           $table->id();
           $table->foreignId('id_pertanyaan')->constrained('pertanyaan_psikologis')->onDelete('cascade');
           $table->String('jawaban');
           $table->integer('poin');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_psikologis');
    }
};
