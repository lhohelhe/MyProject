<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_quiz', function (Blueprint $table) {
            // Drop foreign key dulu sebelum ubah kolom
            $table->dropForeign(['id_quiz']);

            // Jadikan nullable agar AI mode bisa simpan null
            $table->unsignedBigInteger('id_quiz')->nullable()->change();

            // Re-add foreign key dengan nullOnDelete
            $table->foreign('id_quiz')
                  ->references('id_quiz')
                  ->on('quiz')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('hasil_quiz', function (Blueprint $table) {
            $table->dropForeign(['id_quiz']);
            $table->unsignedBigInteger('id_quiz')->nullable(false)->change();
            $table->foreign('id_quiz')
                  ->references('id_quiz')
                  ->on('quiz')
                  ->cascadeOnDelete();
        });
    }
};
