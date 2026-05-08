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
        Schema::create('jadwal_keberangkatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_haji_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_keberangkatan');
            $table->integer('kuota')->default(0);
            $table->integer('kuota_terisi')->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_keberangkatans');
    }
};
