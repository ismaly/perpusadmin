@extends('admin.template.master')
@section('content')
<div class="container">
  <div class="page-inner">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
          <h3 class="fw-bold mb-3">Daftar Pengembalian Buku</h3>
          <a href="{{ route('exportPDFPengembalian') }}" class="btn btn-success btn-sm"> Export PDF </a>
          {{-- <a href="{{ route ('FormPengembalianBuku') }}" class="btn btn-primary btn-sm"> Tambah Data </a> --}}
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
                                  <th>NIS & Nama Peminjam</th>
                                  <th>Kode & Judul Buku</th>
                                  <th>Status</th>
                                  <th>Denda</th>
                                  <th>Tanggal Pengembalian Real</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($daftarpengembalian as $index => $pengembalian)
                                  <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>({{ $pengembalian->anggota->nis ?? 'Tidak ada anggota' }})-{{ $pengembalian->anggota->nama ?? 'Tidak ada anggota' }}</td>
                                        <td>({{ $pengembalian->buku->kode_buku ?? 'Tidak ada buku' }}) {{ $pengembalian->buku->judul_buku ?? 'Tidak ada buku' }}</td>
                                        <td>{{ $pengembalian->status ?? 'Tidak ada peminjaman' }}</td>
                                        <td>{{ $pengembalian->denda ?? 'Tidak ada denda' }}</td>
                                        <td>{{ $pengembalian->tanggal_pengembalian_real ?? 'Belum Pengembalian' }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('FormPengembalianBuku', $pengembalian->id_transaksi) }}" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-link btn-danger btn-lg" 
                                                    data-bs-toggle="modal" data-bs-target="#modalHapus{{ $pengembalian->id_transaksi }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                  </tr>
                                </div>

                                  {{-- Modal Button Hapus --}}
                                  <div class="modal fade" id="modalHapus{{ $pengembalian->id_transaksi }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus Pengembalian Buku <strong>{{ $pengembalian->anggota->nama ?? 'Tidak ada anggota' }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('pengembalian-delete', $pengembalian->id_transaksi) }}" method="POST">
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