<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit jika tidak menggunakan konvensi nama Laravel
    protected $table = 'Transaksi';

    // Tentukan primary key yang digunakan oleh model
    protected $primaryKey = 'id_transaksi';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_buku',
        'id_anggota',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'tanggal_pengembalian_real',
        'status',
        'denda',
    ];
    public function getDendaAttribute()
    {
        // Hitung denda jika status masih "aktif" dan tanggal_pengembalian_real masih null
        if ($this->status === 'aktif' && is_null($this->tanggal_pengembalian_real)) {
            $tanggalPengembalian = Carbon::parse($this->tanggal_pengembalian);
            $hariKeterlambatan = $tanggalPengembalian->diffInDays(Carbon::now(), false); // hitung selisih hari

            if ($hariKeterlambatan > 0) {
                // Hitung denda dan bulatkan ke kelipatan 500
                $denda = ceil($hariKeterlambatan * 500 / 500) * 500;
                return $denda;
            }
        }

        return $this->attributes['denda'];
    }



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
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'id_kategori');
    }
}
