<x-app-layout>
  
  <x-slot name="title">
    GIS
  </x-slot>

  <x-slot name="extra_css">
    <style>
      .gis iframe {
        width: 100%;
        height: 600px;
        overflow: hidden;
        border: none;
      }
    </style>
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
                        <label for="tahun">Tahun</label>
                        <select id="tahun" class="form-control selectric" name="tahun" required>
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
                <div class="gis">
                  <iframe src="{{ route('gis.loadmap') }}" class="loadmap"></iframe>
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
    
    function loadmap(){
      $id_kecamatan = $("[name=id_kecamatan]").val();
      $tahun = $("[name=tahun]").val();
      $(".loadmap").attr({"src":"{{ route('gis.loadmap') }}?id_kecamatan="+$id_kecamatan+"&tahun="+$tahun});
    }

    $(function() {
      $("[name=id_kecamatan],[name=tahun]").change(loadmap);
    });

    </script>
  </x-slot>
</x-app-layout>