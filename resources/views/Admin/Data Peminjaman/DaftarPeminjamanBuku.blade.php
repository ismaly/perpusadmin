@extends('admin.template.master')
@section('content')
<div class="container">
  <div class="page-inner">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
          <h3 class="fw-bold mb-3">Daftar Peminjaman Buku</h3>
          <a href="{{ route ('FormPeminjamanBuku') }}" class="btn btn-primary btn-sm"> Tambah Data </a>
          <a href="{{ route('exportPDFPeminjaman') }}" class="btn btn-success btn-sm"> Export PDF </a>
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
                                  {{-- <th>Kategori Buku</th> --}}
                                  <th>Jadwal Peminjaman</th>
                                  <th>Jadwal Pengembalian</th>
                                  <th>Status</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($daftarpeminjaman as $index => $peminjaman)
                                  <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>({{ $peminjaman->anggota->nis ?? 'Tidak ada anggota' }})-{{ $peminjaman->anggota->nama ?? 'Tidak ada anggota' }}</td>
                                        <td>({{ $peminjaman->buku->kode_buku ?? 'Tidak ada buku' }}) {{ $peminjaman->buku->judul_buku ?? 'Tidak ada buku' }}</td>
                                        {{-- <td>{{ $peminjaman->buku->kategori->nama_kategori ?? 'Tidak ada kategori' }}</td> --}}
                                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d/m/Y') }}</td>
                                        <td>{{ $peminjaman->status ?? 'Tidak ada peminjaman' }}</td>


                                        <td>
                                            <div class="form-button-action">
                                                @if($peminjaman->status != 'selesai')
                                                    <a href="{{ route('FormPeminjamanBuku', $peminjaman->id_transaksi) }}" class="btn btn-link btn-primary btn-lg">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                <button type="button" class="btn btn-link btn-danger btn-lg" 
                                                        data-bs-toggle="modal" data-bs-target="#modalHapus{{ $peminjaman->id_transaksi }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                  </tr>
                                  {{-- Modal Button Detail Buku --}}
                                  <div class="modal fade" id="modalDetailPeminjaman{{ $peminjaman->id_transaksi }}" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDetailLabel">Detail Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label><strong>Nama Anggota:</strong></label>
                                                    <p>{{ $peminjaman->anggota->nama ?? 'Tidak ada anggota' }}</p>

                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                  {{-- Modal Button Hapus --}}
                                    <div class="modal fade" id="modalHapus{{ $peminjaman->id_transaksi }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus Peminjaman Buku <strong>{{ $peminjaman->anggota->nama ?? 'Tidak ada anggota' }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('peminjaman-delete', $peminjaman->id_transaksi) }}" method="POST">
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