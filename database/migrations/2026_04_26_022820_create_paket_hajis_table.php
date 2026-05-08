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
        Schema::create('paket_hajis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->string('kategori'); // Haji Reguler / Haji Plus / Haji Furoda
            $table->integer('harga');
            $table->integer('biaya_dp')->default(0);
            $table->string('durasi'); // "12 hari" dst
            $table->string('maskapai')->nullable();
            $table->text('fasilitas')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_hajis');
    }
};
