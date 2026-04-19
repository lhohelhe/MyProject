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
        Schema::create('hasil_quiz', function (Blueprint $table) {
            $table->id('id_hasil_quiz');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_quiz');
            $table->integer('skor');
            $table->integer('jumlah_benar');
            $table->integer('total_soal');
            $table->enum('difficulty_saat_ini', ['easy', 'medium', 'hard']);
            $table->integer('xp_didapat')->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_quiz')->references('id_quiz')->on('quiz')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_quiz');
    }
};
