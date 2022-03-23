<div class="main-sidebar">
  <aside id="sidebar-wrapper" class="bg-gradasi">
    <div class="sidebar-brand">
      <a href="{{ route('dashboard') }}">
        <img src="{{ asset('img/logo.png') }}" class="d-inline-block" alt="" style="height: 40px;"> PUEM
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('dashboard') }}">
        <img src="{{ asset('img/logo.png') }}" class="d-inline-block" alt="" style="height: 35px;">
      </a>
    </div>
    <ul class="sidebar-menu">
      {{-- <li class="menu-header">Darbor</li> --}}
      <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-home"></i><span>Dasbor</span></a>
      </li>
      {{-- <li class="menu-header">Aplikasi</li> --}}
      <li class="nav-item dropdown">
          <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fas fa-folder"></i><span>Data UEM</span></a>
          <ul class="dropdown-menu">
            <li class="nav-item"><a href="" class="nav-link">Data Individu</a></li>
            <li class="nav-item"><a href="" class="nav-link">Data Usaha</a></li>
          </ul>
      </li>
      <li class="nav-item">
        <a href="" class="nav-link"><i class="fas fa-shopping-bag"></i><span>Pasar Desa</span></a>
      </li>
      <li class="nav-item">
        <a href="" class="nav-link"><i class="fas fa-umbrella"></i><span>BUMDES</span></a>
      </li>
      <li class="nav-item dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fas fa-folder"></i><span>Data Ekonomi Desa</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a href="" class="nav-link">Profil Sumber Daya Alam</a></li>
          <li class="nav-item"><a href="" class="nav-link">Profil Usaha Jasa</a></li>
          <li class="nav-item"><a href="" class="nav-link">Profil Usaha Produk</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="" class="nav-link"><i class="fas fa-chart-line"></i><span>Grafik</span></a>
      </li>
      <li class="nav-item">
        <a href="" class="nav-link"><i class="fas fa-map-marker-alt"></i></i><span>Gis</span></a>
      </li>
      <li class="nav-item dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fas fa-folder"></i><span>Master Data</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a href="" class="nav-link">Desa</a></li>
          <li class="nav-item"><a href="" class="nav-link">Kecamatan</a></li>
          <li class="nav-item"><a href="" class="nav-link">Kategori Komoditas</a></li>
          <li class="nav-item"><a href="" class="nav-link">Komoditas</a></li>
          <li class="nav-item"><a href="" class="nav-link">Sub Komoditas</a></li>
          <li class="nav-item"><a href="" class="nav-link">Produk</a></li>
          <li class="nav-item"><a href="" class="nav-link">Instansi Pembina</a></li>
          <li class="nav-item"><a href="" class="nav-link">Perizinan</a></li>
          <li class="nav-item"><a href="" class="nav-link">Badan Usaha</a></li>
          <li class="nav-item"><a href="" class="nav-link">Pendidikan</a></li>
          <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link">Pengguna</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fa fa-cog"></i><span>Pengaturan</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a href="" class="nav-link">Sistem</a></li>
          <li class="nav-item"><a href="" class="nav-link">Managemen Database</a></li>
        </ul>
      </li>
    </ul>

    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> Documentation
      </a>
    </div>
  </aside>
</div>