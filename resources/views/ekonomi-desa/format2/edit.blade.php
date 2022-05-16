<x-app-layout>

    <x-slot name="title">Edit Data Format 2</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
    </x-slot>
  
    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <div class="section-header-back">
            <a href="{{ route('ekonomi-desa-format2') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
          </div>
          <h1>Edit Data Usaha Jasa</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
            <div class="breadcrumb-item"><a href="{{ route('ekonomi-desa-format1') }}">Data Usaha Jasa</a></div>
            <div class="breadcrumb-item">Edit Data Usaha Jasa</div>
          </div>
        </div>
  
        <div class="section-body">
        <form method="POST" action="{{ route('ekonomi-desa-format2-update', $data->uuid) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header"><h4>Data Usaha Jasa</h4></div>
                <div class="card-body">
                  <div class="form-group">
                      <label for="nik">jenis produk yang diperdagangkan(Jenis)</label>
                      <select name="produk" id="" class="form-control selectric" required>
                        <option value="">Pilih....</option>
                        @foreach($produk as $value)
                          @if ($value->id == $data->id_produk)
                            <option value="{{ $value->id }}" selected>{{ $value->nama_produk }}</option>
                          @else
                            <option value="{{ $value->id }}">{{ $value->nama_produk }}</option>  
                          @endif
                        @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="jenis_kelamin">Jenis Usaha</label>
                    <input type="text" class="form-control" name="jenis_usaha" id="" required value="{{ $data->jenis_usaha }}">
                  </div>
                  <div class="form-group">
                    <label for="no_hp">Jumlah Orang</label>
                    <input id="no_hp" type="text" class="form-control" name="jumlah_orang" required value="{{ $data->jumlah_orang }}">
                  </div>
                  <div class="form-group">
                    <label for="">Jumlah Kegiatan</label>
                    <input type="text" class="form-control" name="jumlah_kegiatan" id="" value="{{ $data->jumlah_kegiatan }}">
                  </div>
                  <div class="form-group">
                    <label for="">Jumlah Pemilik</label>
                    <input type="text" class="form-control" name="jumlah_pemilik" id="" value="{{ $data->jumlah_pemilik }}">
                  </div>
                  <div class="form-group">
                    <label for="">Jumlah Tenaga Kerja</label>
                    <input type="text" class="form-control" name="jumlah_tenaga_kerja" id="" value="{{ $data->jumlah_tenaga_kerja }}">
                  </div>
                 <div class="form-group">
                    <label for="">Tahun</label>
                    <select name="tahun" id="" class="form-control" required>
                        <option value="">Pilih....</option>
                        @for($i = date('Y'); $i >= date('Y')-5; $i--)
                            @if ($i == $data->tahun)
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                 </div>
                 <input type="hidden" name="id_sub_komoditas" id="" value="{{ $id_sub_komoditas }}" required>
                 <input type="hidden" name="id_kec_en" id="" value="{{ $id_kec_en }}" required>
                 <input type="hidden" name="id_des_en" id="" value="{{ $id_des_en }}" required>
                 <button type="submit" id="btn-store" class="btn btn-success btn-lg">UPDATE</button>
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