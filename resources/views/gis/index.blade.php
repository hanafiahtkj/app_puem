<x-app-layout>
  
  <x-slot name="title">
    GIS
  </x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/leaflet-groupedlayercontrol/dist/leaflet.groupedlayercontrol.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>GIS PEMETAAN EKONOMI DESA</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">GIS</div>
        </div>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body p-1">
                <div class="m-0 p-4">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Kecamatan</label>
                        <select class="form-control select2" name="id_kecamatan" id="id_kecamatan" onChange="getDesa(this.value);" required>
                          <option value="">Semua....</option>
                          @foreach ($kecamatan as $key => $value)
                              <option value="{{ $value->id }}">{{ $value->nama_kecamatan }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">
                          Kecamatan wajib diisi.
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="tahun_berdiri">Tahun</label>
                        <select id="tahun_berdiri" class="form-control selectric" name="tahun_berdiri" required>
                          @for ($i = date('Y'); $i >= 1961; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body p-4">
                <div id="mapid" style="height: 600px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="modal fade" id="featureModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="feature-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="feature-info"></div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('vendor/leaflet-groupedlayercontrol/dist/leaflet.groupedlayercontrol.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/leaflet-groupedlayercontrol/example/exampledata.js') }}"></script> --}}
    <script src="{{ asset('vendor/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster.js') }}"></script>
    <script>
    $(function() {
      // banjarmasin = -3.317219,114.524172
      // var map = L.map('mapid').setView([-3.317219,114.524172], 13);

      var osmStreet = L.tileLayer("https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png", {
        attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)',
        maxZoom: 18,
        //id: 'mapbox/streets-v11',
        alt: "open Topo",
        tileSize: 512,
        zoomOffset: -1,
      });

      var markerClusters = new L.MarkerClusterGroup({
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true,
        disableClusteringAtZoom: 17
      });

      var map = L.map(document.getElementById('mapid'), {
        zoom: 13,
        center: [-3.314771,114.6185566],
        layers: [osmStreet, markerClusters],
        zoomControl: true,
        attributionControl: false
      });

      // Use the custom grouped layer control, not "L.control.layers"
      L.control.groupedLayers().addTo(map);

    });
    </script>
  </x-slot>
</x-app-layout>