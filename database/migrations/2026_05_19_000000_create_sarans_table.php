<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sarans', function (Blueprint $table) {
            $table->id();
            $table->text('isi');
            $table->enum('status', ['belum_dibaca', 'sudah_dibaca'])->default('belum_dibaca');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sarans');
    }
};
