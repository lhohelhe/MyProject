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
        Schema::table('hasil_simulasi', function (Blueprint $table) {
            $table->json('list_jawaban')->nullable()->after('jumlah_kosong');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_simulasi', function (Blueprint $table) {
            $table->dropColumn('list_jawaban');
        });
    }
};
