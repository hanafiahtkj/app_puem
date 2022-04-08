<x-app-layout>

  <x-slot name="title">DATA PENGGUNA</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>DATA PENGGUNA</h1>
        <div class="section-header-button">
          <a href="{{ route('master.pengguna.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> TAMBAH</a>
        </div>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Data Penggguna</div>
        </div>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table-users" style="width: 100%;">
                    <thead class="bg-primary">
                      <tr>
                        <th class="text-center" style="width: 30px;">
                          No
                        </th>
                        <th>Nama Lengkap</th>
                        <th>Nama Penggguna</th>
                        <th>Level</th>
                        <th>Status</th>
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
    <script>
    $(function() {

      @if (session('success'))
        iziToast.success({
          title: 'Success!',
          message: '{{ session('success') }}',
          position: 'topRight'
        });
      @endif

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
      var dataTable = $('#table-users').DataTable({
        processing: true,
        ajax: {
            url: '{{ route('master.pengguna.getDataTables') }}',
        },
        columns: [
          {data: 'id', "searchable": false},
          {data: 'name'},
          {data: 'username'},
          {data: 'role'},
          {data: 'status'},
          {data: null, "searchable": false},
        ],
        columnDefs  : [
          { targets: [0], searchable: false, orderable: false, className: "text-center" },
          {
              targets: 4,
              render: function ( data, type, row ) {
                var status = '';
                switch(row['status']) {
                  case 1:
                    status = '<span class="badge badge-info">Aktif</span>';
                    break;
                  default:
                  status = '<span class="badge badge-danger">Nonaktif</span>';
                }
                return status;
              },
            },
          {
            targets: 5,
            render: function ( data, type, row ) {
              var authid = '{{ Auth::User()->id }}';
              var url = '{{ route("master.pengguna.edit", ":id") }}';
              url = url.replace(':id', row['id']);
              var btn = '<div class="buttons"><a href="'+url+'" class="btn btn-icon btn-sm btn-primary" style="width: 29px;"><i class="far fa-edit"></i></a>';
              if (authid != row['id'])
              btn += '<a href="#" data-id="'+row['id']+'" class="btn btn-icon btn-sm btn-danger btn-delete" style="width: 29px;"><i class="fas fa-times"></i></a>';
              btn += '</div>';
              return btn;
            },
          },
        ],
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

      $('#table-users tbody').on( 'click', '.btn-delete', function () {
        var id = $(this).data('id');
        var url = '{{ route("master.pengguna.destroy", ":id") }}';
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
    
    });
    </script>
  </x-slot>

</x-app-layout>