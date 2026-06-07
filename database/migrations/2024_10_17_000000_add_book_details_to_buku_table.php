<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->string('penulis')->nullable()->after('deskripsi');
            $table->string('penerbit')->nullable()->after('penulis');
            $table->string('isbn')->nullable()->after('penerbit');
            $table->string('edisi')->nullable()->after('isbn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['penulis', 'penerbit', 'isbn', 'edisi']);
        });
    }
};
