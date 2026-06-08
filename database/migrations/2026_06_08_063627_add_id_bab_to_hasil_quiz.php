<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_quiz', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bab')->nullable()->after('id_quiz');
        });
    }

    public function down(): void
    {
        Schema::table('hasil_quiz', function (Blueprint $table) {
            $table->dropColumn('id_bab');
        });
    }
};
