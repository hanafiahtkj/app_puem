<x-app-layout>

  <x-slot name="title">Pengaturan</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{ route('setting.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Pengaturan</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">{{ 'Pengaturan' }}</div>
        </div>
      </div>

      <div class="section-body">
        <form method="POST" action="{{ route('setting.update', $setting->id) }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h4>Pengaturan</h4>
              </div>
              <div class="card-body">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a class="nav-link active" id="utama-tab" data-toggle="tab" href="#utama" role="tab" aria-controls="utama" aria-selected="true">Utama</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-body pt-5">
                <div class="tab-content no-padding" id="tabContent">
                  <div class="tab-pane fade show active" id="utama" role="tabpanel" aria-labelledby="utama-tab">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mengetahui</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="mengetahui" value="{{ $setting->mengetahui }}" required>
                        <div class="invalid-feedback">Mengetahui wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama PPTK</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="nama_pptk" value="{{ $setting->nama_pptk }}" required>
                        <div class="invalid-feedback">Nama PPTK wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NIP</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="nip" value="{{ $setting->nip }}" required>
                        <div class="invalid-feedback">NIP wajib diisi.</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="row">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                  <div class="col-sm-12 col-md-8">
                    <button class="btn btn-primary">SIMPAN</button>
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
    <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('js/format_number.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>

    <script> 
    $(function() {
      @if (session('success'))
        iziToast.success({
          title: 'Success!',
          message: '{{ session('success') }}',
          position: 'topRight'
        });
      @endif
    }); 
    </script>
  </x-slot>
</x-app-layout>