@extends('admin.template.master')
@section('content')
<div class="container">
  <div class="page-inner">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
          <h3 class="fw-bold mb-3">Daftar Anggota</h3>
          <a href="{{ route ('FormAnggota') }}" class="btn btn-primary btn-sm"> Tambah Data </a>
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
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Kelas</th>
                                    {{-- <th>Alamat</th> --}}
                                    <th>Jenis Kelamin</th>
                                    {{-- <th>No. Telepon</th>
                                    <th>Email</th> --}}
                                    <th>Status Anggota</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($daftarAnggota as $index => $anggota)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $anggota->nis }}</td>
                                        <td>{{ $anggota->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d-m-Y') }}</td>
                                        <td>{{ $anggota->kelas }}</td>
                                        {{-- <td>{{ $anggota->alamat }}</td> --}}
                                        <td>{{ $anggota->jenis_kelamin }}</td>
                                        {{-- <td>{{ $anggota->no_telepon }}</td>
                                        <td>{{ $anggota->email }}</td> --}}
                                        <td>{{ $anggota->status_anggota }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" class="btn btn-link btn-primary btn-lg" 
                                                        data-bs-toggle="modal" data-bs-target="#modalDetailAnggota{{ $anggota->id_anggota }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <a href="{{ route('FormAnggota', $anggota->id_anggota) }}" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-link btn-danger btn-lg" 
                                                        data-bs-toggle="modal" data-bs-target="#modalHapusAnggota{{ $anggota->id_anggota }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                        
                                    {{-- Modal Detail Anggota --}}
                                    <div class="modal fade" id="modalDetailAnggota{{ $anggota->id_anggota }}" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalDetailLabel">Detail Anggota</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label><strong>NIS:</strong></label>
                                                        <p>{{ $anggota->nis }}</p>
                                                        <label><strong>Nama:</strong></label>
                                                        <p>{{ $anggota->nama }}</p>
                                                        <label><strong>Tanggal Lahir:</strong></label>
                                                        <p>{{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d-m-Y') }}</p>
                                                        <label><strong>Kelas:</strong></label>
                                                        <p>{{ $anggota->kelas }}</p>
                                                        <label><strong>Alamat:</strong></label>
                                                        <p>{{ $anggota->alamat }}</p>
                                                        <label><strong>Jenis Kelamin:</strong></label>
                                                        <p>{{ $anggota->jenis_kelamin }}</p>
                                                        <label><strong>No. Telepon:</strong></label>
                                                        <p>{{ $anggota->no_telepon }}</p>
                                                        <label><strong>Email:</strong></label>
                                                        <p>{{ $anggota->email }}</p>
                                                        <label><strong>Status Anggota:</strong></label>
                                                        <p>{{ $anggota->status_anggota }}</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        
                                    {{-- Modal Hapus Anggota --}}
                                    <div class="modal fade" id="modalHapusAnggota{{ $anggota->id_anggota }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus Anggota <strong>{{ $anggota->nama }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('anggota-delete', $anggota->id_anggota) }}" method="POST">
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