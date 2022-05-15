<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SISTEM INFORMASI PEMETAAN USAHA MASYARAKAT DESA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  {{-- <link href="{{ asset('vendor/butterfly/assets/img/favicon.png') }}" rel="icon"> --}}
  {{-- <link href="{{ asset('vendor/butterfly/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon"> --}}

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Dosis:300,400,500,,600,700,700i|Lato:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('vendor/butterfly/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/butterfly/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/butterfly/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/butterfly/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/butterfly/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">

  <!-- Template Main CSS File -->
  <link href="{{ asset('vendor/butterfly/assets/css/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Butterfly - v4.7.0
  * Template URL: https://bootstrapmade.com/butterfly-free-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top" style="max-height: 85px;">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="#" class="logo"><img src="{{ asset('vendor/butterfly/tala.png') }}" alt="" class="img-fluid" style="max-height: 55px"></a>
      <!-- Uncomment below if you prefer to use text as a logo -->
      <!-- <h1 class="logo"><a href="index.html">Butterfly</a></h1> -->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#bumdes">Bumdes</a></li>
          <li><a class="nav-link scrollto" href="#grafik">Grafik</a></li>
          <li><a class="nav-link scrollto" href="#peta">Peta</a></li>
          {{-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> --}}
          <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1>SISTEM INFORMASI PEMETAAN USAHA EKONOMI MASYARAKAT DESA</h1>
          <h2>Sistem Informasi ini memberikan sebuah informasi tentang pasar desa, data bumdes, grafik dan peta persebaran ukm. yang ada di Kabupaten Tanah Laut.</h2>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img">
          <img src="{{ asset('vendor/butterfly/assets/img/hero-img.png') }}" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="bumdes" class="about">
      <div class="container">

        <div class="row">
          <div class="col-xl-5 col-lg-6 d-flex justify-content-center align-items-stretch position-relative">
            <img src="{{ asset('vendor/bumdes2.png') }}" class="img-fluid" alt="">
          </div>

          <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
            <h3 class="text-center">Data Badan Usaha Milik Desa (Bumdes) </h3>
          
            <div class="row">
              <div class="col-md-12">
                <table class="table table-striped" id="dataTable" style="width: 100%;">
                  <thead>
                    <tr class="table-primary">
                      <th class="text-center" style="width: 30px;">
                        No
                      </th>
                      <th>Kecamatan</th>
                      <th>Desa</th>
                      <th>Nama Bumdes</th>                
                      <th>Tahun Berdiri</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Services Section ======= -->
    <section id="grafik" class="services section-bg">
      <div class="container">

        <div class="section-title">
          <h2 class="text-center">Grafik UEM</h2>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="m-0 p-4">
                  <div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Kecamatan</label>
                        <select class="form-control" name="id_kecamatan" id="kecamatan" onchange="getDesaByIdKecamatan()" required>
                          <option value="">Pilih Kecamatan</option>
                          @foreach ($kecamatan as $item)
                            <option value="{{$item->id}}">{{$item->nama_kecamatan}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Desa</label>
                        <select class="form-control" name="id_desa" id="desa" required disabled>
                          <option value="">Pilih Desa</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Grafik</label>
                        <select class="form-control" name="id_kecamatan" id="graph_type" required>
                          <option value="">Pilih Grafik</option>
                          <option value="doughnut">Donat</option>
                          <option value="pie">Pie</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Jenis Data</label>
                        <select class="form-control" name="id_kecamatan" id="jenis_data" required>
                          <option value="">Pilih Jenis Data</option>
                          <option value="jumlah_usaha">Jumlah Usaha</option>
                          <option value="skala_usaha">Skala Usaha</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Tahun Data</label>
                        <select class="form-control" name="id_kecamatan" id="tahun" required>
                          <option value="">Pilih Tahun</option>
                          @for ($i = 2019; $i <= date('Y'); $i++)
                            <option value="{{$i}}">{{$i}}</option>
                          @endfor
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label"> &nbsp;</label>
                        <input type="button" class="form-control btn btn-md btn-primary" value="Tampilkan" name="" id="tampilkan" onclick="showGraph()">
                      </div>
                    </div>
                  </div>
                </div>
                <div id="graph-container">
                  <div class="d-flex align-items-center justify-content-center" style="height: 350px" id="loading-graph">
                    <div class="p-2 bd-highlight col-example">
                      <div class="spinner-border text-primary" role="status"></div>
                      <div class="spinner-border text-secondary" role="status"></div>
                      <div class="spinner-border text-success" role="status"></div>
                      <div class="text-center">Pilih Data...</div>
                    </div>
                  </div>
                  {{-- <canvas id="myChart" width="400" height="400"></canvas> --}}
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Team Section ======= -->
    <section id="peta" class="team section-bg">
      <div class="container">

        <div class="section-title">
          <h2>PETA EKONOMI DESA KABUPATEN TANAH LAUT</h2>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="gis">
                  <iframe src="{{ route('gis.loadmap') }}" class="loadmap" style="width: 100%; height: 600px;"></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Team Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Kontak</h3>
            
              <strong>Alamat:</strong> Jl. Pangeran Antasari No. 2 Kel. Pelaihari
              Kec. Pelaihari, Kabupaten Tanah Laut Kalimantan Selatan (70811) <br>
              <strong>Email:</strong> info@example.com<br>
              <strong>Telpon:</strong> (0512) 21001<br>
              <strong>Jam Operasional:</strong> 07.30 - 16.00 <br>
            
          </div>

         
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Sosial Media</h4>
            <p>Untuk mengetahui update terbaru</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span>Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Tanah Laut</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/butterfly-free-bootstrap-theme/ -->
        {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('vendor/butterfly/assets/vendor/purecounter/purecounter.js') }}"></script>
  <script src="{{ asset('vendor/butterfly/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/butterfly/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('vendor/butterfly/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendor/butterfly/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/butterfly/assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('vendor/butterfly/assets/js/main.js') }}"></script>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
  <script src="{{ asset('vendor/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
  <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
  <script src="{{ asset('vendor/chartjs/chartjs-plugin-datalabels.min.js') }}"></script>
  <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
  <script src="{{ asset('vendor/leaflet-ajax-2.1.0/dist/leaflet.ajax.min.js') }}"></script>
  <script src="{{ asset('vendor/leaflet/TileLayer.GeoJSON.js') }}"></script>
  <script src="{{ asset('vendor/grafik-dash.js') }}"></script>
  
  <script>


      var table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('bumdes-json') }}',
        columns: [
          { data: 'no', name: 'no'},
          { data: 'kecamatan', name: 'kecamatan' },
          { data: 'desa', name: 'desa' },
          { data: 'nama_bumdes', name: 'nama_bumdes' },
          { data: 'tahun', name: 'tahun' }
        ]
      });

     function loadmap(){
      $id_kecamatan = $("[name=id_kecamatan]").val();
      $tahun = $("[name=tahun]").val();
      $(".loadmap").attr({"src":"{{ route('gis.loadmap') }}?id_kecamatan="+$id_kecamatan+"&tahun="+$tahun});
    }

  </script>

</body>

</html>