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
        Schema::create('Transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_buku');
            $table->unsignedBigInteger('id_anggota');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
            $table->date('tanggal_pengembalian_real')->nullable();
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->decimal('denda', 8, 2)->default(0); // Kolom denda
            $table->timestamps();

            $table->foreign('id_buku')->references('id_buku')->on('Buku')->onDelete('cascade');
            $table->foreign('id_anggota')->references('id_anggota')->on('Anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Transaksi');
    }
};
