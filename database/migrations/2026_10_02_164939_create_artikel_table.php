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
        Schema::create('artikel', function (Blueprint $table) {
            $table->id('id_artikel');
            $table->unsignedBigInteger('id_admin');
            $table->string('judul');
            $table->string('jenis_artikel');
            $table->text('isi');
            $table->timestamp('tanggal_publikasi')->nullable();
            $table->timestamps();

            $table->foreign('id_admin')->references('id_admin')->on('admin_sistem')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
