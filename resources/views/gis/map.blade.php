<!DOCTYPE html>
<html>

<!-- General CSS Files -->
<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('vendor/leaflet-ajax-2.1.0/dist/leaflet.ajax.min.js') }}"></script>
<script src="{{ asset('vendor/leaflet/TileLayer.GeoJSON.js') }}"></script>

<style>
  body{
    font-family: arial
  }
  #map {
    height: 600px;
    padding-top: 200px;
    display: block;
    width: 100% !important;
    height: 100px;
    position: static !important
  }
  .legend {
    text-align: left;
    line-height: 18px;
    color: #555;
  }
  .legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 1 !important;
  }
  .legend .circle {
    border-radius: 50%;
    width: 10px;
    height: 10px;
    margin-top: 8px;
  }
  .header{
    position: fixed;
    background: #fff;
    padding: 4px 10px;
    left:50px;
    opacity: 1;
    z-index: 100
  }
  .header h1{
    font-size: 18px;
    z-index: 10000
  }
  .popup{
    height: 200px;
    overflow: auto;
  }
  .leaflet-popup-tip-container{
    position: inherit !important;
    margin-left: -20px
  }
</style>
</head>
<body>
  {{-- <div class="header">
    <h1>PETA EKONOMI DESA KABUPATEN TANAH LAUT</h1>
  </div> --}}

  <div id="map" style="height:500px;"></div>

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

      var hoverStyle = {
        "fillOpacity": 0.5
      };

      @foreach($desa as $key => $value)
        var {{ "style".ucfirst(str_replace(' ', '_', $value->nama_desa)) }} = {
          "clickable": true,
          "color": "{{ $value->garis }}",
          "fillColor": "{{ $value->warna }}",
          "weight": 1.0,
          "opacity": 1,
          "fillOpacity": 0.4
        };

        var geojsonURL = '{{ $value->storage_geojson }}';
        var geojsonTileLayer = new L.TileLayer.GeoJSON(geojsonURL, {
                clipTiles: true,
                unique: function (feature) {
                    return feature.id;
                }
            }, {
                style: {{ "style".ucfirst(str_replace(' ', '_', $value->nama_desa)) }},
                onEachFeature: function (feature, layer) {
                    if (feature.properties) {
                        var popupString = '<div class="popup">DESA :{{ strtoupper($value->nama_desa) }}<br>KECAMATAN :{{ strtoupper($value->nama_kecamatan) }}<hr>';
                        popupString += '</div>';
                        layer.bindPopup(popupString);
                    }
                    if (!(layer instanceof L.Point)) {
                        layer.on('mouseover', function () {
                            layer.setStyle(hoverStyle);
                        });
                        layer.on('mouseout', function () {
                            layer.setStyle({{ "style".ucfirst(str_replace(' ', '_', $value->nama_desa)) }});
                        });
                    }
                }
            }
        );
        var {{ ucfirst(str_replace(' ', '_', $value->nama_desa)) }} = L.layerGroup([geojsonTileLayer]);

      @endforeach

      var map = L.map('map', {
        zoom: 10,
        center: [-3.955, 114.846],
        layers: [
          osmStreet,@foreach($desa as $key => $value){{ ucfirst(str_replace(' ', '_', $value->nama_desa)) }},@endforeach
        ],
      });

      var baseMaps = {
        @foreach($desa as $key => $value)
          "{{ ucfirst(str_replace(' ', '_', $value->nama_desa)) }}": {{ ucfirst(str_replace(' ', '_', $value->nama_desa)) }},
        @endforeach
      };

      var overlayMaps = {
        @foreach($desa as $key => $value)
          "{{ ucfirst(str_replace(' ', '_', $value->nama_desa)) }}": {{ ucfirst(str_replace(' ', '_', $value->nama_desa)) }},
        @endforeach
      };

      L.control.layers(baseMaps,overlayMaps).addTo(map)

    });
  </script>

</body>
</html>