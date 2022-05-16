<div class="main-sidebar bg-gradasi">
  <aside id="sidebar-wrapper" class="bg-gradasi">
    <div class="sidebar-brand">
      <a href="{{ route('landing-page') }}">
        <img src="{{ asset('img/logo.png') }}" class="d-inline-block" alt="" style="height: 40px;"> PUEM
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('dashboard') }}">
        <img src="{{ asset('img/logo.png') }}" class="d-inline-block" alt="" style="height: 35px;">
      </a>
    </div>
    <ul class="sidebar-menu">
      <li class="nav-item {{ (request()->routeIs('dashboard')) ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-home"></i><span>Dasbor</span></a>
      </li>
      <li class="nav-item dropdown {{ (request()->is('uem*')) ? 'active' : '' }}">
          <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fas fa-folder"></i><span>Data UEM</span></a>
          <ul class="dropdown-menu">
            <li class="nav-item {{ (request()->is('uem/individu*')) ? 'active' : '' }}"><a href="{{ route('uem.individu.index') }}" class="nav-link">Data Individu</a></li>
            <li class="nav-item {{ (request()->is('uem/usaha*')) ? 'active' : '' }}"><a href="{{ route('uem.usaha.index') }}" class="nav-link">Data Usaha</a></li>
          </ul>
      </li>
      <li class="nav-item {{ (request()->routeIs('pasar-desa.index')) ? 'active' : '' }}">
        <a href="{{ route('pasar-desa.index') }}" class="nav-link"><i class="fas fa-shopping-bag"></i><span>Pasar Desa</span></a>
      </li>
      <li class="nav-item">
        <a href="{{ route('bumdes-index') }}" class="nav-link"><i class="fas fa-balance-scale"></i><span>BUMDES</span></a>
      </li>
      <li class="nav-item dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fas fa-file-alt"></i><span>Data Ekonomi Desa</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a href="{{ route('ekonomi-desa-format1') }}" class="nav-link">Profil Sumber Daya Alam</a></li>
          <li class="nav-item"><a href="{{ route('ekonomi-desa-format2') }}" class="nav-link">Profil Usaha Jasa</a></li>
          <li class="nav-item"><a href="{{ route('ekonomi-desa-format3') }}" class="nav-link">Profil Usaha Produk</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="{{ route('grafik-panel') }}" class="nav-link"><i class="fas fa-chart-line"></i><span>Grafik</span></a>
      </li>
      <li class="nav-item {{ (request()->routeIs('gis.index')) ? 'active' : '' }}">
        <a href="{{ route('gis.index') }}" class="nav-link"><i class="fas fa-map-marker-alt"></i></i><span>Gis</span></a>
      </li>
      @role('Super Admin')
      <li class="nav-item dropdown {{ (request()->is('master*')) ? 'active' : '' }}">
        <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fas fa-folder"></i><span>Master Data</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item {{ (request()->is('master/kecamatan*')) ? 'active' : '' }}"><a href="{{ route('master.kecamatan.index') }}" class="nav-link">Kecamatan</a></li>
          <li class="nav-item {{ (request()->is('master/desa*')) ? 'active' : '' }}"><a href="{{ route('master.desa.index') }}" class="nav-link">Desa</a></li>
          <li class="nav-item {{ (request()->is('master/kategori-komoditas*')) ? 'active' : '' }}"><a href="{{ route('master.kategori-komoditas.index') }}" class="nav-link">Kategori Komoditas</a></li>
          <li class="nav-item {{ (request()->is('master/komoditas*')) ? 'active' : '' }}"><a href="{{ route('master.komoditas.index') }}" class="nav-link">Komoditas</a></li>
          <li class="nav-item {{ (request()->is('master/sub-komoditas*')) ? 'active' : '' }}"><a href="{{ route('master.sub-komoditas.index') }}" class="nav-link">Sub Komoditas</a></li>
          <li class="nav-item {{ (request()->is('master/produk*')) ? 'active' : '' }}"><a href="{{ route('master.produk.index') }}" class="nav-link">Produk</a></li>
          <li class="nav-item {{ (request()->is('master/instansi-pembina*')) ? 'active' : '' }}"><a href="{{ route('master.instansi-pembina.index') }}" class="nav-link">Instansi Pembina</a></li>
          <li class="nav-item {{ (request()->is('master/perizinan*')) ? 'active' : '' }}"><a href="{{ route('master.perizinan.index') }}" class="nav-link">Perizinan</a></li>
          <li class="nav-item {{ (request()->is('master/badan-usaha*')) ? 'active' : '' }}"><a href="{{ route('master.badan-usaha.index') }}" class="nav-link">Badan Usaha</a></li>
          <li class="nav-item {{ (request()->is('master/pendidikan*')) ? 'active' : '' }}"><a href="{{ route('master.pendidikan.index') }}" class="nav-link">Pendidikan</a></li>
          <li class="nav-item {{ (request()->is('master/pengguna*')) ? 'active' : '' }}"><a href="{{ route('master.pengguna.index') }}" class="nav-link">Pengguna</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fas fa-cog"></i><span>Pengaturan</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item {{ (request()->is('setting*')) ? 'active' : '' }}"><a href="{{ route('setting.index') }}" class="nav-link">Sistem</a></li>
          <li class="nav-item"><a href="{{route('database-setting')}}" class="nav-link">Managemen Database</a></li>
        </ul>
      </li>
      @endrole
    </ul>

    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
     
    </div>
  </aside>
</div>