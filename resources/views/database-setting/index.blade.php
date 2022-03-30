<x-app-layout>

    <x-slot name="title">Setting Database</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
      <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
      <link rel="stylesheet" href="{{ asset('vendor/bootstrap-colorpicker-3.2.0/dist/css/bootstrap-colorpicker.min.css') }}">
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <link rel="stylesheet" href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    </x-slot>
  
    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1>Setting Database</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
            <div class="breadcrumb-item">Database</div>
          </div>
        </div>
  
        <div class="section-body">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body p-1">
                  <div class="m-0 p-4">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Pilih Tabel Yang ingin di backup</label> 
                        <select class="form-control selectric select_table" name="" id="select_backup" multiple="multiple" onchange="handle_select()">
                            <option value="semua">Semua....</option>
                            @foreach ($tablesFilter as $key => $value)
                                <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                      </div>
                      <button type="button" id="cadangkan" class="btn btn-primary" onclick="submit_backup()"><i class="fa fa-refresh"></i> Cadangkan</button>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Pulihkan Database</label>
                        <input type="file" class="form-control" name="" id="pulihkan">
                      </div>
                      <button type="button" id="btnpulihkan" class="btn btn-primary" onclick="submit_restore()"><i class="fa fa-database"></i> Pulihkan</button>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" style="width: 100%;">
                      <thead class="bg-primary">
                        <tr>
                          <th class="text-center" style="width: 30px;">
                            No
                          </th>
                          <th>Nama File</th>
                          <th>Nama Database</th>
                          <th>Tanggal di cadangkan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                     
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <form method="POST" action="{{ route('logout') }}" style="display: none" id="logoutDBSetting">
      @csrf
    </form>

    <x-slot name="extra_js">
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('vendor/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
        <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap-colorpicker-3.2.0/dist/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('js/plugin.js') }}"></script>
        <script>
            
            $(document).ready(function() {
                $('.select_table').select2()
            })

            $(function() {
              
              var dt = $('#dataTable').DataTable({
                          processing: true,
                          serverSide: true,
                          lengthMenu: [
                            [10, 50, -1],
                            [10, 50, "All"]
                          ],
                          ajax: '{{ route('database-json') }}',
                          columns: [
                            {
                              data: 'no',
                              name: 'no'
                            },
                            {
                              data: 'database_file',
                              name: 'database_file'
                            },
                            {
                              data: 'nama_database',
                              name: 'nama_database'
                            },
                            {
                              data: 'tanggal_simpan',
                              name: 'tanggal_simpan'
                            },
                            {
                              data: 'action',
                              name: 'action',
                              orderable: false,
                              searchable: false
                            }
                          ]
                        });

            })

            function handle_select() {
                
                let optionSelectBackup = $('#select_backup').val()

       
                if (optionSelectBackup.length > 1) {
                    
                    if (optionSelectBackup.includes('semua')) {
  
                        $('#select_backup').val(null).trigger('change')
                        $('#select_backup').val(['semua']).trigger('change')
                    }


                }

            }

            function submit_backup(){

                let optionSelectBackup = $('#select_backup').val()

                if (optionSelectBackup  == null || optionSelectBackup == '') {
                    
                    alert("Pilih data yang ingin di backup")

                }else{

                    this.post_api_backup(optionSelectBackup)

                }
                

            }

            function submit_restore(){
              
                let fileSubmit = $('#pulihkan').val()
                let Extension = fileSubmit.substring(fileSubmit.lastIndexOf('.') + 1).toLowerCase()

                if (fileSubmit == null || fileSubmit == '') {
                    
                    alert("Pilih file yang ingin di restore")
                  
                }else{

                  if (Extension == 'sql') {
                    
                    // console.log( $('#pulihkan').prop('files')[0] );

                    this.post_api_restore( $('#pulihkan').prop('files')[0] )
                    
                  }else{

                    alert("File yang di restore harus berformat .sql")


                  }


                }
                

            }
            
            function post_api_restore(file) {

              $('#btnpulihkan').prop('disabled', true)
              $('#btnpulihkan').html('<i class="fa fa-spinner fa-spin"></i> Sedang memulihkan')

              const formData = new FormData();
              formData.append('sqlFile', file);
              
              fetch("/api/database-restore", {
                method: 'POST',
                credentials: "same-origin",
                headers: {
                  "X-CSRF-Token": $('input[name="_token"]').val()
                },
                body: formData
              })
              .then((res) => {
                console.log(res)
                alert("Berhasil memulihkan database, logout dan login kembali untuk melihat perubahan")
                $('#logoutDBSetting').submit()
                
              })
              .catch((err) => {
                console.log(err)
              })

            }

            function post_api_backup(bodyObject){

              $('#cadangkan').prop('disabled', true)
              $('#cadangkan').html('sedang mencadangkan...')

              fetch("/api/database-backup", {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": $('input[name="_token"]').val()
                    },
                    method: "POST",
                    credentials: "same-origin",
                    body: JSON.stringify({
                        data: bodyObject
                    })
                })
                    .then((res) => {
                    
                        return res.json()
                    })
                    .then((res) => {

                      $('#dataTable').DataTable().ajax.reload()
                      $('#cadangkan').prop('disabled', false)
                      $('#cadangkan').html('Cadangkan')
                      $('#select_backup').val(null).trigger('change')
                      alert("berhasil di cadangkan")

                    })
                    .catch((err) => {
                        console.log(err)
                    })
                

            }

            
        </script>
    </x-slot>
  
  </x-app-layout>