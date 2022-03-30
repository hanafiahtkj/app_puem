<x-app-layout>

  <x-slot name="title">{{ isset($individu) ? 'EDIT DATA USAHA' : 'TAMBAH DATA USAHA' }}</x-slot>

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
        <h1>{{ isset($individu) ? 'EDIT DATA USAHA' : 'TAMBAH DATA USAHA' }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('uem.usaha.index') }}">Data Usaha</a></div>
          <div class="breadcrumb-item">{{ isset($individu) ? 'Edit Data Usaha' : 'Tambah Data Usaha' }}</div>
        </div>
      </div>

      <div class="section-body">
        @if(isset($individu))
          <form method="POST" id="formInput" action="{{ route('uem.usaha.update', $individu->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
          @method('PATCH')
        @else
          <form method="POST" id="formInput" action="{{ route('uem.usaha.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
        @endif
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header"><h4>Data Usaha</h4></div>
              <div class="card-body">
                <div class="form-group">
                  <label for="id_kecamatan">Kecamatan</label>
                  <select id="id_kecamatan" onChange="getDesa(this.value);" class="form-control selectric" name="id_kecamatan" required>
                    <option value="">Pilih....</option>
                    @foreach($kecamatan as $value)
                      <option value="{{ $value->id }}" {{ @$individu->id_kecamatan == $value->id ? 'selected' : '' }}>{{ $value->nama_kecamatan }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">Kecamatan wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="id_desa">Nama Desa</label>
                  <select id="id_desa" class="form-control selectric" name="id_desa" required>
                    <option value="">Pilih....</option>
                  </select>
                  <div class="invalid-feedback">Desa wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="id_ukm">UKM</label>
                  <select id="id_ukm" class="form-control selectric js-select2-id-ukm" name="id_ukm" required>
                    <option value="">Pilih....</option>
                  </select>
                  <div class="invalid-feedback">UKM wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="id_ukm">Detail UKM</label>
                  <div class="jumbotron p-4 m-0">
                    <table border="0" cellpadding="4" cellspacing="0">
                      <tbody>
                        <tr>
                          <td>Nama Pemilik</td><td>:</td><td>Ari Widodo</td>
                        </tr>
                        <tr>
                          <td>NIK</td><td>:</td><td>6301101010700002</td>
                        </tr>
                        <tr>
                          <td>Jenis Kelamin</td><td>:</td><td>Laki-Laki</td>
                        </tr>
                        <tr>
                          <td>Alamat</td><td>:</td><td></td>
                        </tr>
                        <tr>
                          <td>Status Usaha</td><td>:</td><td>Perorangan</td>
                        </tr>
                        <tr>
                          <td>Tahun Berdiri</td><td>:</td><td>2008</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="jumlah_tenaga_kerja">Jumlah Tenaga Kerja</label>
                    <input id="jumlah_tenaga_kerja" type="text" class="form-control numeric" name="jumlah_tenaga_kerja" value="{{ @$individu->jumlah_tenaga_kerja }}" required>
                    <div class="invalid-feedback">
                      Jumlah Tenaga Kerja wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="harga_jual_produk">Harga Jual Produk</label>
                    <input id="harga_jual_produk" type="text" class="form-control currency" name="harga_jual_produk" value="{{ @$individu->harga_jual_produk }}" required>
                    <div class="invalid-feedback">
                      Harga Jual Produk wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="hari_kerja_sebulan">Rata-rata hari kerja sebulan</label>
                    <input id="hari_kerja_sebulan" type="text" class="form-control numeric" name="hari_kerja_sebulan" value="{{ @$individu->hari_kerja_sebulan }}" required>
                    <div class="invalid-feedback">
                      Rata-rata hari kerja sebulan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="nilai_investasi">Nilai Investasi</label>
                    <input id="nilai_investasi" type="text" class="form-control currency" name="nilai_investasi" value="{{ @$individu->nilai_investasi }}" required>
                    <div class="invalid-feedback">
                      Nilai Investasi wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="omzet_perhari">Omzet Perhari</label>
                    <input id="omzet_perhari" type="text" class="form-control currency" name="omzet_perhari" value="{{ @$individu->omzet_perhari }}" required>
                    <div class="invalid-feedback">
                      Omzet Perhari wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="nilai_asset">Nilai Investasi</label>
                    <input id="nilai_asset" type="text" class="form-control currency" name="nilai_asset" value="{{ @$individu->nilai_asset }}" required>
                    <div class="invalid-feedback">
                      Nilai Asset wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="instansi_pembina">Instansi yang membina (sebutkan)</label>
                    <select name="instansi_pembina[]" class="form-control" required="" multiple="multiple" id="instansi_pembina"></select>
                    <div class="invalid-feedback">
                      Instansi Pembina wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="pernah_menerima_pembinaan">Pernah menerima pembinaan/pelatihan dari</label>
                    <select id="pernah_menerima_pembinaan" name="pernah_menerima_pembinaan" class="form-control" required>
                      <option value="">Pilih...</option>
                    </select>
                    <div class="invalid-feedback">
                      Pernah menerima pembinaan wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="layanan_ukm">Kegiatan produksi/layanan ukm dalam 1 bulan</label>
                    <select id="layanan_ukm" name="layanan_ukm" class="form-control" required>
                      <option value="" selected="selected"></option>
                    </select>
                    <div class="invalid-feedback">
                      Layanan Ukm wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="bantuan_alat">Sudah mendapatkan bantuan alat</label>
                    <select id="bantuan_alat" name="bantuan_alat" class="form-control" required>
                      <option value="">Pilih...</option>
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
                      <option value="" selected="selected"></option>
                    </select>
                    <div class="invalid-feedback">
                      Produk dihasilkan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="terima_modal_dari">Pernah menerima bantuan modal dari</label>
                    <select id="terima_modal_dari" name="terima_modal_dari" class="form-control" required>
                      <option value="">Pilih...</option>
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
                      <option value="" selected="selected"></option>
                    </select>
                    <div class="invalid-feedback">
                      Apakah sudah dikemas wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="teknik_pemasaran">Teknik pemasaran</label>
                    <select id="teknik_pemasaran" name="teknik_pemasaran" class="form-control" required>
                      <option value="">Pilih...</option>
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
                      <option value="" selected="selected"></option>
                    </select>
                    <div class="invalid-feedback">
                      Bahan Kemasan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="asal_konsumen">Asal Konsumen</label>
                    <select id="asal_konsumen" name="asal_konsumen" class="form-control" required>
                      <option value="">Pilih...</option>
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
                      <option value="" selected="selected"></option>
                    </select>
                    <div class="invalid-feedback">
                      Cara Kemasan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="sarana_penunjang_produksi">Sarana penunjang produksi yang dimiliki</label>
                    <select id="sarana_penunjang_produksi" name="sarana_penunjang_produksi" class="form-control" required>
                      <option value="">Pilih...</option>
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
                      <option value="" selected="selected"></option>
                    </select>
                    <div class="invalid-feedback">
                      Asal bahan baku wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="dampak_sosial_ekonomi">Dampak sosial ekonomi masyarakat setempat terhadap kegiatan UKM</label>
                    <select id="dampak_sosial_ekonomi" name="dampak_sosial_ekonomi" class="form-control" required>
                      <option value="">Pilih...</option>
                    </select>
                    <div class="invalid-feedback">
                      Dampak sosial ekonomi wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="kondisi_bangunan">Kondisi bangunan</label>
                    <select id="kondisi_bangunan" name="kondisi_bangunan" class="form-control" required>
                      <option value="" selected="selected"></option>
                    </select>
                    <div class="invalid-feedback">
                      Kondisi bangunan wajib diisi.
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="npwp">NPWP *Jika Ada*</label>
                  <input id="npwp" type="text" class="form-control" name="keterangan" value="{{ @$individu->npwp }}" required>
                  <div class="invalid-feedback">
                    NPWP wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="keterangan">Keterangan</label>
                  <textarea id="keterangan" class="form-control" name="keterangan" required style="height: 100px;">{{ @$individu->keterangan }}</textarea>
                  <div class="invalid-feedback">
                    Keterangan wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="tanggal_simpan">Tanggal Simpan</label>
                  <input id="tanggal_simpan" type="text" class="form-control datepicker" name="tanggal_simpan" value="{{ @$individu->tanggal_simpan }}" required>
                  <div class="invalid-feedback">
                    Tanggal_simpan wajib diisi.
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="perizinan">Perizinan</label>
                    <select id="perizinan" name="perizinan[]" multiple="multiple" class="form-control" required>
                      <option value="" selected="selected"></option>
                    </select>
                    <div class="invalid-feedback">
                      Perizinan wajib diisi.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="no_izin">No Izin</label>
                    <select id="no_izin" name="no_izin[]" class="form-control" required>
                      <option value="">Pilih...</option>
                    </select>
                    <div class="invalid-feedback">
                      No Izin wajib diisi.
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <input type="hidden" name="id" value="{{ @$individu->id }}"/>
                <button type="submit" id="btn-store" class="btn btn-success btn-lg">SIMPAN</button>
              </div>
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
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script> 

    function getDesa(id, id_desa = '') 
    {
      var id  = id;
      var url = '{{ route("master.desa.get-desa", ":id") }}';
      url = url.replace(':id', id);
      $('#id_desa').html('');
      $('#id_desa').append(new Option('Pilih.....', ''))
      $.get(url, function( response ) {
        $.each(response.data, function (key, value) {
          $('#id_desa').append('<option value="'+value.id+'" '+ ((value.id == id_desa) ? 'selected' : '') +'>'+value.nama_desa+'</option>');
        });
      });
    }

    function getKomoditas(id, id_komoditas = '') 
    {
      var id  = id;
      var url = '{{ route("master.komoditas.get-komoditas", ":id") }}';
      url = url.replace(':id', id);
      $('#id_komoditas').html('');
      $('#id_komoditas').append(new Option('Pilih.....', ''))
      $.get(url, function( response ) {
        $.each(response.data, function (key, value) {
          $('#id_komoditas').append('<option value="'+value.id+'" '+ ((value.id == id_komoditas) ? 'selected' : '') +'>'+value.nama_komoditas+'</option>');
        });
      });
    }

    function getSubKomoditas(id, id_sub_komoditas = '') 
    {
      var id  = id;
      var url = '{{ route("master.sub-komoditas.get-sub-komoditas", ":id") }}';
      url = url.replace(':id', id);
      $('#id_sub_komoditas').html('');
      $('#id_sub_komoditas').append(new Option('Pilih.....', ''))
      $.get(url, function( response ) {
        $.each(response.data, function (key, value) {
          $('#id_sub_komoditas').append('<option value="'+value.id+'" '+ ((value.id == id_sub_komoditas) ? 'selected' : '') +'>'+value.nama_sub_komoditas+'</option>');
        });
      });
    }

    $(function() {

      @if (isset($individu))
        getDesa('{{ $individu->id_kecamatan }}', '{{ $individu->id_desa }}');
        getKomoditas('{{ $individu->id_kategori_komoditas }}', '{{ $individu->id_komoditas }}');
        getSubKomoditas('{{ $individu->id_komoditas }}', '{{ $individu->id_sub_komoditas }}');
      @endif

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
        var data = e.params.data;
        console.log(data);
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

    }); 
    </script>
  </x-slot>
</x-app-layout>