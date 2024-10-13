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
        Schema::create('KategoriBuku', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori', 50);
            // $table->string('jenis_kategori', 50);
            $table->string('lokasi_buku', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('KategoriBuku');
    }
};
