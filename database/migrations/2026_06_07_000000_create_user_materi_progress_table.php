<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_materi_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_bab');
            // 0-based index of the furthest subbab the user has reached in this bab
            $table->unsignedInteger('max_subbab_index')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'id_bab']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_bab')->references('id_bab')->on('bab')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_materi_progress');
    }
};
