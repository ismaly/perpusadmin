<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    // Menentukan nama tabel jika tidak mengikuti konvensi pluralisasi default Laravel
    protected $table = 'Anggota';

    // Menentukan primary key tabel
    protected $primaryKey = 'id_anggota';

    // Menentukan atribut yang dapat diisi secara massal
    protected $guarded = ['id_anggota'];
}
