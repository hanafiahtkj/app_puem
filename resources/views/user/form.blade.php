<x-app-layout>

  <x-slot name="title">{{ isset($user) ? 'EDIT PENGGUNA' : 'TAMBAH PENGGUNA' }}</x-slot>

  <x-slot name="extra_css">
    <style>
      .file {
        visibility: hidden;
        position: absolute;
      }
      .image-preview, #callback-preview {
        width: 200px!important;
        height: 200px!important;
      }
    </style>
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{ route('master.pengguna.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ isset($user) ? 'EDIT PENGGUNA' : 'TAMBAH PENGGUNA' }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('master.pengguna.index') }}">Pengguna</a></div>
          <div class="breadcrumb-item">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}</div>
        </div>
      </div>

      <div class="section-body">
        @if(isset($user))
          <form method="POST" action="{{ route('master.pengguna.update', $user->id) }}" novalidate="" enctype="multipart/form-data">
          @method('PATCH')
        @else
          <form method="POST" action="{{ route('master.pengguna.store') }}" novalidate="" enctype="multipart/form-data">
        @endif
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body pt-5">
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}">
                    @if($errors->has('name'))
                      <div class="invalid-feedback">{{$errors->first('name')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Pengguna</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control @if($errors->has('username')) is-invalid @endif" name="username" value="{{ old('username', isset($user) ? $user->username : '') }}" autocomplete="off">
                    @if($errors->has('username'))
                      <div class="invalid-feedback">{{$errors->first('username')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" autocomplete="off">
                    @if($errors->has('password'))
                      <div class="invalid-feedback">{{$errors->first('password')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Konfirmasi Password</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="password" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation">
                    @if($errors->has('password_confirmation'))
                      <div class="invalid-feedback">{{$errors->first('password_confirmation')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Level</label>
                  <div class="col-sm-12 col-md-7">
                    <select class="form-control @if($errors->has('level')) is-invalid @endif" id="level" name="level">
                      <option value="">Pilih Salah Satu</option>
                      @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ old('level', isset($roleName) ? $roleName : '') == $role->name ? "selected" : "" }}>{{ $role->name }}</option>
                      @endforeach
                    </select>
                    @if($errors->has('level'))
                      <div class="invalid-feedback">{{$errors->first('level')}}</div>
                    @endif
                    </div>
                </div>
                <div class="form-group row mb-4" id="form-kecamatan" style="display:none;">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="id_kecamatan">Kecamatan</label>
                  <div class="col-sm-12 col-md-7">
                    <select id="id_kecamatan" onChange="getDesa(this.value);" class="form-control @if($errors->has('id_kecamatan')) is-invalid @endif" name="id_kecamatan" required>
                      <option value="">Pilih....</option>
                      @foreach($kecamatan as $value)
                        <option value="{{ $value->id }}" {{ old('id_kecamatan', @$user->id_kecamatan) == $value->id ? "selected" : "" }}>{{ $value->nama_kecamatan }}</option>
                      @endforeach
                    </select>
                    @if($errors->has('id_kecamatan'))
                      <div class="invalid-feedback">Kecamatan wajib diisi.</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4" id="form-desa" style="display:none;">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="id_desa">Desa</label>
                  <div class="col-sm-12 col-md-7">
                    <select id="id_desa" class="form-control @if($errors->has('id_desa')) is-invalid @endif" name="id_desa" required disabled>
                      <option value="">Pilih....</option>
                    </select>
                    @if($errors->has('id_desa'))
                      <div class="invalid-feedback">Desa wajib diisi.</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4" id="form-foto">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
                  <div class="col-sm-12 col-md-7">
                    <div id="image-preview" class="image-preview" style="background-image: url('{{ isset($user) ? ($user->image != '') ? url(Storage::url($user->image)) : asset('img/no_img.jpg') : asset('img/no_img.jpg') }}'); background-size: cover; background-position: center center;">
                      <label for="image-upload" id="image-label">Choose File</label>
                      <input type="file" name="image" id="image-upload">
                    </div>
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                  <div class="col-sm-12 col-md-7">  
                    <select class="form-control selectric @if($errors->has('status')) is-invalid @endif" name="status" required>
                        <option value="">Pilih...</option>
                        <option value="1" {{ @$user->status === 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ @$user->status === 0 ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @if($errors->has('status'))
                      <div class="invalid-feedback">{{$errors->first('status')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                  <div class="col-sm-12 col-md-7">
                    <button class="btn btn-primary btn-lg">SiMPAN</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/jquery_upload_preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>

    <script> 

    function getDesa(id, id_desa = '') 
    {
      var id_desa = '{{ old('id_desa', @$user->id_desa) }}';
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
      $('[name="level"]').on('change',  function() {
        let value = $(this).val();
        if (value == 'Admin Kecamatan') {
          $('#form-kecamatan').show();
          $('#form-desa').hide();
          $('[name="id_desa"]').val('');
        } else if (value == 'Admin Desa') {
          $('#form-kecamatan').show();
          $('#form-desa').show();
        } else {
          $('#form-kecamatan').hide();
          $('#form-desa').hide();
          $('[name="id_kecamatan"]').val('');
          $('[name="id_desa"]').val('');
        }
      });

      $('[name="level"]').change();
      $('[name="id_kecamatan"]').change();

      $.uploadPreview({
        input_field: "#image-upload",
        preview_box: "#image-preview",
        label_field: "#image-label",
        label_default: "Choose File",
        label_selected: "Change File",
        no_label: false,           
        success_callback: null
      });
    }); 
    </script>
  </x-slot>
</x-app-layout>