<x-app-layout>

  <x-slot name="title">{{ isset($pasardesa) ? 'EDIT DATA PASAR DESA' : 'TAMBAH DATA PASAR DESA' }}</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-4.0.13/dist/css/select2.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{ route('pasar-desa.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ isset($pasardesa) ? 'EDIT DATA PASAR DESA' : 'TAMBAH PASAR DESA' }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('pasar-desa.index') }}">Data Pasar Desa</a></div>
          <div class="breadcrumb-item">{{ isset($pasardesa) ? 'Edit Data Pasar Desa' : 'Tambah Data Pasar Desa' }}</div>
        </div>
      </div>

      <div class="section-body">
        @if(isset($pasardesa))
          <form method="POST" id="formInput" action="{{ route('pasar-desa.update', $pasardesa->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
          @method('PATCH')
        @else
          <form method="POST" id="formInput" action="{{ route('pasar-desa.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
        @endif
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header"><h4>Data Pasar Desa</h4></div>
              <div class="card-body"> 
                <div class="form-group">
                  <label>Kecamatan</label>
                  <select id="id_kecamatan" onChange="getDesa(this.value);" class="form-control selectric" name="id_kecamatan" required>
                    <option value="">Pilih....</option>
                    @foreach($kecamatan as $value)
                      <option value="{{ $value->id }}" {{ @$pasardesa->id_kecamatan == $value->id ? 'selected' : '' }}>{{ $value->nama_kecamatan }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">Kecamatan wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label>Desa</label>
                  <select id="id_desa" class="form-control selectric" name="id_desa" required disabled></select>
                  <div class="invalid-feedback">Desa wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="tahun_berdiri">Tahun Berdiri</label>
                  <input type="text" name="tahun_berdiri" class="form-control numeric" required>
                  <div class="invalid-feedback">Tahun Berdiri wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="jumlah_pasar">Jumlah Pasar</label>
                  <input type="text" name="jumlah_pasar" class="form-control numeric" required>
                  <div class="invalid-feedback">Jumlah Pasar wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="sejarah">Sejarah Perkembangan</label>
                  <textarea name="sejarah" class="form-control"required></textarea>
                  <div class="invalid-feedback">Sejarah Perkembangan wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="instansi_pembina">Instansi yang membina (sebutkan)</label>
                  <select name="instansi_pembina[]" class="form-control select2" required="" multiple="multiple" id="instansi_pembina">
                    @foreach($instansi_pembina as $value)
                      <option value="{{ $value->id }}" 
                        @php
                          if(isset($pasardesa)) { 
                            echo (in_array($value->id, @$detail_instansi_pasar_desa)) ? 'selected' : '';
                          }; 
                        @endphp>
                        {{ $value->nama_instansi_pembina }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">
                    Instansi Pembina wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="kegiatan_pasar">Kegiatan Pasar dalam sebulan</label>
                  <select id="kegiatan_pasar" name="kegiatan_pasar" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="1-4 Kali">1-4 Kali</option>
                    <option value="5-8 Kali">5-8 Kali</option>
                    <option value="Setiap Hari">Setiap Hari</option>
                  </select>
                  <div class="invalid-feedback">
                    Kegiatan Pasar dalam sebulan wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="status_lahan">Status Lahan</label>
                  <select id="status_lahan" name="status_lahan" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="Milik Desa">Milik Desa</option>
                    <option value="Perorangan">Perorangan</option>
                    <option value="Hibah">Hibah</option>
                  </select>
                  <div class="invalid-feedback">
                    Status Lahan wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="status_pengelolaan">Status Pengelolaan</label>
                  <select id="status_pengelolaan" name="status_pengelolaan" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="Pemdes">Pemdes</option>
                    <option value="Swasta">Swasta</option>
                    <option value="APBN">APBN</option>
                  </select>
                  <div class="invalid-feedback">
                    Status Pengelolaan wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="sumber_dana_pembangunan">Sumber Dana Pembangunan</label>
                  <select id="sumber_dana_pembangunan" name="sumber_dana_pembangunan" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="APDB">APDB</option>
                    <option value="Swasta">Swasta</option>
                    <option value="APBN">APBN</option>
                  </select>
                  <div class="invalid-feedback">
                    Sumber Dana Pembangunan wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="kondisi_bangunan">Kondisi Bangunan</label>
                  <select id="kondisi_bangunan" name="kondisi_bangunan" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="Permanen">Permanen</option>
                    <option value="Semi Permanen">Semi Permanen</option>
                    <option value="Sederhana">Sederhana</option>
                  </select>
                  <div class="invalid-feedback">
                    Kondisi Bangunan wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="kondisi_fisik_bangunan">Kondisi Fisik Bangunan</label>
                  <select id="kondisi_fisik_bangunan" name="kondisi_fisik_bangunan" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="Sangat Baik">Sangat Baik</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Buruk">Buruk</option>
                  </select>
                  <div class="invalid-feedback">
                    Kondisi Fisik Bangunan wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="perlu_perbaikan">Perlu Adanya Perbaikan Fisik</label>
                  <select id="perlu_perbaikan" name="perlu_perbaikan" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="Sangat Mendesak">Sangat Mendesak</option>
                    <option value="Perlu">Perlu</option>
                    <option value="Tidak Perlu">Tidak Perlu</option>
                  </select>
                  <div class="invalid-feedback">
                    Perlu Perbaikan wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="bantuan_dari">Pernah Menerima Bantuan dari</label>
                  <select id="bantuan_dari" name="bantuan_dari" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="APDB">APDB</option>
                    <option value="Swasta">Swasta</option>
                    <option value="APBN">APBN</option>
                    <option value="Belum Ada">Belum ada</option>
                  </select>
                  <div class="invalid-feedback">
                    Bantuan Dari wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="omzet">Omzet Pasar Satu Kegiatan</label>
                  <select id="omzet" name="omzet" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="<=Rp. 50Jt"><=Rp. 50Jt</option>
                    <option value="Rp. 50jt - Rp. 200jt">Rp. 50jt - Rp. 200jt</option>
                    <option value=">=Rp.200jt">>=Rp.200jt</option>
                  </select>
                  <div class="invalid-feedback">
                    Omzet wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="jumlah_pelaku_usaha">Jumlah Pelaku Usaha</label>
                  <select id="jumlah_pelaku_usaha" name="jumlah_pelaku_usaha" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="<=100 Pedagang"><=100 Pedagang</option>
                    <option value="100-200 Pedagang">100-200 Pedagang</option>
                    <option value=">=200 Pedagang">>=200 Pedagang</option>
                  </select>
                  <div class="invalid-feedback">
                    Jumlah Pelaku Usaha wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="asal_pelaku_usaha">Asal Pelaku Usaha</label>
                  <select id="asal_pelaku_usaha" name="asal_pelaku_usaha" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="Lokal">Lokal</option>
                    <option value="Luar">Luar</option>
                    <option value="Impor">Impor</option>
                  </select>
                  <div class="invalid-feedback">
                    Asal Pelaku Usaha wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="dampak_sosial">Dampak Sosial Ekonomi Masyarakat Setempat Terhadap Keberadaan Pasar</label>
                  <select id="dampak_sosial" name="dampak_sosial" class="form-control" required>
                    <option value="">Pilih...</option>
                    <option value="Sangat Berpengaruh">Sangat Berpengaruh</option>
                    <option value="Berpengaruh">Berpengaruh</option>
                    <option value="Tidak Berpengaruh">Tidak Berpengaruh</option>
                  </select>
                  <div class="invalid-feedback">
                    Dampak Sosial wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="keterangan">Keterangan</label>
                  <textarea name="keterangan" class="form-control"required></textarea>
                  <div class="invalid-feedback">Keterangan wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="tanggal_simpan">Tanggal Simpan</label>
                  <input id="tanggal_simpan" type="text" class="form-control datepicker" name="tanggal_simpan" value="{{ @$pasardesa->tanggal_simpan }}" required>
                  <div class="invalid-feedback">
                    Tanggal_simpan wajib diisi.
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <input type="hidden" name="id" value="{{ @$pasardesa->id }}"/>
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
    <script src="{{ asset('vendor/select2-4.0.13/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script> 

    @if (isset($pasardesa))
      getDesa('{{ $pasardesa->id_kecamatan }}', '{{ $pasardesa->id_desa }}');
    @endif

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
                  window.location = "{{ route('pasar-desa.index') }}";
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

      @if (isset($pasardesa))
        let pasardesa = @json($pasardesa);
        populateForm($('#formInput'), pasardesa);
      @endif

    }); 
    </script>
  </x-slot>
</x-app-layout>