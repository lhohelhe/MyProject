<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subbab', function (Blueprint $table) {
            $table->id('id_subbab');
            $table->unsignedBigInteger('id_bab');
            $table->string('nomor_subbab');
            $table->string('judul_subbab');
            $table->timestamps();

            $table->foreign('id_bab')
                  ->references('id_bab')
                  ->on('bab')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subbab');
    }
};
