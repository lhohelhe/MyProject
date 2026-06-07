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
        Schema::table('soal_quiz', function (Blueprint $table) {
            $table->text('opsi_e')->nullable()->after('opsi_d');
            $table->enum('kunci_jawaban', ['a', 'b', 'c', 'd', 'e'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal_quiz', function (Blueprint $table) {
            $table->dropColumn('opsi_e');
            $table->enum('kunci_jawaban', ['a', 'b', 'c', 'd'])->change();
        });
    }
};
