<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

Route::get('DaftarKategoriBuku', [AdminController::class, 'DaftarKategoriBuku'])->name('DaftarKategoriBuku');
Route::get('FormKategoriBuku/{id_kategori?}', [AdminController::class, 'FormKategoriBuku'])->name('FormKategoriBuku');
Route::post('kategori-buku-store', [AdminController::class, 'storeKategori'])->name('kategori-buku-store');
Route::delete('kategori-delete/{id_kategori}', [AdminController::class, 'deleteKategori'])->name('kategori-delete');
Route::put('kategori/{id_kategori}', [AdminController::class, 'updateKategori'])->name('kategori.update');

Route::get('DaftarBuku', [AdminController::class, 'DaftarBuku'])->name('DaftarBuku');
Route::get('FormBuku/{id_buku?}', [AdminController::class, 'FormBuku'])->name('FormBuku');
Route::post('buku-store', [AdminController::class, 'storeBuku'])->name('buku-store');
Route::delete('buku-delete/{id_buku}', [AdminController::class, 'deleteBuku'])->name('buku-delete');
Route::put('buku/{id_buku}', [AdminController::class, 'updateBuku'])->name('buku.update');


Route::get('DaftarAnggota', [AdminController::class, 'DaftarAnggota'])->name('DaftarAnggota');
Route::get('FormAnggota/{id_anggota?}', [AdminController::class, 'FormAnggota'])->name('FormAnggota');
Route::post('anggota-store', [AdminController::class, 'storeAnggota'])->name('anggota-store');
Route::delete('anggota-delete/{id_anggota}', [AdminController::class, 'deleteAnggota'])->name('anggota-delete');
Route::put('anggota/{id_anggota}', [AdminController::class, 'updateAnggota'])->name('anggota.update');

Route::get('DaftarPetugas', [AdminController::class, 'DaftarPetugas'])->name('DaftarPetugas');
Route::get('FormPetugas/{id?}', [AdminController::class, 'FormPetugas'])->name('FormPetugas');
Route::post('petugas-store', [AdminController::class, 'storePetugas'])->name('petugas-store');
Route::delete('petugas-delete/{id}', [AdminController::class, 'deletePetugas'])->name('petugas-delete');
Route::put('petugas/{id}', [AdminController::class, 'updatePetugas'])->name('petugas.update');

Route::get('DaftarPeminjamanBuku', [AdminController::class, 'DaftarPeminjamanBuku'])->name('DaftarPeminjamanBuku');
Route::get('FormPeminjaman/{id_peminjaman?}', [AdminController::class, 'FormPeminjaman'])->name('FormPeminjaman');
