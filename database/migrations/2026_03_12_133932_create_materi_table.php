<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materi', function (Blueprint $table) {

            $table->id('id_materi');

            $table->unsignedBigInteger('id_subbab');

            $table->string('judul_materi');

            $table->longText('isi');

            $table->string('gambar')->nullable();

            $table->timestamps();

            $table->foreign('id_subbab')
                ->references('id_subbab')
                ->on('subbab')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};