<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    // Menentukan nama tabel jika tidak mengikuti konvensi pluralisasi default Laravel
    protected $table = 'Buku';

    // Menentukan primary key tabel
    protected $primaryKey = 'id_buku';

    // Mengatur tipe primary key jika bukan auto-increment integer
    public $incrementing = true;
    protected $keyType = 'int';

    // Menentukan atribut yang dapat diisi secara massal
    protected $guarded = ['id_buku'];

    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id');
    }

    // Menonaktifkan timestamp jika tidak digunakan
    public $timestamps = true;
}
