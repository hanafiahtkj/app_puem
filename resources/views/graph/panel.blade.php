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
        <h1>GRAFIK UEM</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Grafik</div>
        </div>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="m-0 p-4">
                  <div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Kecamatan</label>
                        <select class="form-control" name="id_kecamatan" id="kecamatan" onchange="getDesaByIdKecamatan()" required>
                          <option value="">Pilih Kecamatan</option>
                          @foreach ($kecamatan as $item)
                            <option value="{{$item->id}}">{{$item->nama_kecamatan}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Desa</label>
                        <select class="form-control" name="id_desa" id="desa" required disabled>
                          <option value="">Pilih Desa</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Grafik</label>
                        <select class="form-control" name="id_kecamatan" id="graph_type" required>
                          <option value="">Pilih Grafik</option>
                          <option value="1">Donat</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Jenis Data</label>
                        <select class="form-control" name="id_kecamatan" id="jenis_data" required>
                          <option value="">Pilih Jenis Data</option>
                          <option value="1">Jumlah Usaha</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Tahun Data</label>
                        <select class="form-control" name="id_kecamatan" id="tahun" required>
                          <option value="">Pilih Tahun</option>
                          @for ($i = 2019; $i <= date('Y'); $i++)
                            <option value="{{$i}}">{{$i}}</option>
                          @endfor
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label"> &nbsp;</label>
                        <input type="button" class="form-control btn btn-md btn-primary" value="Tampilkan" name="" id="tampilkan" onclick="showGraph()">
                        <input type="button" class="form-control btn btn-md btn-danger" value="Reset" name="" id="hilangkan" style="display: none;" onClick="reset_input()">
                        
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <canvas id="myChart" width="400" height="400"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/chartjs-plugin-datalabels.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-colorpicker-3.2.0/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script>

      async function show_graph(id_kec, id_desa, tahun, graph_type, jenis_data) {

        var label_data = []
        var datasets_data = []
        var datasets_backgroundColor = []
        var total_center = 0
    
        const formData = new FormData();
        formData.append('kec', id_kec);
        formData.append('des', id_desa);
        formData.append('tahun', tahun);

        await fetch('{{ route("graph-json") }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: formData
          })
          .then((res) => {
            return res.json()
          })
          .then((res) => {
               
            for (const iterator of res.data) {
              
              label_data.push(iterator.nama_produk);
              datasets_data.push(iterator.total_produk);
              datasets_backgroundColor.push(iterator.random_color);
              total_center += iterator.total_produk

            }           

          })
          .catch((err) => {
            
            swal('Ooops..', 'Data tidak ditemukan', 'error')

          })

          let donutData = {
              labels: label_data,
              datasets: [
                {
                  data: datasets_data,
                  backgroundColor : datasets_backgroundColor,
                }
              ]
            }

            let options = {
                maintainAspectRatio : false,
                responsive : true,
                tooltips: {
                    enabled: false
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {

                            let sum = 0;
                            let dataArr = ctx
                                .chart
                                .data
                                .datasets[0]
                                .data;
                            dataArr.map(data => {
                                sum += data;
                            });

                            let percentage = (value * 100 / sum).toFixed(2) + "%" + " (" + value + ") ";
                            return percentage;

                        },
                        
                        color: '#fff'
                    }
                }
            };

            const ctx = document.getElementById("myChart").getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'doughnut',
                data: donutData,
                options: options,
                plugins: [{
                  id: 'text',
                  beforeDraw: function(chart, a, b) {
                    var width = chart.width,
                      height = chart.height,
                      ctx = chart.ctx;

                    ctx.restore();
                    var fontSize = 2;
                    ctx.font = fontSize + "em sans-serif";

                    var text = "100% (" + total_center + ")",
                      textX = Math.round((width - ctx.measureText(text).width) / 2),
                      textY = height / 2;

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                  }
                }]
            });
              
      }

      function reset_input() {
        $('#kecamatan').val('');
        $('#desa').val('');
        $('#tahun').val('');
        $('#jenis_data').val('');
        $('#grafik').val('');
        $('#hilangkan').hide();
        $('#tampilkan').show();
        $('#myChart').show();
      }

      function showGraph() {

        if ($('#kecamatan').val() == ""  || $('#desa').val() == "" || $('#tahun').val() == "" || $('#graph_type').val() == "" || $('#jenis_data').val() == "") {

          swal({
            title: "Pilih Data",
            text: "Pilih Data Terlebih Dahulu",
            icon: "warning",
            button: "OK",
          });

        }else{

          this.show_graph($('#kecamatan').val(), $('#desa').val(), $('#tahun').val(), $('#graph_type').val(), $('#jenis_data').val());
          $('#hilangkan').show();
          $('#tampilkan').hide();

        }
        

      }
      

      function getDesaByIdKecamatan() {

      const kecamatanId = $('#kecamatan').val()

      if (kecamatanId == "" || kecamatanId == null) {
        $('#desa').empty();
        $('#desa').prop('disabled', true);
        return
      }

      $('#desa').empty();
      $('#desa').html('<option value="">Sedang Mengambil data...</option>');

      const formData = new FormData();
      formData.append('id_kecamatan', kecamatanId);

      fetch("/api/getdesabyidkecamatan", {
                headers: {
                    "X-CSRF-Token": $('input[name="_token"]').val()
                },
                method: "POST",
                credentials: "same-origin",
                body: formData
        })
        .then((res) => {
          return res.json()
        })
        .then((res) => {

          $('#desa').empty();
          $('#desa').prop('disabled', false);
          $('#desa').append('<option value="">Pilih Desa</option>');
          
          for (const iterator of res.data) {
            
            $('#desa').append(`<option value="${iterator.id}">${iterator.nama_desa}</option>`);

          }

        })
        .catch((err) => {
          console.log(err);
        })
      }

   

    </script>
  </x-slot>

</x-app-layout>