<x-app-layout>

    <x-slot name="title">DASBOR</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') }}">
    </x-slot>
    
    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1>DASBOR</h1>
        </div>
        <div class="section-body">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-folder"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Data UEM</h4>
                  </div>
                  <div class="card-body">
                    {{ $total_uem }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Data Pasar Desa</h4>
                  </div>
                  <div class="card-body">
                    {{ $total_pasar }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning text-white">
                  <i class="fas fa-balance-scale"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Data Bumdes</h4>
                  </div>
                  <div class="card-body">
                    {{ $total_bumdes }}
                  </div>
                </div>
              </div>
            </div>  
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success text-white">
                  <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Profil Sumber Daya Alam</h4>
                  </div>
                  <div class="card-body">
                    {{ $total_format1 }}
                  </div>
                </div>
              </div>
            </div>      
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-secondary text-white">
                  <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Profil Usaha Jasa</h4>
                  </div>
                  <div class="card-body">
                    {{ $total_format2 }}
                  </div>
                </div>
              </div>
            </div>      
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-dark text-white">
                  <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Profil Usaha Produk</h4>
                  </div>
                  <div class="card-body">
                    {{ $total_format3 }}
                  </div>
                </div>
              </div>
            </div>      
          </div>
        </div>
      </section>
    </div>
  
    <x-slot name="extra_js">
      <script>
      $(function() {
        
      }); 
      </script>
    </x-slot>
</x-app-layout>  
