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
        Schema::create('Anggota', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->string('nis')->unique();
            $table->string('nama');
            $table->date('tgl_lahir');
            $table->string('kelas');
            $table->string('alamat')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->enum('status_anggota', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Anggota');
    }
};
