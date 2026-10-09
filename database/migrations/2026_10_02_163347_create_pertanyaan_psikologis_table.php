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
        Schema::create('pertanyaan_psikologis', function (Blueprint $table) {
           $table->id();
           $table->foreignId('id_tes')->constrained('tes_psikologis')->onDelete('cascade');
           $table->text('pertanyaan');
           $table->enum('jawaban', ['Sangat Setuju', 'Setuju', 'Netral', 'Kurang Setuju', 'Tidak Setuju']);
           $table->integer('bobot_nilai');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_psikologis');
    }
};
