<x-app-layout>

  <x-slot name="title">DATA PRODUK</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>DATA PRODUK</h1>
        <div class="section-header-button">
          <button class="btn btn-primary" id="btn-create"><i class="fa fa-plus"></i> TAMBAH</button>
        </div>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Data Produk</div>
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
                        <th>Komoditas</th>
                        <th>Sub Komoditas</th>
                        <th>Produk</th>
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

  @include('produk.modal')

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
              url: "{{ route('master.produk.getDataTables') }}",
          },
          columns: [
            {data: null},
            {data: 'nama_komoditas'},
            {data: 'nama_sub_komoditas'},
            {data: 'nama_produk'},
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
              targets: 4,
              searchable: false, 
              orderable: false, 
              render: function ( data, type, row ) {
                var url = '{{ route("master.produk.edit", ":id") }}';
                url = url.replace(':id', row['id']);
                var btn = '<div class="buttons"><a href="javascript:void(0);" class="btn btn-icon btn-sm btn-primary btn-edit" style="width: 29px;"><i class="far fa-edit"></i></a>';
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
        
        $('#btn-create').click(function () {
          var url = '{{ route("master.produk.store") }}';
          $("#formWrapperModal").attr('action', url);
          $('#formModal .modal-title').text('Tambah');
          $('[name="_method"]').val('POST');
          $('#formModal').modal('show');
        });

        $("#formWrapperModal").submit(function(e){
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
                  dataTable.ajax.reload();
                  $('#formModal').modal('hide');
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

        $('#dataTable tbody').on( 'click', '.btn-edit', function () {
          var idx = $(this).parents('tr');
          var data = dataTable.row(idx).data();
          populateForm($('#formModal'), data);
          getKomoditas(data.id_kategori_komoditas, data.id_komoditas) 
          getSubKomoditas(data.id_komoditas, data.id_sub_komoditas) 
          $('#formModal .modal-title').text('Ubah');
          $('#formModal').modal('show')
          var url = '{{ route("master.produk.update", ":id") }}';
          url = url.replace(':id', data['id']);
          $("#formWrapperModal").attr('action', url);
          $('[name="_method"]').val('PATCH');
        });

        $('#dataTable tbody').on( 'click', '.btn-delete', function () {
          var id = $(this).data('id');
          var url = '{{ route("master.produk.destroy", ":id") }}';
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

        $('#formModal').on('hidden.bs.modal', function (event) {
          $("#formWrapperModal .form-control").removeClass("is-invalid");
          $("#formWrapperModal").removeClass("was-validated");
          $('#formWrapperModal').trigger("reset");
        });
      
      });
    </script>
  </x-slot>

</x-app-layout>