<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    use HasFactory;

    protected $table = 'KategoriBuku';
    protected $primaryKey = 'id_kategori';


    protected $fillable = [
        'nama_kategori',
        // 'jenis_kategori',
        'lokasi_buku'
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id', 'id_kategori');
    }
}
