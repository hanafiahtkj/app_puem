<x-app-layout>

  <x-slot name="title">DATA INDIVIDU</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
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
              url: "{{ route('uem.individu.getDataTables') }}",
          },
          columns: [
            {data: null},
            {data: 'nama_pemilik'},
            {data: 'nik'},
            {data: 'jenis_kelamin'},
            {data: 'alamat_usaha'},
            {data: null},
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

        $('#dataTable tbody').on( 'click', '.btn-edit', function () {
          var idx = $(this).parents('tr');
          var data = dataTable.row(idx).data();
          populateForm($('#formModal'), data);
          getKomoditas(data.id_kategori_komoditas, data.id_komoditas) 
          getSubKomoditas(data.id_komoditas, data.id_sub_komoditas) 
          $('#formModal .modal-title').text('Ubah');
          $('#formModal').modal('show')
          var url = '{{ route("uem.individu.update", ":id") }}';
          url = url.replace(':id', data['id']);
          $("#formWrapperModal").attr('action', url);
          $('[name="_method"]').val('PATCH');
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
      
      });
    </script>
  </x-slot>

</x-app-layout>