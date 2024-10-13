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
        Schema::create('Buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('judul_buku', 100);
            $table->string('jenis_buku', 100);
            $table->string('penulis', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->string('image_buku', 255);
            $table->unsignedBigInteger('kategori_id'); // Menambahkan kolom kategori_id
            $table->integer('stok')->default(0); // Menambahkan kolom stok dengan nilai default 0
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('kategori_id')->references('id_kategori')->on('KategoriBuku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Buku');
    }
};
