@extends('admin.template.master')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Tambah Peminjaman Buku</h3>
                <a href="{{ route('DaftarBuku') }}" class="btn btn-primary btn-sm"> Kembali </a>
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
                        <div class="card-title">Form Buku</div>
                    </div>

                    <form method="POST" action="{{ isset($buku) ? route('buku.update', $buku->id_buku) : route('buku-store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($buku))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-9">
                                    <div class="form-group form-group-default">
                                        <label>Kategori</label>
                                        <select id="nama_kategori" name="kategori_id" class="form-select" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategoriList as $kategoriItem)
                                                <option value="{{ $kategoriItem->id_kategori }}" {{ (isset($buku) && $buku->kategori_id == $kategoriItem->id_kategori) ? 'selected' : '' }}>
                                                    {{ $kategoriItem->nama_kategori }} ( {{ $kategoriItem->lokasi_buku ?? 'Lokasi tidak tersedia' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Judul Buku</label>
                                        <input id="judul_buku" name="judul_buku" type="text" class="form-control" 
                                               value="{{ old('judul_buku', isset($buku) ? $buku->judul_buku : '') }}" required>
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label>Jenis Buku</label>
                                        <input id="jenis_buku" name="jenis_buku" type="text" class="form-control" 
                                               value="{{ old('jenis_buku', isset($buku) ? $buku->jenis_buku : '') }}" required>
                                    </div>
                                
                                    <div class="form-group form-group-default">
                                        <label>Penulis</label>
                                        <input id="penulis" name="penulis" type="text" class="form-control" 
                                               value="{{ old('penulis', isset($buku) ? $buku->penulis : '') }}" required>
                                    </div>
                
                                    <div class="form-group form-group-default">
                                        <label>Penerbit</label>
                                        <input id="penerbit" name="penerbit" type="text" class="form-control" 
                                               value="{{ old('penerbit', isset($buku) ? $buku->penerbit : '') }}" required>
                                    </div>
                
                                    <div class="form-group form-group-default">
                                        <label>Tahun Terbit</label>
                                        <input id="tahun_terbit" name="tahun_terbit" type="number" class="form-control" 
                                               value="{{ old('tahun_terbit', isset($buku) ? $buku->tahun_terbit : '') }}" required>
                                    </div>
                
                                    <div class="form-group form-group-default">
                                        <label>Gambar Buku</label>
                                        <input type="file" id="image_buku" name="image_buku" class="form-control" 
                                               {{ isset($buku) ? '' : 'required' }}>
                                        @if(isset($buku) && $buku->image_buku)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $buku->image_buku) }}" alt="Gambar Buku" class="img-fluid" style="max-width: 100px; height: auto;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">{{ isset($buku) ? 'Perbarui' : 'Tambah' }}</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
