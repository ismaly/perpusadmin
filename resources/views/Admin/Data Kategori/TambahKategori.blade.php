@extends('admin.template.master')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Tambah Kategori Buku</h3>
                <a href="{{ route('DaftarKategoriBuku') }}" class="btn btn-primary btn-sm"> Kembali </a>
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
                        <div class="card-title">Form Kategori</div>
                    </div>

                    <form method="POST" action="{{ isset($kategori) ? route('kategori.update', $kategori->id_kategori) : route('kategori-buku-store') }}">
                        @csrf
                        @if(isset($kategori))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-9">
                                    <div class="form-group form-group-default">
                                        <label>Nama Kategori</label>
                                        <input id="nama_kategori" name="nama_kategori" type="text" class="form-control" 
                                               value="{{ old('nama_kategori', isset($kategori) ? $kategori->nama_kategori : '') }}" required>
                                    </div>

                                    {{-- <div class="form-group form-group-default">
                                        <label>Jenis Kategori</label>
                                        <input id="jenis_kategori" name="jenis_kategori" type="text" class="form-control" 
                                               value="{{ old('jenis_kategori', isset($kategori) ? $kategori->jenis_kategori : '') }}" required>
                                    </div> --}}

                                    <div class="form-group form-group-default">
                                        <label>Lokasi Buku</label>
                                        <input id="lokasi_buku" name="lokasi_buku" type="text" class="form-control" 
                                               value="{{ old('lokasi_buku', isset($kategori) ? $kategori->lokasi_buku : '') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">{{ isset($kategori) ? 'Perbarui' : 'Tambah' }}</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
