<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom 'foto'.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cukup satu function up saja
            $table->string('foto')->nullable()->after('kelas');
        });
    }

    /**
     * Batalkan migrasi (hapus kolom 'foto').
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};