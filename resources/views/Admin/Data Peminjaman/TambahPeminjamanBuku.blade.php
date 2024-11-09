@extends('admin.template.master')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Tambah Peminjaman Buku</h3>
                <a href="{{ route('DaftarPeminjamanBuku') }}" class="btn btn-primary btn-sm"> Kembali </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if(session('error'))
                    <div id="error-message" class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Form Peminjaman Buku</div>
                    </div>

                    <form method="POST" action="{{ isset($peminjaman) ? route('peminjaman.update', $peminjaman->id_transaksi) : route('peminjaman-store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($peminjaman))
                            @method('PUT')
                        @endif
                    
                        <div class="card-body">
                            <div class="row">
                                <!-- Dropdown Buku -->
                               <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Kode Buku</label>
                                        <select id="id_buku" name="id_buku" class="form-select" required>
                                            <option value="">Pilih Buku</option>
                                            @foreach($bukuList as $bukuItem)
                                                <option value="{{ $bukuItem->id_buku }}" {{ (isset($peminjaman) && $peminjaman->id_buku == $bukuItem->id_buku) ? 'selected' : '' }}>
                                                    {{ $bukuItem->kode_buku }} 
                                                    {{ $bukuItem->judul_buku }} 
                                                    ({{ $bukuItem->kategori->nama_kategori ?? 'Kategori tidak tersedia' }}) 
                                                    ({{ $bukuItem->kategori->lokasi_buku ?? 'Lokasi tidak tersedia' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                    
                                <!-- Dropdown Anggota -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Nama Anggota</label>
                                        <select id="id_anggota" name="id_anggota" class="form-select" required>
                                            <option value="">Pilih Anggota</option>
                                            @foreach($anggotaList as $anggotaItem)
                                                <option value="{{ $anggotaItem->id_anggota }}" {{ (isset($peminjaman) && $peminjaman->id_anggota == $anggotaItem->id_anggota) ? 'selected' : '' }}>
                                                    {{ $anggotaItem->nama }} ({{ $anggotaItem->nis ?? 'NIS tidak tersedia' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <!-- Tanggal Peminjaman -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Tanggal Peminjaman</label>
                                        <input type="date" name="tanggal_peminjaman" class="form-control" value="{{ isset($peminjaman) ? $peminjaman->tanggal_peminjaman : old('tanggal_peminjaman') }}" required>
                                    </div>
                                </div>
                    
                                <!-- Tanggal Pengembalian -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Tanggal Pengembalian</label>
                                        <input type="date" name="tanggal_pengembalian" class="form-control" value="{{ isset($peminjaman) ? $peminjaman->tanggal_pengembalian : old('tanggal_pengembalian') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">{{ isset($peminjaman) ? 'Perbarui' : 'Tambah' }}</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection






