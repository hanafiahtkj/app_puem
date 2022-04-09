<x-app-layout>

  <x-slot name="title">DATA INDIVIDU</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-4.0.13/dist/css/select2.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>DATA INDIVIDU</h1>
        <div class="section-header-button">
          <a href="{{ route('uem.individu.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> TAMBAH</a>
        </div>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Data Individu</div>
        </div>
      </div>

      <div class="section-body">
        <form id="report" method="GET" action="{{ route('uem.individu.export') }}" target="_blank" class="needs-validation" novalidate>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body p-1">
                  <div class="m-0 p-4">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-name">Kecamatan</label>
                          <select class="form-control select2" name="id_kecamatan" id="id_kecamatan" onChange="getDesa(this.value);" required>
                            <option value="">Semua....</option>
                            @foreach ($kecamatan as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->nama_kecamatan }}</option>
                            @endforeach
                          </select>
                          <div class="invalid-feedback">
                            Kecamatan wajib diisi.
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-name">Desa</label>
                          <select class="form-control select2" name="id_desa" id="id_desa">
                            <option value="">Semua....</option>
                          </select>
                          <div class="invalid-feedback">
                            Desa wajib diisi.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <button type="button" id="button-filter" class="btn btn-primary pull-right mr-2 mb-2"><i class="fa fa-filter"></i> Filter</button>
                        <div class="btn-group mr-2 mb-2">
                          <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-file-pdf"></i> Export PDF
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item submit" data-type="rekap_desa" data-extension="pdf" href="javascript:void(0);">Rekap Desa</a>
                            <a class="dropdown-item submit" data-type="rekap_kecamatan" data-extension="pdf" href="javascript:void(0);">Rekap Kecamatan</a>
                          </div>
                        </div>
                        <div class="btn-group mr-2 mb-2">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-file-excel"></i> Export Excel
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item submit" data-type="rekap_desa" data-extension="excel" href="javascript:void(0);">Rekap Desa</a>
                            <a class="dropdown-item submit" data-type="rekap_kecamatan" data-extension="excel" href="javascript:void(0);">Rekap Kecamatan</a>
                          </div>
                        </div>
                        <input type="hidden" name="extension" id="extension">
                        <input type="hidden" name="type" id="type">
                        <div class="d-none"><input type="submit" id="btn-export"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
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
                        <th>Nama Pemilik</th>
                        <th>Nik</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Status Usaha</th>
                        <th>Tahun Berdiri</th>
                        <th>Tanggal Simpan</th>
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

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('vendor/select2-4.0.13/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script>
    
      function getDesa(id, id_desa = '') 
      {
        var id  = id;
        var url = '{{ route("master.desa.get-desa", ":id") }}';
        url = url.replace(':id', id);
        $('#id_desa').html('');
        $('#id_desa').append(new Option('Semua.....', ''))
        $.get(url, function( response ) {
          $.each(response.data, function (key, value) {
            $('#id_desa').append('<option value="'+value.id+'" '+ ((value.id == id_desa) ? 'selected' : '') +'>'+value.nama_desa+'</option>');
          });
        });
      }

      $(document).ready(function () {

        $.extend($.fn.dataTable.defaults, {
          language: { url: "{{ asset('vendor/DataTables/id.json') }}" }
        });
        
        $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
        {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
        };
        var dataTable = $('#dataTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url: "{{ route('uem.individu.getDataTables') }}",
            data: function (d) {
              d.id_kecamatan = $('#id_kecamatan').val();
              d.id_desa = $('#id_desa').val();
            }
          },
          columns: [
            {data: null},
            {data: 'nama_pemilik'},
            {data: 'nik'},
            {data: 'jenis_kelamin'},
            {data: 'alamat_usaha'},
            {data: 'nama_badan_usaha'},
            {data: 'tahun_berdiri'},
            {data: 'tanggal_simpan'},
            {data: null},
          ],
          columnDefs : [
            { 
              targets: 0, 
              searchable: false, 
              orderable: false, 
              className: "text-center"
            },
            {
              targets: 8,
              searchable: false, 
              orderable: false, 
              render: function ( data, type, row ) {
                var url = '{{ route("uem.individu.edit", ":id") }}';
                url = url.replace(':id', row['id']);
                var btn = '<div class="buttons"><a href="'+url+'" class="btn btn-icon btn-sm btn-primary btn-edit" style="width: 29px;"><i class="far fa-edit"></i></a>';
                btn += '<a href="javascript:void(0);" data-id="'+row['id']+'" class="btn btn-icon btn-sm btn-danger btn-delete" style="width: 29px;"><i class="fas fa-times"></i></a>';
                btn += '</div>';
                return btn;
              },
            },
          ],
          order: [[ 1, "asc" ]],
          rowCallback : function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
          }
        });

        $('#button-filter').on('click', function () {
          dataTable.ajax.reload();
        });

        $('#dataTable tbody').on( 'click', '.btn-delete', function () {
          var id = $(this).data('id');
          var url = '{{ route("uem.individu.destroy", ":id") }}';
          url = url.replace(':id', id);
          swal({
              title: 'Yakin ingin menghapus?',
              icon: 'warning',
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({
                  url: url,
                  data : {_token:'{{ csrf_token() }}'},
                  type : "DELETE",
                  dataType: "json",
                  cache: true,
                  success: function(response) {
                    dataTable.ajax.reload();
                  }
                });
              }
            });
        });

        // Select2
        if(jQuery().select2) {
          $(".select2").select2();
        }

        $('.submit').on('click', function () {
          $('#type').val($(this).data('type'));
          $('#extension').val($(this).data('extension'));

          if ($(this).data('type') == 'rekap_desa') {
            $('#id_desa').prop('required', true);
          }
          else {
            $('#id_desa').prop('required', false);
          }

          $('#btn-export').click();
        });
      
      });
    </script>
  </x-slot>

</x-app-layout>