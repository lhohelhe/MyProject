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
        Schema::create('soal_simulasi', function (Blueprint $table) {
            $table->id('id_soal');
            $table->unsignedBigInteger('id_simulasi');
            $table->text('pertanyaan');
            $table->text('opsi_a');
            $table->text('opsi_b');
            $table->text('opsi_c');
            $table->text('opsi_d');
            $table->enum('kunci_jawaban', ['a', 'b', 'c', 'd']);
            $table->text('pembahasan')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_simulasi')->references('id_simulasi')->on('simulasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_simulasi');
    }
};
