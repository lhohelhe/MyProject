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
        Schema::create('user_quiz_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_bab');
            $table->enum('difficulty_level', ['easy', 'medium', 'hard'])->default('easy');
            $table->integer('streak_hari')->default(0);
            $table->date('last_quiz_date')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_bab')->references('id_bab')->on('bab')->onDelete('cascade');

            // Ensure user_id and id_bab combination is unique
            $table->unique(['user_id', 'id_bab']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_quiz_progress');
    }
};
