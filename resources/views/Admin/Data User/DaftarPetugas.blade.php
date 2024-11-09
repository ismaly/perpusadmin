@extends('admin.template.master')
@section('content')
<div class="container">
  <div class="page-inner">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
          <h3 class="fw-bold mb-3">Daftar Petugas</h3>
          @if(Auth::check() && Auth::user()->role != 'petugas') <!-- Check if user is not 'petugas' -->
          <a href="{{ route ('FormPetugas') }}" class="btn btn-primary btn-sm"> Tambah Data </a>
          @endif
          <a href="{{ route('exportPDFPetugas') }}" class="btn btn-success btn-sm"> Export PDF </a>
        </div>
      </div>

      <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                    <div id="success-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div id="error-message" class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

              <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 1%">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    @if(Auth::check() && Auth::user()->role != 'petugas') <!-- Check if user is not 'petugas' -->
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($daftarPetugas as $index => $petugas)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $petugas->name }}</td>
                                        <td>{{ $petugas->email }}</td>
                                        <td>{{ $petugas->role }}</td>
                                        @if(Auth::check() && Auth::user()->role != 'petugas') <!-- Check if user is not 'petugas' -->
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" class="btn btn-link btn-primary btn-lg" 
                                                        data-bs-toggle="modal" data-bs-target="#modalDetailPetugas{{ $petugas->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <a href="{{ route('FormPetugas', $petugas->id) }}" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-link btn-danger btn-lg" 
                                                        data-bs-toggle="modal" data-bs-target="#modalHapusPetugas{{ $petugas->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                        
                                    {{-- Modal Detail Petugas --}}
                                    <div class="modal fade" id="modalDetailPetugas{{ $petugas->id }}" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalDetailLabel">Detail Anggota</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label><strong>Nama:</strong></label>
                                                        <p>{{ $petugas->name }}</p>
                                                        <label><strong>Email:</strong></label>
                                                        <p>{{ $petugas->email }}</p>
                                                        <label><strong>Role:</strong></label>
                                                        <p>{{ $petugas->role }}</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        
                                    {{-- Modal Hapus Petugas --}}
                                    <div class="modal fade" id="modalHapusPetugas{{ $petugas->id }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus Petugas <strong>{{ $petugas->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('petugas-delete', $petugas->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>  
                </div>
              </div>
            </div>
        </div> 
    </div>
</div>
@endsection