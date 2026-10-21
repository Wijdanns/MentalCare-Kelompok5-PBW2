<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * rating (1-5) dan komentar pasien untuk seorang psikolog.
     */
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_psikolog')->constrained('psikolog')->onDelete('cascade');
            $table->unsignedTinyInteger('rating');   // 1 sampai 5
            $table->text('komentar');
            $table->timestamps();

            // Satu pasien hanya boleh punya satu ulasan untuk satu psikolog
            $table->unique(['id_user', 'id_psikolog']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
