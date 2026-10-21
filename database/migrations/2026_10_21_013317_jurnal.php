<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $table->text('judul')->nullable();     
            $table->longText('isi');
            $table->string('mood', 20)->nullable();
            $table->date('tanggal');
            $table->timestamps();

            $table->index(['id_user', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};