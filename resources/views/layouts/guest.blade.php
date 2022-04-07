<!DOCTYPE html>
<html lang="id"> 
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@isset($title){{ $title }}@endisset - SIMPUSDA</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  
  <!-- Extra CSS -->
  @isset($extra_css)
    {{ $extra_css }}
  @endisset
  
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom-guest.css') }}">

</head>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg bg-transparent"></div>
      <nav class="navbar navbar-expand-lg main-navbar bg-dark">
      <div class="container">
        <a href="{{ url('') }}" class="navbar-brand d-none d-md-none">SIMPUSDA</a>
        <a class="navbar-brand d-none d-md-block" href="{{ url('') }}">
          <img src="{{ asset('img/SIMPUSDA.png') }}" class="d-inline-block" alt="" style="height: 50px;"> SIMPUSDA
        </a>
        <div class="navbar-nav">
          <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
        </div>
        <form class="form-inline ml-auto" method="GET" action="{{ route('search') }}">
          <ul class="navbar-nav">
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" name="keyword" placeholder="Cari Buku" aria-label="Search" data-width="250" value="{{ isset($search) ? $search : '' }}">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          @auth
          @role('Member')
            <li>
              <a href="{{ route('cart.index') }}" class="nav-link nav-link-lg beep"><i class="fas fa-shopping-cart"></i></a>
            </li>
          @endrole
          @endauth
          @auth
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset((Auth::User()->foto != null) ? Auth::User()->foto : 'img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::User()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              @role('Admin')
              <a href="{{ route('admin.dashboard') }}" class="dropdown-item has-icon"><i class="fas fa-home"></i> Dasbor</a>
              @else
              <a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profil
              </a>
              @endrole
              <div class="dropdown-divider"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="route('logout')" class="dropdown-item has-icon text-danger" 
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Log out') }}
                </a>
              </form>
            </div>
          </li>
          @endauth
        </ul>
      </div>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="{{ route('beranda') }}" class="nav-link"><i class="fas fa-home"></i><span>BERANDA</span></a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fa fa-tags"></i><span>KATALOG</span></a>
                <ul class="dropdown-menu">
                  @foreach ($category as $setup)
                    <li class="nav-item"><a class="nav-link" href="{{ route('categories', $setup->slug) }}">{{ $setup->name }}</a></li>
                  @endforeach
                </ul>
            </li>
            <li class="nav-item">
              <a href="{{ route('contact.index') }}" class="nav-link"><i class="fas fa-envelope"></i><span>KONTAK</span></a>
            </li>
            <li class="nav-item">
              <a href="{{ route('about') }}" class="nav-link"><i class="fas fa-info-circle"></i><span>TENTANG</span></a>
            </li>
          </ul>
          @unless (Auth::check())
            <div class="mt-4 mb-4 py-3 hide-sidebar-mini">
              <a href="{{ route('login') }}" class="btn btn-outline-dark btn-lg btn-block btn-icon-split">
                MASUK / DAFTAR
              </a>
            </div>
          @endunless
        </div>
      </nav>

      <!-- Main Content -->
      {{ $slot }}

      <footer class="main-footer bg-dark mt-0 pt-0">
        <div style="background-color: #1b2024;">
          <div class="container py-5">
            <div class="row">
              <div class="col-md-3 mb-3">
                <a class="d-inline-flex align-items-center mb-2 link-dark text-light text-decoration-none" href="/" aria-label="Bootstrap">
                  <img src="{{ asset('img/ARSIPUSDA.png') }}" alt="" style="height: 50px;"> 
                  <span class="ml-2">ARSIPUSDA</span>
                </a>
                <ul class="list-unstyled text-muted">
                  <li class="mb-2">Dinas Perpustakaan dan Arsip Daerah Kota Banjarmasin</li>
                </ul>
              </div>
              <div class="col-md-3 mb-3">
                <h6>Kontak</h6>
                <ul class="list-unstyled text-muted">
                  <li class="mb-2"><i class="fa fa-map-marker fs-16 dis-inline-block size19 mr-2" aria-hidden="true"></i>
                    {{ $setting->alamat }}</li>
                  <li class="mb-2"><i class="fa fa-phone fs-16 dis-inline-block size19 mr-2" aria-hidden="true"></i>
                    {{ $setting->telpon }}</li>
                  <li class="mb-2"><i class="fa fa-envelope fs-13 dis-inline-block size19 mr-2" aria-hidden="true"></i>
                    {{ $setting->email }}</li>
                </ul>
              </div>
              <div class="col-md-3 mb-3">
                <h6>Hari & Jam Kerja</h6>
                <ul class="list-unstyled">
                  <li class="mb-2">{{ $setting->hari_kerja }}</li>
                  <li class="mb-2">{{ $setting->jam_kerja }}</li>
                </ul>
              </div>
              <div class="col-md-3 mb-3">
                <h6>Media Sosial</h6>
                <ul class="list-unstyled">
                  <li class="mb-2"><a href="{{ $setting->facebook }}">Facebook</a></li>
                  <li class="mb-2"><a href="{{ $setting->twitter }}">Twitter</a></li>
                  <li class="mb-2"><a href="{{ $setting->instagram }}">Instagram</a></li>
                  <li class="mb-2"><a href="{{ $setting->youtube }}">Youtube</a></li>
                </ul>
              </div>
              {{-- <div class="col-6 col-lg-2 mb-3">
                <h5>Projects</h5>
                <ul class="list-unstyled">
                  <li class="mb-2"><a href="https://github.com/twbs/bootstrap">Bootstrap 5</a></li>
                  <li class="mb-2"><a href="https://github.com/twbs/bootstrap/tree/v4-dev">Bootstrap 4</a></li>
                  <li class="mb-2"><a href="https://github.com/twbs/icons">Icons</a></li>
                  <li class="mb-2"><a href="https://github.com/twbs/rfs">RFS</a></li>
                  <li class="mb-2"><a href="https://github.com/twbs/bootstrap-npm-starter">npm starter</a></li>
                </ul>
              </div>
              <div class="col-6 col-lg-2 mb-3">
                <h5>Community</h5>
                <ul class="list-unstyled">
                  <li class="mb-2"><a href="https://github.com/twbs/bootstrap/issues">Issues</a></li>
                  <li class="mb-2"><a href="https://github.com/twbs/bootstrap/discussions">Discussions</a></li>
                  <li class="mb-2"><a href="https://github.com/sponsors/twbs">Corporate sponsors</a></li>
                  <li class="mb-2"><a href="https://opencollective.com/bootstrap">Open Collective</a></li>
                  <li class="mb-2"><a href="https://bootstrap-slack.herokuapp.com/">Slack</a></li>
                  <li class="mb-2"><a href="https://stackoverflow.com/questions/tagged/bootstrap-5">Stack Overflow</a></li>
                </ul>
              </div> --}}
            </div>
          </div>
        </div>
        <div class="container pt-3">
          <div class="text-center">
            Copyright &copy; 2022 All rights reserved | demo app
            <!-- <div class="bullet"></div>  -->
            <!-- Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a> -->
          </div>
          <!-- <div class="footer-right">
            1.0.0
          </div> -->
          </div>
      </footer>

    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('js/stisla.js') }}"></script>
  
  <!-- Extra Js -->
  @isset($extra_js)
    {{ $extra_js }}
  @endisset

  <!-- Template JS File -->
  <script src="{{ asset('js/scripts.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
