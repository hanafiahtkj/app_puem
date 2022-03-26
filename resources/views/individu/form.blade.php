<x-app-layout>

  <x-slot name="title">{{ isset($individu) ? 'EDIT DATA INDIVIDU' : 'TAMBAH DATA INDIVIDU' }}</x-slot>

  <x-slot name="extra_css"></x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{ route('uem.individu.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ isset($individu) ? 'EDIT DATA INDIVIDU' : 'TAMBAH DATA INDIVIDU' }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('uem.individu.index') }}">Data Individu</a></div>
          <div class="breadcrumb-item">{{ isset($individu) ? 'Edit Data Individu' : 'Tambah Data Individu' }}</div>
        </div>
      </div>

      <div class="section-body">
        @if(isset($individu))
          <form method="POST" id="formInput" action="{{ route('uem.individu.update', $individu->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
          @method('PATCH')
        @else
          <form method="POST" id="formInput" action="{{ route('uem.individu.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
        @endif
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header"><h4>Data Individu</h4></div>
              <div class="card-body">
                <div class="form-group">
                  <label for="nama_pemilik">Nama Pemilik</label>
                  <input id="nama_pemilik" type="text" class="form-control" name="nama_pemilik" value="{{ old('nama_pemilik', @$individu->nama_pemilik) }}" required>
                  <div class="invalid-feedback">
                      Nama Pemilik wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input id="nik" type="text" class="form-control" name="nik" value="{{ old('nik', @$individu->nik) }}" required autofocus>
                    <div class="invalid-feedback">
                        NIK wajib diisi.
                    </div>
                </div>
                <div class="form-group">
                  <label for="no_hp">No Hp</label>
                  <input id="no_hp" type="text" class="form-control" name="no_hp" value="{{ old('no_hp', @$individu->no_hp) }}" required>
                  <div class="invalid-feedback">
                      No Hp wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                  <label for="nama_usaha">Nama Usaha</label>
                  <input id="nama_usaha" type="text" class="form-control" name="nama_usaha" value="{{ old('nama_usaha', @$individu->nama_usaha) }}" required>
                  <div class="invalid-feedback">
                      Nama Usaha wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                    <label for="alamat_usaha">Alamat Usaha</label>
                    <input id="alamat_usaha" type="text" class="form-control" name="alamat_usaha" value="{{ old('alamat_usaha', @$individu->alamat_usaha) }}" required>
                    <div class="invalid-feedback">
                        Alamat Usaha wajib diisi.
                    </div>
                </div> 
                <div class="form-group">
                  <label for="title">Kecamatan</label>
                  <select id="id_kecamatan" onChange="getDesa(this.value);" class="form-control selectric" name="id_kecamatan" required>
                    <option value="">Pilih....</option>
                    @foreach($kecamatan as $value)
                      <option value="{{ $value->id }}">{{ $value->nama_kecamatan }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">Kecamatan wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="title">Nama Desa</label>
                  <select id="id_desa" class="form-control selectric" name="id_desa" required>
                    <option value="">Pilih....</option>
                  </select>
                  <div class="invalid-feedback">Desa wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="title">Kategori Komoditas</label>
                  <select id="id_kategori_komoditas" onChange="getKomoditas(this.value);" class="form-control selectric" name="id_kategori_komoditas" required>
                    <option value="">Pilih....</option>
                    @foreach($kategori_komoditas as $value)
                      <option value="{{ $value->id }}">{{ $value->nama_kategori_komoditas }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">Kategori Komoditas wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="title">Komoditas</label>
                  <select id="id_komoditas" onChange="getSubKomoditas(this.value);" class="form-control selectric" name="id_komoditas" required>
                    <option value="">Pilih....</option>
                  </select>
                  <div class="invalid-feedback">Komoditas wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label for="title">Sub Komoditas</label>
                  <select id="id_sub_komoditas" class="form-control selectric" name="id_sub_komoditas" required>
                    <option value="">Pilih....</option>
                  </select>
                  <div class="invalid-feedback">Sub Komoditas wajib diisi.</div>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control selectric" name="status" required>
                      <option value="">Pilih...</option>
                      <option value="1" {{ @$individu->status === 1 ? 'selected' : '' }}>Aktif</option>
                      <option value="0" {{ @$individu->status === 0 ? 'selected' : '' }}>Nonaktif</option>
                  </select>
                  <div class="invalid-feedback">
                      Status wajib diisi.
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
                  window.location = "{{ route('uem.individu.index') }}";
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