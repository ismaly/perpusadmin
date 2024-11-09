@extends('admin.template.master')
@section('content')
<div class="container">
  <div class="page-inner">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
          <h3 class="fw-bold mb-3">Daftar Kategori Buku</h3>
          <a href="{{ route ('FormKategoriBuku') }}" class="btn btn-primary btn-sm"> Tambah Data </a>
          <a href="{{ route('exportPDFKategori') }}" class="btn btn-success btn-sm"> Export PDF </a>

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
                                  <th>Kategori</th>
                                  <th>Lokasi Buku</th>
                                  <th style="width: 10%">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($daftarkategori as $index => $kategori)
                                  <tr>
                                      <td>{{ $index + 1 }}</td>
                                      <td>{{ $kategori->nama_kategori }}</td>
                                      <td>{{ $kategori->lokasi_buku }}</td>
                                      <td>
                                          <div class="form-button-action">
                                            <a href="{{ route('FormKategoriBuku', $kategori->id_kategori) }}" class="btn btn-link btn-primary btn-lg">
                                                 <i class="fa fa-edit"></i>
                                             </a>
                                            <button type="button" class="btn btn-link btn-danger btn-lg" 
                                                    data-bs-toggle="modal" data-bs-target="#modalHapus{{ $kategori->id_kategori }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                          </div>
                                      </td>
                                  </tr>
                                  {{-- Modal Button Hapus --}}
                                    <div class="modal fade" id="modalHapus{{ $kategori->id_kategori }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus kategori <strong>{{ $kategori->nama_kategori }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('kategori-delete', $kategori->id_kategori) }}" method="POST">
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