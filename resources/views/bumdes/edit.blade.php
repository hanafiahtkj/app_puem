<x-app-layout>

    <x-slot name="title">bumdes</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    </x-slot>
  
    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <div class="section-header-back">
            <a href="{{ route('bumdes-index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"> Data Bumdes</i></a>
          </div>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          </div>
        </div>
  
        <div class="section-body">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">From Update Bumdes</div>
              <form action="{{ route('bumdes-update', $data->uuid) }}" method="POST">
                @method('PUT')
                <div class="card-body">       
                    <div id="accordion">
                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <h4>DATA BUMDES (BADAN USAHA MILIK DESA)</h4>
                              </button>
                            </h5>
                          </div>
                          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="">Kecamatan*</label>
                                <select class="form-control" name="kecamatan" id="kecamatan" onchange="getDesaByIdKecamatan()" required @if(Auth::user()->id_kecamatan != null) disabled @endif>
                                  <option value="">Pilih Kecamatan</option>
                                  @foreach ($kecamatan as $item)
                                    @if ($item->id == $data->kecamatan)
                                      <option value="{{ $item->id }}" selected>{{ $item->nama_kecamatan }}</option>
                                    @else
                                      <option value="{{$item->id}}" {{ ($item->id == Auth::user()->id_kecamatan) ? 'selected' : '' }}>{{$item->nama_kecamatan}}</option>
                                    @endif
                                  @endforeach
                                </select>
                                @if(Auth::user()->id_kecamatan != null)
                                  <input type="hidden" name="kecamatan" value="{{ Auth::user()->id_kecamatan }}">
                                @endif
                              </div>
                              <div class="form-group">
                                <label for="">Desa*</label>
                                <select class="form-control" name="desa" id="desa" required disabled>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="">Nama BUMDES*</label>
                                <input type="text" class="form-control" name="nama_bumdes" id="" required value="{{ $data->nama_bumdes }}">
                              </div>
                              <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea name="alamat_bumdes" class="form-control" id="" rows="4">{{ $data->alamat_bumdes }}</textarea>
                              </div>
                              <div class="form-group">
                                <label for="">Tahun Berdiri*</label>
                                <input type="text" class="form-control" name="tahun_bumdes" id="" required value="{{ $data->tahun_bumdes }}">
                              </div>
                              <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="ket_bumdes" class="form-control" id="" rows="4">{{ $data->ket_bumdes }}</textarea>
                              </div>
                              <div class="form-group">
                                <label for="">Jumlah Karyawan*</label>
                                <input type="text" class="form-control" name="karyawan_bumdes" id="" required value="{{ $data->karyawan_bumdes }}">
                              </div>
                              <div class="form-group">
                                <label for="">Tanggal Simpan*</label>
                                <input type="" class="form-control" name="tglsimpan_bumdes" id="tgl_simpan" required value="{{ $data->tglsimpan_bumdes }}">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4>STRUKTUR BUMDES</h4>
                              </button>
                            </h5>
                          </div>
                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="">Nama Direktur*</label>
                                <input type="text" class="form-control" name="direktur" id="" required value="{{ $data->nama_direktur }}">
                              </div>
                              <div class="form-group">
                                <label for="">HP / Telpon Direktur</label>
                                <input type="text" class="form-control" name="tlp_direktur" id="" value="{{ $data->tlp_direktur }}">
                              </div>
                              <div class="form-group">
                                <label for="">Nama Sekretaris</label>
                                <input type="text" class="form-control" name="sekretaris" id="" value="{{ $data->nama_sek }}">
                              </div>
                              <div class="form-group">
                                <label for="">HP / Telpon Sekretaris</label>
                                <input type="text" class="form-control" name="tlp_sekretaris" id="" value="{{ $data->tlp_sek }}">
                              </div>
                              <div class="form-group">
                                <label for="">Nama Bendahara</label>
                                <input type="text" class="form-control" name="bendahara" id="" value="{{ $data->nama_bend }}">
                              </div>
                              <div class="form-group">
                                <label for="">HP / Telpon Bendahara</label>
                                <input type="text" class="form-control" name="tlp_bendahara" id="" value="{{ $data->tlp_bend }}">
                              </div>
                              <div class="form-group">
                                <label for="">Nama Ketua Pengawas</label>
                                <input type="text" class="form-control" name="ketuapengawas" id="" value="{{ $data->namaketua_peng }}">
                              </div>
                              <div class="form-group">
                                <label for="">HP / Telpon Pengawas</label>
                                <input type="text" class="form-control" name="tlp_ketuapengawas" id="" value="{{ $data->tlpketua_peng	 }}">
                              </div>
                              <div class="form-group">
                                <label for="">Nama Sekretaris Pengawas</label>
                                <input type="text" class="form-control" name="sekretaris_pengawas" id="" value="{{ $data->nama_sekpengawas }}">
                              </div>
                              <div class="form-group">
                                <label for="">Nama Anggota Pengawas</label>
                                <input type="text" class="form-control" name="anggota_pengawas" id="" value="{{ $data->anggota_sekpengawas }}">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h4>NOMOR & UNIT USAHA</h4>
                              </button>
                            </h5>
                          </div>
                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="">NO Perdes*</label>
                                <input type="text" class="form-control" name="no_perdes" id="" required value="{{ $data->no_perdes }}">
                              </div>
                              <div class="form-group">
                                <label for="">NO AD/ART</label>
                                <input type="text" class="form-control" name="no_adart" id="" value="{{ $data->no_adart }}">
                              </div>
                              <div class="form-group">
                                <label for="">NO SK</label>
                                <input type="text" class="form-control" name="no_sk" id="" value="{{ $data->no_sk }}">
                              </div>
                              <div class="form-group">
                                <label for="">Revisi NO Perdes</label>
                                <input type="text" class="form-control" name="rev_noperdes" id="" value="{{ $data->rev_noperdes }}">
                              </div>
                              <div class="form-group">
                                <label for="">Revisi NO AD/ART</label>
                                <input type="text" class="form-control" name="rev_noadart" id="" value="{{ $data->rev_noadart }}">
                              </div>
                              <div class="form-group">
                                <label for="">Revisi NO SK</label>
                                <input type="text" class="form-control" name="rev_nosk" id="" value="{{ $data->rev_nosk }}">
                              </div>
                              <div class="form-group">
                                <label for="">Nama Unit Usaha 1</label>
                                <input type="text" class="form-control" name="usaha_1" id="" value="{{ $data->unit_usahasatu }}">
                              </div>
                              <div class="form-group">
                                <label for="">Nama Unit Usaha 2</label>
                                <input type="text" class="form-control" name="usaha_2" id="" value="{{ $data->unit_usahadua }}">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="card-footer">
                  <button type="submit" id="btn-store" class="btn btn-primary btn-md">UPDATE</button>
                  <a href="{{ route('bumdes-index') }}" class="btn btn-info btn-md">BATAL</a>
                  @csrf
                </div>
              </form>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
  
    <x-slot name="extra_js">
      <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
      <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
      <script src="{{ asset('js/plugin.js') }}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
      <script> 
        $(document).ready(function() {

          $('#tgl_simpan').datepicker();

          $('#desa').html('<option value="">Sedang Mengambil data...</option>');

          var id_desa = '';
          @if (Auth::user()->id_desa != null)
            id_desa = '{{ Auth::user()->id_desa }}';
          @endif
          
          const kecamatanId = $('#kecamatan').val()

          const formData = new FormData()
          formData.append('id_kecamatan', kecamatanId)

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
                
                if (iterator.id == '{{ $data->desa }}' ) {
                  $('#desa').append(`<option value="${iterator.id}" selected>${iterator.nama_desa}</option>`);
                } else {
                  $('#desa').append(`<option value="${iterator.id}">${iterator.nama_desa}</option>`);
                }
                
              }

            })
            .catch((err) => {
              console.log(err);
            })

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