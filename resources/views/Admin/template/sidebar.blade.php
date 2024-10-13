<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="{{ route ('dashboard') }}" class="logo">
          <img src="{{ asset ('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20"/>
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item">
                <a href="{{ route ('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
          
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
            </li>
            

            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPerpustakaan">
                <i class="fas fa-th-list"></i>
                <p>Data Perpustakaan</p>
                <span class="caret"></span>
                </a>
                <div class="collapse" id="sidebarPerpustakaan">
                <ul class="nav nav-collapse">
                    <li>
                    <a href="{{ route ('DaftarKategoriBuku') }}">
                        <span class="sub-item">Daftar Kategori Buku</span>
                    </a>
                    </li>
                    <li>
                    <a href="{{ route ('DaftarBuku') }}">
                        <span class="sub-item">Daftar Buku</span>
                    </a>
                    </li>
                </ul>
                </div>
            </li>

            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#sidebarDataTransaksi">
              <i class="fas fa-th-list"></i>
              <p>Data Transaksi</p>
              <span class="caret"></span>
              </a>
              <div class="collapse" id="sidebarDataTransaksi">
              <ul class="nav nav-collapse">
                  <li>
                  <a href="{{ route ('DaftarPeminjamanBuku') }}">
                      <span class="sub-item">Data Peminjaman</span>
                  </a>
                  </li>
                  <li>
                  <a href="icon-menu.html">
                      <span class="sub-item">Data Pengembalian</span>
                  </a>
                  </li>
              </ul>
              </div>
          </li>

            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDataUser">
                <i class="fas fa-th-list"></i>
                <p>Data User</p>
                <span class="caret"></span>
                </a>
                <div class="collapse" id="sidebarDataUser">
                <ul class="nav nav-collapse">
                    <li>
                    <a href="{{ route ('DaftarPetugas') }}">
                        <span class="sub-item">Data Petugas</span>
                    </a>
                    </li>
                    <li>
                    <a href="{{ route ('DaftarAnggota') }}">
                        <span class="sub-item">Data Anggota</span>
                    </a>
                    </li>
                </ul>
                </div>
            </li>

            
          
        </ul>
      </div>
    </div>
  </div>