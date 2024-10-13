@extends('admin.template.master')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Tambah Anggota</h3>
                <a href="{{ route('DaftarAnggota') }}" class="btn btn-primary btn-sm"> Kembali </a>
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
                        <div class="card-title">Form Anggota</div>
                    </div>

                    <form method="POST" action="{{ isset($anggota) ? route('anggota.update', $anggota->id_anggota) : route('anggota-store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($anggota))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-9">
                                    <div class="form-group form-group-default">
                                        <label>NIS</label>
                                        <input id="nis" name="nis" type="number" class="form-control" 
                                               value="{{ old('nis', isset($anggota) ? $anggota->nis : '') }}" required>
                                    </div>
                        
                                    <div class="form-group form-group-default">
                                        <label>Nama</label>
                                        <input id="nama" name="nama" type="text" class="form-control" 
                                               value="{{ old('nama', isset($anggota) ? $anggota->nama : '') }}" required>
                                    </div>
                        
                                    <div class="form-group form-group-default">
                                        <label>Tanggal Lahir</label>
                                        <input id="tgl_lahir" name="tgl_lahir" type="date" class="form-control" 
                                               value="{{ old('tgl_lahir', isset($anggota) ? $anggota->tgl_lahir : '') }}" required>
                                    </div>
                        
                                    <div class="form-group form-group-default">
                                        <label>Kelas</label>
                                        <input id="kelas" name="kelas" type="text" class="form-control" 
                                               value="{{ old('kelas', isset($anggota) ? $anggota->kelas : '') }}" required>
                                    </div>
                        
                                    <div class="form-group form-group-default">
                                        <label>Alamat</label>
                                        <input id="alamat" name="alamat" type="text" class="form-control" 
                                               value="{{ old('alamat', isset($anggota) ? $anggota->alamat : '') }}" required>
                                    </div>
                        
                                    <div class="form-group form-group-default">
                                        <label>Jenis Kelamin</label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ (isset($anggota) && $anggota->jenis_kelamin == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ (isset($anggota) && $anggota->jenis_kelamin == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                        
                                    <div class="form-group form-group-default">
                                        <label>No. Telepon</label>
                                        <input id="no_telepon" name="no_telepon" type="text" class="form-control" 
                                               value="{{ old('no_telepon', isset($anggota) ? $anggota->no_telepon : '') }}">
                                    </div>
                        
                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <input id="email" name="email" type="email" class="form-control" 
                                               value="{{ old('email', isset($anggota) ? $anggota->email : '') }}">
                                    </div>
                        
                                    <div class="form-group form-group-default">
                                        <label>Status Anggota</label>
                                        <select id="status_anggota" name="status_anggota" class="form-select" required>
                                            <option value="">Pilih Status</option>
                                            <option value="aktif" {{ (isset($anggota) && $anggota->status_anggota == 'aktif') ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ (isset($anggota) && $anggota->status_anggota == 'nonaktif') ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">{{ isset($anggota) ? 'Perbarui' : 'Tambah' }}</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
