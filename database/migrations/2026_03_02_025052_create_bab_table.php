<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bab', function (Blueprint $table) {
            $table->id('id_bab');
            $table->unsignedBigInteger('id_buku');
            $table->string('nomor_bab');
            $table->string('judul_bab');
            $table->timestamps();

            $table->foreign('id_buku')
                  ->references('id_buku')
                  ->on('buku')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bab');
    }
};
