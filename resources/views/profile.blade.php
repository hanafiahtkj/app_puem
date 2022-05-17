<x-app-layout>

    <x-slot name="title">Profile</x-slot>
  
    <x-slot name="extra_css">
      <style></style>
    </x-slot>
    
    <!-- Main Content -->
      <div class="main-content">
          <section class="section">
            <div class="section-header">
              <h1>PROFIL</h1>
            </div>
            <div class="section-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-header">
                      <h4>Profil</h4>
                    </div>
                    <div class="card-body">
                      <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                          <a class="nav-link active" id="utama-tab" data-toggle="tab" href="#utama" role="tab" aria-controls="utama" aria-selected="true">Utama</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="pass-tab" data-toggle="tab" href="#pass" role="tab" aria-controls="pass" aria-selected="false">Ganti Password</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="card">
                    <!-- <div class="card-header">
                      <h4>Write Your Post</h4>
                    </div> -->
                    <div class="card-body pt-5">
                      
                      <div class="tab-content no-padding" id="tabContent">
                        
                        <div class="tab-pane fade show active" id="utama" role="tabpanel" aria-labelledby="utama-tab">
                          <form id="updateProfileInformation" method="POST" action="{{ route('profile.updateProfileInformation') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                          @csrf
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="text" class="form-control" name="name" value="{{ $profile->name }}" required>
                              <div class="invalid-feedback">Nama wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Username</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="text" class="form-control" name="username" value="{{ $profile->username }}">
                              <div class="invalid-feedback">Username wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4" id="form-foto">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
                            <div class="col-sm-12 col-md-8">
                              <div id="image-preview" class="image-preview" style="background-image: url('{{ ($profile->image != '') ? url(Storage::url($profile->image)) : asset('img/no_img.jpg') }}'); background-size: cover; background-position: center center;">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-8">
                              <button class="btn btn-dark btn-lg">SIMPAN</button>
                            </div>
                          </div>
                          </form>
                        </div>
      
                        <div class="tab-pane fade" id="pass" role="tabpanel" aria-labelledby="pass-tab">
                          <form method="POST" id="updatePassword" action="{{ route('profile.updatePassword') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                          @csrf
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password Sekarang</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="password" class="form-control" name="current_password" value="" required>
                              <div class="invalid-feedback">Password Sekarang wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password Baru</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="password" class="form-control" name="password" value="" required>
                              <div class="invalid-feedback">Password wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Konfirmasi Password</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="password" class="form-control" name="password_confirmation" value="" required>
                              <div class="invalid-feedback">Konfirmasi Password wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-8">
                              <button class="btn btn-dark btn-lg">SIMPAN</button>
                            </div>
                          </div>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
  
    <x-slot name="extra_js">
      <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
      <script src="{{ asset('vendor/jquery_upload_preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
      <script src="{{ asset('js/plugin.js') }}"></script>
      <script>

      $(function() {
        
        $.uploadPreview({
          input_field: "#image-upload",   // Default: .image-upload
          preview_box: "#image-preview",  // Default: .image-preview
          label_field: "#image-label",    // Default: .image-label
          label_default: "Choose File",   // Default: Choose File
          label_selected: "Change File",  // Default: Change File
          no_label: false,                // Default: false
          success_callback: null          // Default: null
        });

        $("#updateProfileInformation").submit(function(e){
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

        $("#updatePassword").submit(function(e){
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
