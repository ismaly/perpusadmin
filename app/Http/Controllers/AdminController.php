<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBuku;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PDF;


class AdminController extends Controller
{
    public function dashboard()
    {
        $jumlahAnggota = Anggota::count();
        $jumlahBuku = Buku::count();
        $buku = Buku::all();
        return view('Admin.dashboard', compact('buku', 'jumlahAnggota', 'jumlahBuku')); // Mengirim variabel $nama ke view
    }


    public function search(Request $request)
    {
        if ($request->has('search')) {
            $search = $request->search;
            $buku = Buku::where('judul_buku', 'LIKE', "%{$search}%")->get();
        } else {
            $buku = Buku::all();
        }
        return view('Admin.template.search-results', compact('buku'));
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

    public function exportPDFKategori()
    {
        $daftarkategori = KategoriBuku::all(); // Ambil semua kategori buku

        // Load view yang akan di-convert menjadi PDF
        $pdf = PDF::loadView('Admin.Data Kategori.exportKategori', compact('daftarkategori'));

        // Tampilkan PDF di browser sebelum diunduh
        return $pdf->stream('daftar_kategori.pdf');
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
            'kode_buku' => 'required|string|max:100',
            'judul_buku' => 'required|string|max:100',
            'jenis_buku' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'image_buku' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori_id' => 'required|exists:KategoriBuku,id_kategori',
        ]);

        // Cek apakah judul buku dan kategori yang sama sudah ada
        $cekBuku = Buku::where('kode_buku', $request->kode_buku)->first();

        if ($cekBuku) {
            return redirect()->back()->with('error', 'Kode Buku tersebut sudah digunakan!');
        }

