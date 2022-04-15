<x-app-layout>

    <x-slot name="title">Tambah Data Format 1</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
    </x-slot>
  
    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <div class="section-header-back">
            <a href="{{ route('ekonomi-desa-format1') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
          </div>
          <h1>Tambah Data Format 1</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
            <div class="breadcrumb-item"><a href="{{ route('ekonomi-desa-format1') }}">Data Format 1</a></div>
            <div class="breadcrumb-item">Tambah Data Format 1</div>
          </div>
        </div>
  
        <div class="section-body">
        <form method="POST" id="formInput" action="{{ route('uem.individu.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header"><h4>Data Format 1</h4></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Kecamatan</label>
                        <select id="kecamatan" onchange="getDesaByIdKecamatan()" class="form-control selectric" name="kecamatan" required>
                          <option value="">Pilih....</option>
                          @foreach($kecamatan as $value)
                            <option value="{{ $value->id }}" {{ @$individu->id_kecamatan == $value->id ? 'selected' : '' }}>{{ $value->nama_kecamatan }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">Kecamatan wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label for="title">Nama Desa</label>
                        <select id="desa" class="form-control selectric" name="desa" required disabled>
                         
                        </select>
                    </div>
                  <div class="form-group">
                      <label for="nik">Produk</label>
                      <select name="" id="" class="form-control selectric" required>
                        <option value="">Pilih....</option>
                        @foreach($produk as $value)
                          <option value="{{ $value->id }}">{{ $value->nama_produk }}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="jenis_kelamin">Jenis Komoditas</label>
                    <input type="text" class="form-control" name="jenis_komoditas" id="" required>
                  </div>
                  <div class="form-group">
                    <label for="no_hp">Luas Lahan</label>
                    <input id="no_hp" type="text" class="form-control" name="lahan" required>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                        <div class="font-weight-bold"><h4>Swasta / Negara</h4></div>
                    </div>
                  </div>
                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Swasta Luas</label>
                            <input type="text" class="form-control" name="swasta_luas" id="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Swasta Ton</label>
                            <input type="text" class="form-control" name="swasta_ton" id="">
                        </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-md-12">
                        <div class="font-weight-bold"><h4>Rakyat</h4></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Rakyat Luas</label>
                            <input type="text" class="form-control" name="rakyat_luas" id="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Rakyat Hasil</label>
                            <input type="text" class="form-control" name="rakyat_hasil" id="">
                        </div>
                    </div>
                 </div>
                 <div class="form-group">
                    <label for="">Nilai Produk (Rp.)</label>
                    <input type="text" class="form-control" name="nilai_produk" id="nilai_produk">
                 </div>
                 <div class="form-group">
                    <label for="">Pemasaran Hasil</label>
                    <input type="text" class="form-control" name="pemasaran_hasil" id="">
                 </div>
                 <button type="submit" id="btn-store" class="btn btn-success btn-lg">SIMPAN</button>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
  
    <x-slot name="extra_js">
      <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
      <script src="{{ asset('vendor/jquery_mask/src/jquery.mask.js') }}"></script>
      <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
      <script src="{{ asset('js/plugin.js') }}"></script>
      <script> 

            $(document).ready(function(){

                $( '#nilai_produk' ).mask('000.000.000', {reverse: true});

            })
            function getDesaByIdKecamatan() {

                const kecamatanId = $('#kecamatan').val()

                if (kecamatanId == "" || kecamatanId == null) {
                    $('#desa').empty();
                    $('#desa').prop('disabled', true);
                return
                }

                $('#desa').empty();
                $('#desa').html('<option value="">Sedang Mengambil data...</option>');

                const formData = new FormData();
                formData.append('id_kecamatan', kecamatanId);

                fetch("/api/getdesabyidkecamatan", {
                        headers: {
                            "X-CSRF-Token": $('input[name="_token"]').val()
                        },
                        method: "POST",
                        credentials: "same-origin",
                        body: formData
                })
                .then((res) => {
                    return res.json()
                })
                .then((res) => {

                    $('#desa').empty();
                    $('#desa').prop('disabled', false);
                    $('#desa').append('<option value="">Pilih Desa</option>');
                    
                    for (const iterator of res.data) {
                    
                    $('#desa').append(`<option value="${iterator.id}">${iterator.nama_desa}</option>`);

                    }

                })
                .catch((err) => {
                    console.log(err);
                })
            }

      </script>
    </x-slot>
  </x-app-layout>