<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_hasil')->constrained('hasil_tes')->onDelete('cascade');
            $table->foreignId('id_pertanyaan')->constrained('pertanyaan_psikologis')->onDelete('cascade');
            $table->foreignId('id_jawaban')->constrained('jawaban_psikologis')->onDelete('cascade');
            $table->integer('poin');
            $table->timestamps();

            $table->unique(['id_hasil', 'id_pertanyaan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_user');
    }
};