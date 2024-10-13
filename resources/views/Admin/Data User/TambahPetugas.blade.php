@extends('admin.template.master')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Tambah Petugas</h3>
                <a href="{{ route('DaftarPetugas') }}" class="btn btn-primary btn-sm"> Kembali </a>
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
                        <div class="card-title">Form Petugas</div>
                    </div>

                    <form method="POST" action="{{ isset($petugas) ? route('petugas.update', $petugas->id) : route('petugas-store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($petugas))
                        @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-9">
                                    <div class="form-group form-group-default">
                                        <label>Nama</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            value="{{ old('name', isset($petugas) ? $petugas->name : '') }}" required>
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <input id="email" name="email" type="email" class="form-control"
                                            value="{{ old('email', isset($petugas) ? $petugas->email : '') }}">
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label>Password</label>
                                        <input id="password" name="password" type="password" class="form-control"
                                            value="{{ old('password', isset($petugas) ? $petugas->password : '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-action">
                            <button type="submit" class="btn btn-success">{{ isset($petugas) ? 'Perbarui' : 'Tambah' }}</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection