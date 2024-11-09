@if($buku->isEmpty())
  <div class="col-md-12">
    <p>Tidak ada buku yang ditemukan.</p>
  </div>
@else
  @foreach($buku as $item)
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $item->id_buku }}">
                            <img src="{{ Storage::url($item->image_buku) }}" alt="Gambar Buku" class="img-fluid rounded" style="width: 100px; height: auto;">
                        </a>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Judul Buku</p>
                            <h4 class="card-title">{{ $item->judul_buku ?? 'Tidak ada judul' }}</h4>
                            <p class="card-category">Kode Buku: {{ $item->kode_buku ?? 'Tidak ada kode buku' }}</p>
                            <p class="card-category">Kategori: {{ $item->kategori->nama_kategori ?? 'Tidak ada kategori' }}</p>
                            <p class="card-category">Lokasi: {{ $item->kategori->lokasi_buku ?? 'Tidak ada lokasi' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for full image -->
    <div class="modal fade" id="imageModal{{ $item->id_buku }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{ Storage::url($item->image_buku) }}" class="img-fluid" alt="Gambar Buku" style="width:70%; height: auto;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
  @endforeach
@endif
