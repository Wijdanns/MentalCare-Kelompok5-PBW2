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
        Schema::create('pertanyaan_psikolog', function (Blueprint $table) {
           $table->id('id_pertanyaan');
           $table->unsignedBigInteger('id_tes');
           $table->text('pertanyaan');
           $table->timestamps();

           $table->foreign('id_tes')->references('id_tes')->on('tes_psikolog')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_psikolog');
    }
};
