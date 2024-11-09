@extends('admin.template.master')
@section('content')
<div class="container">
    <div class="page-inner">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
          <h3 class="fw-bold mb-3">Sistem Infromasi Perpustakaan </h3>
          <h6 class="op-7 mb-2">SMA Negeri 1 Ranau Tengah</h6>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div class="icon-big text-center icon-primary bubble-shadow-small">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Jumlah Anggota</p>
                    <h4 class="card-title">{{ $jumlahAnggota }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div
                    class="icon-big text-center icon-success bubble-shadow-small">
                    <i class="fas fa-luggage-cart"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Jumlah Buku</p>
                    <h4 class="card-title">{{ $jumlahBuku }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <input type="text" id="search" class="form-control" placeholder="Masukkan Judul Buku...">
          </div>
        </div>
        <div class="row mt-3" id="searchResults">
          @include('Admin.template.search-results')
        </div>

        

      </div>
    </div>
  </div>
@endsection