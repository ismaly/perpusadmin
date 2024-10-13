@extends('admin.template.master')
@section('content')
<div class="container">
  <div class="page-inner">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
          <h3 class="fw-bold mb-3">Daftar Buku</h3>
          <a href="{{ route ('FormBuku') }}" class="btn btn-primary btn-sm"> Tambah Data </a>
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
                                  <th>Judul Buku</th>
                                  <th>Jenis Buku</th>
                                  {{-- <th>Penulis</th>
                                  <th>Penerbit</th> --}}
                                  <th>Tahun Terbit</th>
                                  <th>Stok</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($daftarbuku as $index => $buku)
                                  <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $buku->kategori->nama_kategori ?? 'Tidak ada kategori' }}</td>
                                        <td>{{ $buku->kategori->lokasi_buku ?? 'Tidak ada lokasi' }}</td>
                                        <td>{{ $buku->judul_buku }}</td>
                                        <td>{{ $buku->jenis_buku }}</td>
                                        {{-- <td>{{ $buku->penulis }}</td>
                                        <td>{{ $buku->penerbit }}</td> --}}
                                        <td>{{ $buku->tahun_terbit }}</td>
                                        <td>{{ $buku->stok }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" class="btn btn-link btn-primary btn-lg" 
                                                        data-bs-toggle="modal" data-bs-target="#modalDetailBuku{{ $buku->id_buku }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <a href="{{ route('FormBuku', $buku->id_buku) }}" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-link btn-danger btn-lg" 
                                                        data-bs-toggle="modal" data-bs-target="#modalHapus{{ $buku->id_buku }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                  </tr>
                                  {{-- Modal Button Detail Buku --}}
                                  <div class="modal fade" id="modalDetailBuku{{ $buku->id_buku }}" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDetailLabel">Detail Buku</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label><strong>Kategori:</strong></label>
                                                    <p>{{ $buku->kategori->nama_kategori ?? 'Tidak ada kategori' }}</p>

                                                    <label><strong>Lokasi Buku:</strong></label>
                                                    <p>{{ $buku->kategori->lokasi_buku ?? 'Tidak ada lokasi' }}</p>

                                                    <label><strong>Judul Buku:</strong></label>
                                                    <p>{{ $buku->judul_buku ?? 'Tidak ada jenis' }}</p>

                                                    <label><strong>Jenis Buku:</strong></label>
                                                    <p>{{ $buku->jenis_buku ?? 'Tidak ada jenis' }}</p>

                                                    <label><strong>Penulis:</strong></label>
                                                    <p>{{ $buku->penulis ?? 'Tidak ada jenis'  }}</p>

                                                    <label><strong>Penerbit:</strong></label>
                                                    <p>{{ $buku->penerbit ?? 'Tidak ada jenis' }}</p>

                                                    <label><strong>Tahun Terbit:</strong></label>
                                                    <p>{{ $buku->tahun_terbit  ?? 'Tidak ada jenis' }}</p>

                                                    <label><strong>Gambar Buku:</strong></label><br>
                                                    @if(isset($buku) && $buku->image_buku)
                                                        <img src="{{ Storage::url($buku->image_buku) }}" alt="Gambar Buku" class="img-fluid" style="max-width: 200px; height: auto;">
                                                    @else
                                                        <p>Tidak ada gambar buku yang diunggah.</p>
                                                    @endif

                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                  {{-- Modal Button Hapus --}}
                                    <div class="modal fade" id="modalHapus{{ $buku->id_buku }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus Buku <strong>{{ $buku->judul_buku }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('buku-delete', $buku->id_buku) }}" method="POST">
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