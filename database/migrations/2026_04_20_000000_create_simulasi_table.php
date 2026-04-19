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
        Schema::create('simulasi', function (Blueprint $table) {
            $table->id('id_simulasi');
            $table->unsignedBigInteger('id_buku');
            $table->string('judul_simulasi');
            $table->integer('durasi_menit');
            $table->integer('jumlah_soal')->default(30);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_buku')->references('id_buku')->on('buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulasi');
    }
};
