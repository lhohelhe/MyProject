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
        Schema::create('flashcard', function (Blueprint $table) {
            $table->id('id_flashcard');
            $table->unsignedBigInteger('id_subbab');
            $table->text('pertanyaan');
            $table->text('jawaban');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_subbab')->references('id_subbab')->on('subbab')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flashcard');
    }
};
