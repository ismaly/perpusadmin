<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBuku;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\User;
use App\Models\PeminjamanBuku;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('Admin.dashboard');
    }

    ///kategori
    public function DaftarKategoriBuku()
    {
        $daftarkategori = KategoriBuku::all();
        return view('Admin.Data Kategori.DaftarKategoriBuku', compact('daftarkategori'));
    }

    public function FormKategoriBuku($id_kategori = null)
    {
        // Jika ID diberikan, ambil data kategori
        $kategori = $id_kategori ? KategoriBuku::find($id_kategori) : null;
        return view('Admin.Data Kategori.TambahKategori', compact('kategori'));
    }

    public function storeKategori(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_kategori' => 'required|string|max:50',
            'lokasi_buku' => 'required|string|max:50', // Validasi lokasi buku agar unik
        ]);

        // Cek apakah kombinasi nama kategori dan lokasi buku sudah ada
        $existingKategori = KategoriBuku::where('lokasi_buku', $request->lokasi_buku)
            ->where('nama_kategori', $request->nama_kategori)
            ->first();

        if ($existingKategori) {
            // Jika kombinasi sudah ada, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Lokasi dengan kategori yang sama sudah digunakan !');
        }

        // Jika kategori belum ada, tambahkan ke tabel KategoriBuku
        KategoriBuku::create($request->all());

        // Redirect setelah berhasil menyimpan data
        return redirect()->route('DaftarKategoriBuku')->with('success', 'Kategori Buku berhasil ditambahkan!');
    }

    public function updateKategori(Request $request, $id_kategori)
    {
        // Validasi input dari form
        $request->validate([
            'nama_kategori' => 'required|string|max:50',
            'lokasi_buku' => 'required|string|max:50,' // Validasi lokasi buku agar unik kecuali untuk kategori yang sedang diupdate
        ]);

        // Cek apakah kombinasi nama kategori dan lokasi buku sudah ada
        $existingKategori = KategoriBuku::where('lokasi_buku', $request->lokasi_buku)
            ->where('nama_kategori', $request->nama_kategori)
            ->first();

        if ($existingKategori) {
            // Jika kombinasi sudah ada, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Lokasi dengan kategori yang sama sudah digunakan !');
        }

        // Mengambil kategori yang akan diperbarui
        $kategori = KategoriBuku::findOrFail($id_kategori);
        $kategori->update($request->all());

        // Redirect setelah berhasil mengupdate data
        return redirect()->route('DaftarKategoriBuku')->with('success', 'Kategori Buku berhasil diperbarui!');
    }


    public function deleteKategori($id_kategori)
    {
        $kategori = KategoriBuku::findOrFail($id_kategori);
        $kategori->delete();

        return redirect()->route('DaftarKategoriBuku')->with('success', 'Kategori Buku berhasil dihapus!');
    }


    ///Buku
    public function DaftarBuku()
    {
        $daftarbuku = Buku::with('kategori')->get(); // Menggunakan eager loading untuk mengambil relasi kategori
        return view('Admin.Data Buku.DaftarBuku', compact('daftarbuku'));
    }

    public function FormBuku($id_buku = null)
    {
        // Jika ID diberikan, ambil data buku
        $buku = $id_buku ? Buku::find($id_buku) : null;
        $kategoriList = KategoriBuku::all();  // Ambil semua kategori untuk dropdown
        return view('Admin.Data Buku.TambahBuku', compact('buku', 'kategoriList'));
    }

    public function storeBuku(Request $request)
    {
        // Validasi input dari form sesuai dengan struktur tabel Buku
        $request->validate([
            'judul_buku' => 'required|string|max:100',
            'jenis_buku' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'image_buku' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori_id' => 'required|exists:KategoriBuku,id_kategori',
            'stok' => 'required|integer|min:0',
        ]);

        // Cek apakah judul buku dengan kategori yang sama sudah ada
        $existingBuku = Buku::where('judul_buku', $request->judul_buku)
            ->where('kategori_id', $request->kategori_id)
            ->first();

        if ($existingBuku) {
            // Jika buku sudah ada, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Buku dengan judul tersebut sudah ada dalam kategori ini!');
        }

        // Memproses unggahan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image_buku')) {
            $imagePath = $request->file('image_buku')->store('images/buku', 'public');
        }

        // Menyimpan data ke tabel Buku, termasuk image_buku dan stok
        Buku::create([
            'judul_buku' => $request->judul_buku,
            'jenis_buku' => $request->jenis_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'image_buku' => $imagePath, // Menyimpan path gambar
            'kategori_id' => $request->kategori_id, // Menyimpan kategori_id
            'stok' => $request->stok, // Menyimpan stok buku
        ]);

        // Redirect setelah berhasil menyimpan data
        return redirect()->route('DaftarBuku')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function updateBuku(Request $request, $id_buku)
    {
        // Validasi input dari form sesuai dengan struktur tabel Buku
        $request->validate([
            'judul_buku' => 'required|string|max:100', // Pengecekan unique untuk judul buku, kecuali yang sedang diupdate
            'jenis_buku' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'), // Validasi untuk tahun terbit
            'image_buku' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar buku (nullable)
            'kategori_id' => 'required|exists:KategoriBuku,id_kategori', // Validasi kategori_id
            'stok' => 'required|integer|min:0', // Validasi untuk stok buku
        ]);

        // Mencari buku berdasarkan ID
        $buku = Buku::findOrFail($id_buku);

        // Cek apakah judul buku dengan kategori yang sama sudah ada
        $existingBuku = Buku::where('judul_buku', $request->judul_buku)
            ->where('kategori_id', $request->kategori_id)
            ->first();

        if ($existingBuku) {
            // Jika buku sudah ada, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Buku dengan judul tersebut sudah ada dalam kategori ini!');
        }

        // Memproses unggahan gambar jika ada
        $imagePath = $buku->image_buku; // Simpan path gambar lama secara default

        if ($request->hasFile('image_buku')) {
            // Menghapus gambar lama jika ada
            if ($buku->image_buku) {
                Storage::disk('public')->delete($buku->image_buku);
            }

            // Menggunakan storage untuk menyimpan file dan mendapatkan path
            $imagePath = $request->file('image_buku')->store('images/buku', 'public');
        }

        // Mengupdate data buku
        $buku->update([
            'judul_buku' => $request->judul_buku,
            'jenis_buku' => $request->jenis_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'image_buku' => $imagePath, // Menyimpan path gambar
            'kategori_id' => $request->kategori_id, // Mengupdate kategori_id
            'stok' => $request->stok, // Mengupdate stok buku
        ]);

        // Redirect setelah berhasil mengupdate data
        return redirect()->route('DaftarBuku')->with('success', 'Buku berhasil diperbarui!');
    }

    public function deleteBuku($id_buku)
    {
        $buku = Buku::findOrFail($id_buku);
        $buku->delete();

        return redirect()->route('DaftarBuku')->with('success', 'Buku berhasil dihapus!');
    }

    //Data Anggota
    public function DaftarAnggota()
    {
        $daftarAnggota = Anggota::all(); // Ambil semua data anggota
        return view('Admin.Data User.DaftarAnggota', compact('daftarAnggota'));
    }

    public function FormAnggota($id_anggota = null)
    {
        // Jika ID diberikan, ambil data buku
        $anggota = $id_anggota ? Anggota::find($id_anggota) : null;
        return view('Admin.Data User.TambahAnggota', compact('anggota'));
    }

    public function storeAnggota(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nis' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'kelas' => 'required|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'status_anggota' => 'required|in:aktif,nonaktif',
        ]);
        // Cek apakah kombinasi nama kategori dan lokasi buku sudah ada
        $existingAnggota = Anggota::where('nis', $request->nis)
            ->where('nama', $request->nama)
            ->where('no_telepon', $request->no_telepon)
            ->where('email', $request->email)
            ->first();

        if ($existingAnggota) {
            // Jika kombinasi sudah ada, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Nis sudah digunakan !');
        }

        // Menyimpan data ke tabel Anggota
        Anggota::create($request->all());

        // Redirect setelah berhasil menyimpan data
        return redirect()->route('DaftarAnggota')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function updateAnggota(Request $request, $id_anggota)
    {
        // Validasi input dari form
        $request->validate([
            'nis' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'kelas' => 'required|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'status_anggota' => 'required|in:aktif,nonaktif',
        ]);

        // Mengambil data anggota yang akan diperbarui
        $anggota = Anggota::findOrFail($id_anggota);

        // Cek apakah NIS yang diinput sudah ada, kecuali untuk anggota yang sedang diperbarui
        $existingAnggota = Anggota::where('nis', $request->nis)
            ->where('nama', $request->nama)
            ->where('no_telepon', $request->no_telepon)
            ->where('email', $request->email)
            ->first();

        if ($existingAnggota) {
            // Jika NIS sudah digunakan, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'NIS/No Hp/Gmail sudah digunakan oleh anggota lain !');
        }

        // Mengupdate data anggota
        $anggota->update($request->all());

        // Redirect setelah berhasil memperbarui data
        return redirect()->route('DaftarAnggota')->with('success', 'Anggota berhasil diperbarui!');
    }

    public function deleteAnggota($id_anggota)
    {
        $anggota = Anggota::findOrFail($id_anggota);
        $anggota->delete();

        return redirect()->route('DaftarAnggota')->with('success', 'Anggota berhasil dihapus!');
    }

    //Data Petugas
    public function DaftarPetugas()
    {
        $daftarPetugas = User::all(); // Ambil semua data anggota
        return view('Admin.Data User.DaftarPetugas', compact('daftarPetugas'));
    }
    public function FormPetugas($id = null)
    {
        // Jika ID diberikan, ambil data buku
        $petugas = $id ? User::find($id) : null;
        return view('Admin.Data User.TambahPetugas', compact('petugas'));
    }
    public function storePetugas(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100', // Tambahkan unique untuk email
            'password' => 'required|string|min:8', // Ganti validasi password
        ]);
        // Cek apakah kombinasi nama kategori dan lokasi buku sudah ada
        $existingUser = User::where('email', $request->email)
            ->where('name', '!=', $request->name)
            ->first();

        if ($existingUser) {
            // Jika kombinasi sudah ada, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Email sudah digunakan !');
        }

        // Menyimpan data ke tabel Anggota
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // Redirect setelah berhasil menyimpan data
        return redirect()->route('DaftarPetugas')->with('success', 'Petugas berhasil ditambahkan!');
    }
    public function updatePetugas(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100', // Tambahkan unique untuk email
            'password' => 'required|string|min:8', // Ganti validasi password
        ]);

        $petugas = User::findOrFail($id);

        $existingUser = User::where('email', $request->email)
            ->where('name', '!=', $request->name)
            ->first();

        if ($existingUser) {
            // Jika kombinasi sudah ada, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Email sudah digunakan !');
        }

        // Mengupdate data anggota
        $petugas->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // Redirect setelah berhasil memperbarui data
        return redirect()->route('DaftarPetugas')->with('success', 'Petugas berhasil diperbarui!');
    }
    public function deletePetugas($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('DaftarPetugas')->with('success', 'Anggota berhasil dihapus!');
    }

    //peminjaman
    public function DaftarPeminjamanBuku()
    {
        $daftarbuku = Buku::with('kategori')->get(); // Menggunakan eager loading untuk mengambil relasi kategori
        return view('Admin.Data Peminjaman.DaftarPeminjamanBuku', compact('daftarbuku'));
    }
    public function FormPeminjamanBuku($id_peminjaman = null)
    {
        // Jika ID diberikan, ambil data buku
        $peminjaman = $id_peminjaman ? Buku::find($id_peminjaman) : null;
        $kategoriList = KategoriBuku::all();  // Ambil semua kategori untuk dropdown
        $anggotaList = Anggota::all();  // Ambil semua kategori untuk dropdown
        return view('Admin.Data Buku.TambahPeminjamanBuku', compact('peminjaman', 'kategoriList', 'angotaList'));
    }
}
