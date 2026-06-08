<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_materi_xp_claims', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_materi');
            $table->timestamp('xp_claimed_at');

            $table->unique(['user_id', 'id_materi']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_materi')->references('id_materi')->on('materi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_materi_xp_claims');
    }
};
