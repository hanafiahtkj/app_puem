<x-app-layout>

  <x-slot name="title">DATA USAHA</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>DATA USAHA</h1>
        <div class="section-header-button">
          <a href="{{ route('uem.usaha.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> TAMBAH</a>
        </div>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Data Usaha</div>
        </div>
      </div>

      <div class="section-body">
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
                        <th>Desa</th>
                        <th>Alamat</th>
                        <th>Tahun Berdiri</th>
                        <th>Tenaga Kerja</th>
                        <th>No Perizinan</th>
                        <th>Keterangan</th>
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
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script>
      
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

      $(document).ready(function () {
        
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
          ajax: {
              url: "{{ route('uem.usaha.getDataTables') }}",
          },
          columns: [
            {data: null},
            {data: 'individu.nama_pemilik'},
            {data: 'individu.nik'},
            {data: 'nama_desa'},
            {data: 'individu.alamat_usaha'},
            {data: 'individu.tahun_berdiri'},
            {data: 'jumlah_tenaga_kerja'},
            {data: null},
            {data: 'keterangan'},
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
              targets: 10,
              searchable: false, 
              orderable: false, 
              render: function ( data, type, row ) {
                var url = '{{ route("uem.usaha.edit", ":id") }}';
                url = url.replace(':id', row['id']);
                var item = 
                  '<a class="dropdown-item btn-edit" href="'+url+'">Edit</a>'+
                  '<a class="dropdown-item btn-delete" href="javascript:void(0);" data-id="'+row['id']+'">Hapus</a>';
                btn = 
                  '<div class="dropdown">' +
                    '<button class="btn btn-outline-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>'+
                    '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'+
                      item
                    '</div>'+
                  '</div>';

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

        $('#dataTable tbody').on( 'click', '.btn-delete', function () {
          var id = $(this).data('id');
          var url = '{{ route("uem.usaha.destroy", ":id") }}';
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