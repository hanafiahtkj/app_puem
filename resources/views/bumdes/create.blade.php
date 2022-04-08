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
            <a href="{{ route('bumdes-index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
          </div>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          </div>
        </div>
  
        <div class="section-body">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">From Bumdes</div>
              <form action="{{ route('bumdes-store') }}" method="POST">
                <div class="card-body">       
                    <div id="accordion">
                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <h4>DATA BUMDES (BADAN USAHA MILIK DESA)</h4>
                              </button>
                            </h5>
                          </div>
                          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="">Kecamatan*</label>
                                <select class="form-control" name="kecamatan" id="kecamatan" onchange="getDesaByIdKecamatan()" required>
                                  <option value="">Pilih Kecamatan</option>
                                  @foreach ($kecamatan as $item)
                                    <option value="{{$item->id}}">{{$item->nama_kecamatan}}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="">Desa*</label>
                                <select class="form-control" name="desa" id="desa" required disabled>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="">Nama BUMDES*</label>
                                <input type="text" class="form-control" name="nama_bumdes" id="" required>
                              </div>
                              <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea name="alamat_bumdes" class="form-control" id="" rows="4"></textarea>
                              </div>
                              <div class="form-group">
                                <label for="">Tahun Berdiri*</label>
                                <input type="text" class="form-control" name="tahun_bumdes" id="" required>
                              </div>
                              <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="ket_bumdes" class="form-control" id="" rows="4"></textarea>
                              </div>
                              <div class="form-group">
                                <label for="">Jumlah Karyawan*</label>
                                <input type="text" class="form-control" name="karyawan_bumdes" id="" required>
                              </div>
                              <div class="form-group">
                                <label for="">Tanggal Simpan*</label>
                                <input type="" class="form-control" name="tglsimpan_bumdes" id="tgl_simpan" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                STRUKTUR BUMDES
                              </button>
                            </h5>
                          </div>
                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                              Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                NOMOR & UNIT USAHA
                              </button>
                            </h5>
                          </div>
                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                              Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="card-footer">
                  <button type="submit" id="btn-store" class="btn btn-success btn-lg">SIMPAN</button>
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
          $('#tgl_simpan').datepicker("setDate", new Date());
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