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
        Schema::create('konsultasi', function (Blueprint $table) {
           $table->id('id_konsultasi');
           $table->unsignedBigInteger('id_users');
           $table->unsignedBigInteger('id_psikolog');
           $table->unsignedBigInteger('id_jadwal');
           $table->string('metode'); // e.g., chat / video call
           $table->string('status_konsultasi');
           $table->timestamps();

           $table->foreign('id_users')->references('id_user')->on('users')->onDelete('cascade');
           $table->foreign('id_psikolog')->references('id_psikolog')->on('psikolog')->onDelete('cascade');
           $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_psikolog')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
