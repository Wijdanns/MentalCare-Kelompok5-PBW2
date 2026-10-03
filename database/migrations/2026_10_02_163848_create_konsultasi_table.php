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
           $table->id();
           $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
           $table->foreignId('id_psikolog')->constrained('psikolog')->onDelete('cascade');
           $table->foreignId('id_jadwal')->constrained('jadwal_psikolog')->onDelete('cascade');
           $table->enum('metode', ['Online', 'Offline']); 
           $table->enum('status_konsultasi', ['Menuggu Pembayaran', 'Dikonfirmasi', 'Selesai', 'Batal'])->default('Menuggu Pembayaran');
           $table->decimal('total_biaya', 10, 2);
           $table->timestamps();
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
