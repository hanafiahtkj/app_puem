<x-app-layout>

  <x-slot name="title">DATA BUMDES</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-colorpicker-3.2.0/dist/css/bootstrap-colorpicker.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>DATA BUMDES</h1>
        <div class="section-header-button">
          <a href="{{ route('bumdes-create') }}" class="btn btn-primary"> <i class="fa fa-plus"> Tambah</i> </a>
          <button class="btn btn-success" data-toggle="modal" data-target="#excelModal"><i class="fa fa-file-excel"> Export Excel</i></button>
        </div>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Data Bumdes</div>
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
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>Nama Bumdes</th>
                        <th>Nama Direktur</th>
                        <th>NO. Perdes</th>
                        <th>Tahun Berdiri</th>
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

  <!-- Modal -->
  <div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Export Rekap data BUMDES</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="{{ route('bumdes-excel') }}" method="POST">
           @csrf
          <div class="form-group">
            <label for="">Kecamatan</label>
            <select class="form-control" name="kecamatan" id="" required>
              <option>Pilih</option>
              <option value="all">Semua</option>
              @foreach ($kecamatan as $item)
                <option value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Export</button>
         </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-colorpicker-3.2.0/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script>
     
     $(document).ready(function() {

      @if (Session::has('bumdes_sess'))
        swal("Berhasil", '{{ Session::get('bumdes_sess') }}', "success");
      @endif
       
     })

      var table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('bumdes-json') }}',
        columns: [
          { data: 'no', name: 'no'},
          { data: 'kecamatan', name: 'kecamatan' },
          { data: 'desa', name: 'desa' },
          { data: 'nama_bumdes', name: 'nama_bumdes' },
          { data: 'nama_direktur', name: 'nama_direktur' },
          { data: 'no_perdes', name: 'no_perdes' },
          { data: 'tahun', name: 'tahun' },
          { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
      });

    </script>
  </x-slot>

</x-app-layout>