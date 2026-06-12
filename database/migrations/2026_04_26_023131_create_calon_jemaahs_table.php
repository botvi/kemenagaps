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
        Schema::create('calon_jemaahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->year('tahun_pendaftaran');
            $table->foreignId('paket_haji_id')->constrained()->onDelete('cascade');
            $table->enum('status_pendaftaran', ['pending', 'dikonfirmasi', 'ditolak', 'cancel'])->default('pending');
            $table->string('kodelogin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_jemaahs');
    }
};
