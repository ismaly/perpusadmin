@extends('admin.template.master')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Edit Pengembalian Buku</h3>
                <a href="{{ route('DaftarPengembalianBuku') }}" class="btn btn-primary btn-sm"> Kembali </a>
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
                        <div class="card-title">Form Pengembalian Buku</div>
                    </div>

                    <form method="POST" action="{{ route('pengembalian.update', $pengembalian->id_transaksi) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Peminjam (Read-Only) -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Nama Peminjam</label>
                                        <input type="text" class="form-control" value="{{ $pengembalian->anggota->nama }}" readonly>
                                    </div>
                                </div>
                    
                                <!-- Judul Buku (Read-Only) -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Kode dan Judul Buku</label>
                                        <input type="text" class="form-control" value="({{ $pengembalian->buku->kode_buku }}) {{ $pengembalian->buku->judul_buku }}" readonly>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <!-- Tanggal Peminjaman (Read-Only) -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Tanggal Peminjaman</label>
                                        <input type="date" class="form-control" value="{{ $pengembalian->tanggal_peminjaman }}" readonly>
                                    </div>
                                </div>
                    
                                <!-- Tanggal Pengembalian (Read-Only) -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Tanggal Pengembalian</label>
                                        <input type="date" class="form-control" value="{{ $pengembalian->tanggal_pengembalian }}" readonly>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <!-- Denda (Read-Only) -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Total Denda</label>
                                        <input type="text" class="form-control" value="{{ $pengembalian->denda }}" readonly>
                                    </div>
                                </div>
                    
                                <!-- Tanggal Pengembalian Real (Editable) -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group form-group-default">
                                        <label>Tanggal Pengembalian </label>
                                        <input type="date" name="tanggal_pengembalian_real" class="form-control" value="{{ $pengembalian->tanggal_pengembalian_real ?? \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Kembalikan Buku</button>
                            <button type="reset" class="btn btn-danger">Batal</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection






