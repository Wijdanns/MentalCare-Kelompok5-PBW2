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
        Schema::create('jadwal_psikolog', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->unsignedBigInteger('id_psikolog');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->boolean('status_tersedia')->default(true);
            $table->timestamps();

            $table->foreign('id_psikolog')->references('id_psikolog')->on('psikolog')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_psikolog');
    }
};
