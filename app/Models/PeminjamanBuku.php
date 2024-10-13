<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit jika tidak menggunakan konvensi nama Laravel
    protected $table = 'PeminjamanBuku';

    // Tentukan primary key yang digunakan oleh model
    protected $primaryKey = 'id_peminjaman';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['id_buku', 'id_anggota'];

    /**
     * Relasi dengan model Buku
     * Setiap peminjaman buku berkaitan dengan satu buku.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    /**
     * Relasi dengan model Anggota
     * Setiap peminjaman buku berkaitan dengan satu anggota.
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }
}