        // Memproses unggahan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image_buku')) {
            $imagePath = $request->file('image_buku')->store('images/buku', 'public');
        }

        // Menyimpan data ke tabel Buku, termasuk image_buku dan kategori_id
        Buku::create([
            'kode_buku' => $request->kode_buku,
            'judul_buku' => $request->judul_buku,
            'jenis_buku' => $request->jenis_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'image_buku' => $imagePath, // Menyimpan path gambar
            'kategori_id' => $request->kategori_id, // Menyimpan kategori_id
        ]);

        // Redirect setelah berhasil menyimpan data
        return redirect()->route('DaftarBuku')->with('success', 'Buku berhasil ditambahkan!');
    }


    public function updateBuku(Request $request, $id_buku)
    {
        // Validasi input dari form sesuai dengan struktur tabel Buku
        $request->validate([
            'kode_buku' => 'required|string|max:100',
            'judul_buku' => 'required|string|max:100', // Pengecekan unique untuk judul buku, kecuali yang sedang diupdate
            'jenis_buku' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'), // Validasi untuk tahun terbit
            'image_buku' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar buku (nullable)
            'kategori_id' => 'required|exists:KategoriBuku,id_kategori', // Validasi kategori_id
        ]);


        // Mencari buku berdasarkan ID
        $buku = Buku::findOrFail($id_buku);

        // Cek apakah judul buku dengan kategori yang sama sudah ada, kecuali buku yang sedang diupdate
        $cekBuku = Buku::where('kode_buku', $request->kode_buku)->first();

        if ($cekBuku) {
            // Jika buku sudah ada, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Kode Buku sudah digunakan!');
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
            'kode_buku' => $request->kode_buku,
            'judul_buku' => $request->judul_buku,
            'jenis_buku' => $request->jenis_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'image_buku' => $imagePath, // Menyimpan path gambar
            'kategori_id' => $request->kategori_id, // Mengupdate kategori_id
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

    public function exportPDFBuku()
    {
        $daftarbuku = Buku::with('kategori')->get(); // Ambil semua kategori buku

        // Load view yang akan di-convert menjadi PDF
        $pdf = PDF::loadView('Admin.Data Buku.exportBuku', compact('daftarbuku'));

        // Tampilkan PDF di browser sebelum diunduh
        return $pdf->stream('daftar_buku.pdf');
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

    public function exportPDFAnggota()
    {
        $daftaranggota = Anggota::all();

        // Load view yang akan di-convert menjadi PDF
        $pdf = PDF::loadView('Admin.Data User.exportAnggota', compact('daftaranggota'));

        // Tampilkan PDF di browser sebelum diunduh
        return $pdf->stream('daftar_anggota.pdf');
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
            'role' => 'required|string|in:petugas,admin', // Validasi role
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
            'role' => $request->role, // Menyimpan role
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
            'role' => 'required|string|in:petugas,admin', // Validasi role
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
            'role' => $request->role, // Menyimpan role
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
    public function exportPDFPetugas()
    {
        $daftarpetugas = User::all();

        // Load view yang akan di-convert menjadi PDF
        $pdf = PDF::loadView('Admin.Data User.exportPetugas', compact('daftarpetugas'));

        // Tampilkan PDF di browser sebelum diunduh
        return $pdf->stream('daftar_petugas.pdf');
    }

    //peminjaman
    public function DaftarPeminjamanBuku()
    {
        $daftarpeminjaman = Transaksi::with(['buku', 'kategori', 'anggota'])->get(); // Menggunakan eager loading untuk mengambil relasi buku, kategori, dan anggota
        return view('Admin.Data Peminjaman.DaftarPeminjamanBuku', compact('daftarpeminjaman'));
    }

    public function FormPeminjamanBuku($id_transaksi = null)
    {
        // Jika ID diberikan, ambil data peminjaman
        $peminjaman = $id_transaksi ? Transaksi::find($id_transaksi) : null;

        // Ambil semua buku, anggota, dan kategori untuk dropdown
        $bukuList = Buku::with('kategori')->get();  // Pastikan ada relasi dengan kategori
        $anggotaList = Anggota::all();
        return view('Admin.Data Peminjaman.TambahPeminjamanBuku', compact('peminjaman', 'bukuList', 'anggotaList'));
    }
    // Menyimpan data peminjaman baru
    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:Buku,id_buku',
            'id_anggota' => 'required|exists:Anggota,id_anggota',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
        ]);

        // Cek apakah anggota sudah meminjam buku yang sama dengan status aktif
        $existingPeminjaman = Transaksi::where('id_buku', $request->id_buku)
            ->where('id_anggota', $request->id_anggota)
            ->where('status', 'aktif')
            ->first();

        if ($existingPeminjaman) {
            return redirect()->route('DaftarPeminjamanBuku')->with('error', 'Anggota ini sudah meminjam buku yang sama dengan status aktif.');
        }

        // Jika tidak ada peminjaman aktif, buat peminjaman baru
        Transaksi::create([
            'id_buku' => $request->id_buku,
            'id_anggota' => $request->id_anggota,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => 'aktif', // Status saat peminjaman dibuat
        ]);

        return redirect()->route('DaftarPeminjamanBuku')->with('success', 'Peminjaman buku berhasil ditambahkan!');
    }

    // Memperbarui data peminjaman
    public function updatePeminjaman(Request $request, $id_transaksi)
    {
        $request->validate([
            'id_buku' => 'required|exists:Buku,id_buku',
            'id_anggota' => 'required|exists:Anggota,id_anggota',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
        ]);

        // Mencari peminjaman berdasarkan ID
        $peminjaman = Transaksi::findOrFail($id_transaksi);
        $bukuBaru = Buku::findOrFail($request->id_buku);

        // Cek jika buku baru berbeda dari buku sebelumnya
        if ($peminjaman->id_buku != $request->id_buku) {
            // Cek apakah anggota sudah meminjam buku baru dengan status aktif
            $existingPeminjaman = Transaksi::where('id_buku', $request->id_buku)
                ->where('id_anggota', $request->id_anggota)
                ->where('status', 'aktif')
                ->first();

            if ($existingPeminjaman) {
                return redirect()->route('DaftarPeminjamanBuku')->with('error', 'Anggota ini sudah meminjam buku yang sama dengan status aktif.');
            }
        }

        // Update data peminjaman
        $peminjaman->update([
            'id_buku' => $request->id_buku,
            'id_anggota' => $request->id_anggota,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            // status tetap tidak diubah di sini
        ]);

        return redirect()->route('DaftarPeminjamanBuku')->with('success', 'Peminjaman buku berhasil diperbarui!');
    }

    public function deletePeminjaman($id_transaksi)
    {
        // Cari data peminjaman berdasarkan ID
        $peminjaman = Transaksi::findOrFail($id_transaksi);
        // Hapus data peminjaman
        $peminjaman->delete();

        return redirect()->route('DaftarPeminjamanBuku')->with('success', 'Peminjaman berhasil dihapus dan stok buku dikembalikan!');
    }

    public function exportPDFPeminjaman()
    {
        $daftarpeminjaman = Transaksi::with(['buku', 'kategori', 'anggota'])->get(); // Menggunakan eager loading untuk mengambil relasi buku, kategori, dan anggota

        // Load view yang akan di-convert menjadi PDF
        $pdf = PDF::loadView('Admin.Data Peminjaman.exportPeminjaman', compact('daftarpeminjaman'));

        // Tampilkan PDF di browser sebelum diunduh
        return $pdf->stream('daftar_peminjaman.pdf');
    }

    //pengembalian
    public function DaftarPengembalianBuku()
    {
        $daftarpengembalian = Transaksi::with(['buku.kategori', 'anggota'])->get();
        return view('Admin.Data Pengembalian.DaftarPengembalianBuku', compact('daftarpengembalian'));
    }
    public function FormPengembalianBuku($id_transaksi = null)
    {
        // Jika ID diberikan, ambil data peminjaman
        $pengembalian = $id_transaksi ? Transaksi::find($id_transaksi) : null;

        // Ambil semua buku, anggota, dan kategori untuk dropdown
        $bukuList = Buku::with('kategori')->get();  // Pastikan ada relasi dengan kategori
        $anggotaList = Anggota::all();
        return view('Admin.Data Pengembalian.TambahPengembalianBuku', compact('pengembalian', 'bukuList', 'anggotaList'));
    }

    public function updatePengembalian(Request $request, $id_transaksi)
    {
        $request->validate([
            'tanggal_pengembalian_real' => 'required|date|after_or_equal:tanggal_peminjaman',
        ]);

        // Mencari pengembalian buku berdasarkan ID
        $pengembalian = Transaksi::findOrFail($id_transaksi);

        // Update tanggal pengembalian real dan ubah status menjadi 'selesai'
        $pengembalian->update([
            'tanggal_pengembalian_real' => $request->tanggal_pengembalian_real,
            'status' => 'selesai', // Mengubah status menjadi selesai
        ]);

        return redirect()->route('DaftarPengembalianBuku')->with('success', 'Buku berhasil dikembalikan!');
    }

    public function deletePengembalian($id_transaksi)
    {
        // Cari data peminjaman berdasarkan ID
        $pengembalian = Transaksi::findOrFail($id_transaksi);

        // Hapus data peminjaman
        $pengembalian->delete();

        return redirect()->route('DaftarPengembalianBuku')->with('success', 'Pengembalian berhasil dihapus dan stok buku dikembalikan!');
    }

    public function exportPDFPengembalian()
    {
        $daftarpengembalian = Transaksi::with(['buku.kategori', 'anggota'])->get();

        // Load view yang akan di-convert menjadi PDF
        $pdf = PDF::loadView('Admin.Data Pengembalian.exportPengembalian', compact('daftarpengembalian'));

        // Tampilkan PDF di browser sebelum diunduh
        return $pdf->stream('daftar_pengembalian.pdf');
    }
}
