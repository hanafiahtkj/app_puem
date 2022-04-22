<x-app-layout>

  <x-slot name="title">{{ isset($usaha) ? 'EDIT DATA USAHA' : 'TAMBAH DATA USAHA' }}</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-4.0.13/dist/css/select2.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{ route('uem.usaha.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ isset($usaha) ? 'EDIT DATA USAHA' : 'TAMBAH DATA USAHA' }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('uem.usaha.index') }}">Data Usaha</a></div>
          <div class="breadcrumb-item">{{ isset($usaha) ? 'Edit Data Usaha' : 'Tambah Data Usaha' }}</div>
        </div>
      </div>

      <div class="section-body">
        @if(isset($usaha))
          <form method="POST" id="formInput" action="{{ route('uem.usaha.update', $usaha->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
          @method('PATCH')
        @else
          <form method="POST" id="formInput" action="{{ route('uem.usaha.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
        @endif
        @csrf
        <div class="row">
          <div class="col-md-7">
            <div class="card">
              <div class="card-header"><h4>Data Usaha</h4></div>
              <div class="card-body">
                <div class="form-group">
                  <label for="id_kecamatan">Kecamatan</label>
                  <select id="id_kecamatan" onChange="getDesa(this.value);" class="form-control selectric" name="id_kecamatan" required>
                    <option value="">Pilih....</option>
                    @foreach($kecamatan as $value)
                      <option value="{{ $value->id }}" {{ @$usaha->id_kecamatan == $value->id ? 'selected' : '' }}>{{ $value->nama_kecamatan }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">Kecamatan wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="id_desa">Desa</label>
                  <select id="id_desa" class="form-control selectric" name="id_desa" required disabled>
                    <option value="">Pilih....</option>
                  </select>
                  <div class="invalid-feedback">Desa wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="id_ukm">UKM</label>
                  <select id="id_ukm" class="form-control selectric js-select2-id-ukm" name="id_ukm" required>
                    @if (isset($usaha))
                      <option value="{{ $usaha->id_ukm }}" selected>{{ $usaha->ukm->nama_pemilik }}</option>
                    @else
                      <option value="">Pilih....</option>
                    @endif
                  </select>
                  <div class="invalid-feedback">UKM wajib diisi.</div>
                </div>
                <div class="form-group" id="detail-ukm" @if(!isset($usaha)) style="display: none;" @endif>
                  <label for="id_ukm">Detail UKM</label>
                  <div class="jumbotron p-4 m-0">
                    <table border="0" cellpadding="4" cellspacing="0">
                      <tbody>
                        <tr>
                          <td>Nama Pemilik</td>
                          <td>:</td>
                          <td id="tb-nama-pemilik">{{ @$usaha->ukm->nama_pemilik }}</td>
                        </tr>
                        <tr>
                          <td>NIK</td>
                          <td>:</td>
                          <td id="tb-nik">{{ @$usaha->ukm->nik }}</td>
                        </tr>
                        <tr>
                          <td>Jenis Kelamin</td>
                          <td>:</td>
                          <td id="tb-jenis-kelamin">{{ @$usaha->ukm->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                          <td>Alamat</td>
                          <td>:</td>
                          <td id="tb-alamat">{{ @$usaha->ukm->alamat_usaha }}</td>
                        </tr>
                        <tr>
                          <td>Status Usaha</td>
                          <td>:</td>
                          <td id="tb-status">{{ @$usaha->ukm->nama_badan_usaha }}</td>
                        </tr>
                        <tr>
                          <td>Tahun Berdiri</td>
                          <td>:</td>
                          <td id="tb-tahun-berdiri">{{ @$usaha->ukm->tahun_berdiri }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="jumlah_tenaga_kerja">Jumlah Tenaga Kerja</label>
                    <input id="jumlah_tenaga_kerja" type="text" class="form-control numeric" name="jumlah_tenaga_kerja" value="{{ @$usaha->jumlah_tenaga_kerja }}" required>
                    <div class="invalid-feedback">
                      Jumlah Tenaga Kerja wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="harga_jual_produk">Harga Jual Produk</label>
                    <input id="harga_jual_produk" type="text" class="form-control currency" name="harga_jual_produk" value="{{ @$usaha->harga_jual_produk }}" required>
                    <div class="invalid-feedback">
                      Harga Jual Produk wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="hari_kerja_sebulan">Rata-rata hari kerja sebulan</label>
                    <input id="hari_kerja_sebulan" type="text" class="form-control numeric" name="hari_kerja_sebulan" value="{{ @$usaha->hari_kerja_sebulan }}" required>
                    <div class="invalid-feedback">
                      Rata-rata hari kerja sebulan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="nilai_investasi">Nilai Investasi</label>
                    <input id="nilai_investasi" type="text" class="form-control currency" name="nilai_investasi" value="{{ @$usaha->nilai_investasi }}" required>
                    <div class="invalid-feedback">
                      Nilai Investasi wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="omzet_perhari">Omzet Perhari</label>
                    <input id="omzet_perhari" type="text" class="form-control currency" name="omzet_perhari" value="{{ @$usaha->omzet_perhari }}" required>
                    <div class="invalid-feedback">
                      Omzet Perhari wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="nilai_asset">Nilai Asset</label>
                    <input id="nilai_asset" type="text" class="form-control currency" name="nilai_asset" value="{{ @$usaha->nilai_asset }}" required>
                    <div class="invalid-feedback">
                      Nilai Asset wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="layanan_ukm">Kegiatan produksi/layanan ukm dalam 1 bulan</label>
                    <select id="layanan_ukm" name="layanan_ukm" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="1-7 Kali">1-7 Kali</option>
                      <option value="8-15 Kali">8-15 Kali</option>
                      <option value="Setiap Hari">Setiap Hari</option>
                    </select>
                    <div class="invalid-feedback">
                      Layanan Ukm wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="bantuan_alat">Sudah mendapatkan bantuan alat</label>
                    <select id="bantuan_alat" name="bantuan_alat" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Pemerintah">Pemerintah</option>
                      <option value="Swasta">Swasta</option>
                      <option value="Belum Sama Sekali">Belum Sama Sekali</option>
                    </select>
                    <div class="invalid-feedback">
                      Bantuan Alat wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="produk_dihasilkan">Produk dihasilkan</label>
                    <select id="produk_dihasilkan" name="produk_dihasilkan" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Bahan Baku">Bahan Baku</option>
                      <option value="Barang Jadi">Barang Jadi</option>
                      <option value="Layanan/Jasa">Layanan/Jasa</option>
                    </select>
                    <div class="invalid-feedback">
                      Produk dihasilkan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="terima_modal_dari">Pernah menerima bantuan modal dari</label>
                    <select id="terima_modal_dari" name="terima_modal_dari" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Pemerintah">Pemerintah</option>
                      <option value="Swasta">Swasta</option>
                      <option value="Belum Sama Sekali">Belum Sama Sekali</option>
                    </select>
                    <div class="invalid-feedback">
                      Terima Modal dari wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="apakah_sudah_dikemas">Apakah produk sudah dikemas</label>
                    <select id="apakah_sudah_dikemas" name="apakah_sudah_dikemas" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Ya">Ya</option>
                      <option value="Tidak">Tidak</option>
                    </select>
                    <div class="invalid-feedback">
                      Apakah sudah dikemas wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="teknik_pemasaran">Teknik pemasaran</label>
                    <select id="teknik_pemasaran" name="teknik_pemasaran" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Tradisional">Tradisional</option>
                      <option value="Modern (On Line)">Modern (On Line)</option>
                      <option value="Campuran">Campuran</option>
                    </select>
                    <div class="invalid-feedback">
                      Teknik Pemasaran wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="bahan_kemasan">Bahan Kemasan</label>
                    <select id="bahan_kemasan" name="bahan_kemasan" class="form-control" required>
                      <option value="">Pilih</option>
                      <option value="Plastik">Plastik</option>
                      <option value="Kertas">Kertas</option>
                      <option value="Lainnya">Lainnya</option>
                      <option value="Tidak Dikemas">Tidak Dikemas</option>
                    </select>
                    <div class="invalid-feedback">
                      Bahan Kemasan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="asal_konsumen">Asal Konsumen</label>
                    <select id="asal_konsumen" name="asal_konsumen" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Lokal">Lokal</option>
                      <option value="Luar">Luar</option>
                      <option value="Campuran">Campuran</option>
                    </select>
                    <div class="invalid-feedback">
                      Asal Konsumen wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="cara_kemasan">Cara Kemasan</label>
                    <select id="cara_kemasan" name="cara_kemasan" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Modern">Modern</option>
                      <option value="Tradisional">Tradisional</option>
                      <option value="Campuran">Campuran</option>
                      <option value="Tidak Dikemas">Tidak Dikemas</option>
                    </select>
                    <div class="invalid-feedback">
                      Cara Kemasan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="sarana_penunjang_produksi">Sarana penunjang produksi yang dimiliki</label>
                    <select id="sarana_penunjang_produksi" name="sarana_penunjang_produksi" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Lengkap">Lengkap</option>
                      <option value="Cukup">Cukup</option>
                      <option value="Kurang">Kurang</option>
                    </select>
                    <div class="invalid-feedback">
                      Sarana penunjang produksi wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="asal_bahan_baku">Asal bahan baku</label>
                    <select id="asal_bahan_baku" name="asal_bahan_baku" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Lokal">Lokal</option>
                      <option value="Luar Desa">Luar Desa</option>
                      <option value="Impor">Impor</option>
                    </select>
                    <div class="invalid-feedback">
                      Asal bahan baku wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="kondisi_bangunan">Kondisi bangunan</label>
                    <select id="kondisi_bangunan" name="kondisi_bangunan" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Permanen">Permanen</option>
                      <option value="Semi Permanen">Semi Permanen</option>
                      <option value="Sederhana">Sederhana</option>
                      <option value="Tanpa Bangunan">Tanpa Bangunan</option>
                    </select>
                    <div class="invalid-feedback">
                      Kondisi bangunan wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="pernah_menerima_pembinaan">Pernah menerima pembinaan/pelatihan dari</label>
                    <select id="pernah_menerima_pembinaan" name="pernah_menerima_pembinaan" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Pemerintah">Pemerintah</option>
                      <option value="Swasta/LSM/Lainnya">Swasta/LSM/Lainnya</option>
                      <option value="Belum Sama Sekali">Belum Sama Sekali</option>
                    </select>
                    <div class="invalid-feedback">
                      Pernah menerima pembinaan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="instansi_pembina">Instansi yang membina (sebutkan)</label>
                    <select name="instansi_pembina[]" class="form-control select2" required="" multiple="multiple" id="instansi_pembina">
                      @foreach($instansi_pembina as $value)
                        <option value="{{ $value->id }}" 
                          @php
                            if(isset($usaha)) { 
                              echo (in_array($value->id, @$detail_instansi_usaha)) ? 'selected' : '';
                            }; 
                          @endphp>
                          {{ $value->nama_instansi_pembina }}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Instansi Pembina wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="dampak_sosial_ekonomi">Dampak sosial ekonomi masyarakat setempat terhadap kegiatan UKM</label>
                    <select id="dampak_sosial_ekonomi" name="dampak_sosial_ekonomi" class="form-control" required>
                      <option value="">Pilih...</option>
                      <option value="Sangat berpengaruh">Sangat berpengaruh</option>
                      <option value="Berpengaruh">Berpengaruh</option>
                      <option value="Tidak Berpengaruh">Tidak Berpengaruh</option>
                    </select>
                    <div class="invalid-feedback">
                      Dampak sosial ekonomi wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="npwp">NPWP *Jika Ada*</label>
                  <input id="npwp" type="text" class="form-control" name="npwp" value="{{ @$usaha->npwp }}">
                  <div class="invalid-feedback">
                    NPWP wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="keterangan">Keterangan</label>
                  <textarea id="keterangan" class="form-control" name="keterangan" required style="height: 100px;">{{ @$usaha->keterangan }}</textarea>
                  <div class="invalid-feedback">
                    Keterangan wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="tanggal_simpan">Tanggal Simpan</label>
                  <input id="tanggal_simpan" type="text" class="form-control datepicker" name="tanggal_simpan" value="{{ @$usaha->tanggal_simpan }}" required>
                  <div class="invalid-feedback">
                    Tanggal_simpan wajib diisi.
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header"><h4>Data Perizinan</h4></div>
                <div class="card-body">
                  <template v-for="(izin, index) in perizinan">
                    <div class="table-responsive" :key="index">
                      <table class="table">
                        <tbody>
                          <tr>
                            <th class="px-0 form-group" scope="col"><label>Perizinan/Legalitas</label></th>
                            <th scope="col" class="px-2">
                              <select id="perizinan" :name="'perizinan[' + index + '][id_perizinan]'" v-model="izin.id_perizinan" class="form-control" required>
                                <option value="">Pilih...</option>
                                @foreach($perizinan as $value)
                                  <option value="{{ $value->id }}">{{ $value->singkatan }}</option>
                                @endforeach
                              </select>
                            </th>
                            <th scope="col" class="px-2"rowspan="2">
                              <input type="hidden" :name="'perizinan[' + index + '][id]'" v-model="izin.id">
                              <button type="button" class="btn btn-danger btn-icon" @click="deletePerizinan(index)"><i class="fas fa-times"></i></button></th>
                          </tr>
                          <tr>
                            <th class="px-0 form-group" scope="col"><label>No Izin</label></th>
                            <td class="px-2"><input type="text" class="form-control" :name="'perizinan[' + index + '][no_izin]'" v-model="izin.nomor" required></td>
                          </tr>
                        </tbody>
                      </table>
                      <hr>
                    </div>
                  </template>
                  <button type="button" class="btn btn-primary" @click="tambahPerizinan()"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="text-right">
            <input type="hidden" name="id" value="{{ @$usaha->id }}"/>
            <button type="submit" id="btn-store" class="btn btn-success btn-lg">SIMPAN</button>
          </div>
          </div>
        </form>
      </div>
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/select2-4.0.13/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/vuejs/vue.min.js') }}"></script>
    <script src="{{ asset('js/format_number.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script> 

    @if (isset($usaha))
      
      getDesa('{{ $usaha->id_kecamatan }}', '{{ $usaha->id_desa }}');
      
      let dataVue = {
        perizinan : @json($detail_perizinan_usaha),
      };
    
    @else

      let dataVue = {
        perizinan : [{
          id : '', 
          id_perizinan : '',
          nomor : '',
        }],
      };

    @endif

    var app = new Vue({
      el: '#app',
      data: dataVue,
      mounted () {
        //
      },
      methods: {
        tambahPerizinan: function () 
        {
          this.perizinan.push({
            id : '', 
            id_perizinan : '',
            nomor : '',
          });
        },
        deletePerizinan: function (index) 
        {
          this.perizinan.splice(index, 1);
        },
      },
    });

    function getDesa(id, id_desa = '') 
    {
      $('#id_desa').prop('disabled', true);
      var id  = id;
      var url = '{{ route("master.desa.get-desa", ":id") }}';
      url = url.replace(':id', id);
      $('#id_desa').html(new Option('Mengambil Data.....', ''));
      $.get(url, function( response ) {
        $('#id_desa').prop('disabled', false);
        $('#id_desa').html(new Option('Pilih.....', ''));
        $.each(response.data, function (key, value) {
          $('#id_desa').append('<option value="'+value.id+'" '+ ((value.id == id_desa) ? 'selected' : '') +'>'+value.nama_desa+'</option>');
        });
      });
    }

    $(function() {    

      // Select2
      if(jQuery().select2) {
        $(".select2").select2();
      }

      $('.js-select2-id-ukm').select2({
        ajax: {
            url: "{{ route('uem.individu.ajax-search') }}",
            data: function (params) {
                var query = {
                  search: params.term,
                  id_desa: $('#id_desa').val(),
                }
                return query;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.nama_pemilik,
                            ukm : item
                        }
                    })
                };
            },
        },
      });

      $('.js-select2-id-ukm').on('select2:select', function (e) {
        var data = e.params.data.ukm;
        console.log(data);
        $('#detail-ukm').show();
        $('#tb-nama-pemilik').text(data['nama_pemilik']);
        $('#tb-nik').text(data['nik']);
        $('#tb-jenis-kelamin').text(data['jenis_kelamin']);
        $('#tb-alamat').text(data['alamat_usaha']);
        $('#tb-status').text(data['nama_badan_usaha']);
        $('#tb-tahun-berdiri').text(data['tahun_berdiri']);
        // app.getBook(data.id);
      });
      
      $("#formInput").submit(function(e){
        e.preventDefault();
        var btn = $('#btn-store');
        btn.addClass('btn-progress');
        var formData = new FormData($(this)[0]);
        formData.append('_token', '{{ csrf_token() }}');
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data, textStatus, jqXHR) {
              $(".is-invalid").removeClass("is-invalid");
              if (data['status'] == true) {
                swal({
                  title: "Data berhasil disimpan!", 
                  icon: "success",
                })
                .then((value) => {
                  window.location = "{{ route('uem.usaha.index') }}";
                });
              }
              else {
                printErrorMsg(data.errors);
              }
              btn.removeClass('btn-progress');
            },
            error: function(data, textStatus, jqXHR) {
              alert('Terjadi kesalahan , Proses dibatalkan!');
            },
        });
      });

      @if (isset($usaha))
        let usaha = @json($usaha);
        populateForm($('#formInput'), usaha);
      @endif

    }); 
    </script>
  </x-slot>
</x-app-layout>