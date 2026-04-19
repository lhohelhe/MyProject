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
        Schema::create('hasil_simulasi', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->unsignedBigInteger('id_simulasi');
            $table->unsignedBigInteger('user_id');
            $table->decimal('skor', 5, 2);
            $table->integer('jumlah_benar');
            $table->integer('jumlah_salah');
            $table->integer('jumlah_kosong');
            $table->boolean('lulus')->default(false);
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_simulasi')->references('id_simulasi')->on('simulasi')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_simulasi');
    }
};
