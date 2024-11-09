<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Rute untuk login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk registrasi
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');


Route::middleware(['auth.perpus'])->group(function () {
    Route::get('header', [AdminController::class, 'header'])->name('header');
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard/search', [AdminController::class, 'search'])->name('dashboard.search');


    Route::get('DaftarKategoriBuku', [AdminController::class, 'DaftarKategoriBuku'])->name('DaftarKategoriBuku');
    Route::get('FormKategoriBuku/{id_kategori?}', [AdminController::class, 'FormKategoriBuku'])->name('FormKategoriBuku');
    Route::post('kategori-buku-store', [AdminController::class, 'storeKategori'])->name('kategori-buku-store');
    Route::delete('kategori-delete/{id_kategori}', [AdminController::class, 'deleteKategori'])->name('kategori-delete');
    Route::put('kategori/{id_kategori}', [AdminController::class, 'updateKategori'])->name('kategori.update');
    Route::get('kategori/export-pdf', [AdminController::class, 'exportPDFKategori'])->name('exportPDFKategori');


    Route::get('DaftarBuku', [AdminController::class, 'DaftarBuku'])->name('DaftarBuku');
    Route::get('FormBuku/{id_buku?}', [AdminController::class, 'FormBuku'])->name('FormBuku');
    Route::post('buku-store', [AdminController::class, 'storeBuku'])->name('buku-store');
    Route::delete('buku-delete/{id_buku}', [AdminController::class, 'deleteBuku'])->name('buku-delete');
    Route::put('buku/{id_buku}', [AdminController::class, 'updateBuku'])->name('buku.update');
    Route::get('buku/export-pdf', [AdminController::class, 'exportPDFBuku'])->name('exportPDFBuku');


    Route::get('DaftarAnggota', [AdminController::class, 'DaftarAnggota'])->name('DaftarAnggota');
    Route::get('FormAnggota/{id_anggota?}', [AdminController::class, 'FormAnggota'])->name('FormAnggota');
    Route::post('anggota-store', [AdminController::class, 'storeAnggota'])->name('anggota-store');
    Route::delete('anggota-delete/{id_anggota}', [AdminController::class, 'deleteAnggota'])->name('anggota-delete');
    Route::put('anggota/{id_anggota}', [AdminController::class, 'updateAnggota'])->name('anggota.update');
    Route::get('anggota/export-pdf', [AdminController::class, 'exportPDFAnggota'])->name('exportPDFAnggota');

    Route::get('DaftarPetugas', [AdminController::class, 'DaftarPetugas'])->name('DaftarPetugas');
    Route::get('FormPetugas/{id?}', [AdminController::class, 'FormPetugas'])->name('FormPetugas');
    Route::post('petugas-store', [AdminController::class, 'storePetugas'])->name('petugas-store');
    Route::delete('petugas-delete/{id}', [AdminController::class, 'deletePetugas'])->name('petugas-delete');
    Route::put('petugas/{id}', [AdminController::class, 'updatePetugas'])->name('petugas.update');
    Route::get('petugas/export-pdf', [AdminController::class, 'exportPDFPetugas'])->name('exportPDFPetugas');

    Route::get('DaftarPeminjamanBuku', [AdminController::class, 'DaftarPeminjamanBuku'])->name('DaftarPeminjamanBuku');
    Route::get('FormPeminjamanBuku/{id_transaksi?}', [AdminController::class, 'FormPeminjamanBuku'])->name('FormPeminjamanBuku');
    Route::post('peminjaman-store', [AdminController::class, 'storePeminjaman'])->name('peminjaman-store');
    Route::delete('peminjaman-delete/{id_transaksi}', [AdminController::class, 'deletePeminjaman'])->name('peminjaman-delete');
    Route::put('peminjaman/{id_transaksi}', [AdminController::class, 'updatePeminjaman'])->name('peminjaman.update');
    Route::get('peminjaman/export-pdf', [AdminController::class, 'exportPDFPeminjaman'])->name('exportPDFPeminjaman');

    Route::get('DaftarPengembalianBuku', [AdminController::class, 'DaftarPengembalianBuku'])->name('DaftarPengembalianBuku');
    Route::get('FormPengembalianBuku/{id_transaksi?}', [AdminController::class, 'FormPengembalianBuku'])->name('FormPengembalianBuku');
    Route::post('pengembalian-store', [AdminController::class, 'storePengembalian'])->name('pengembalian-store');
    Route::delete('pengembalian-delete/{id_transaksi}', [AdminController::class, 'deletePengembalian'])->name('pengembalian-delete');
    Route::put('pengembalian/{id_transaksi}', [AdminController::class, 'updatePengembalian'])->name('pengembalian.update');
    Route::get('pengembalian/export-pdf', [AdminController::class, 'exportPDFPengembalian'])->name('exportPDFPengembalian');
});
