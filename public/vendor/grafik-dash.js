async function show_graph(id_kec, id_desa, tahun, graph_type, jenis_data) {

    var label_data = []
    var datasets_data = []
    var datasets_backgroundColor = []
    var total_center = 0

    const formData = new FormData();
    formData.append('kec', id_kec);
    formData.append('des', id_desa);
    formData.append('tahun', tahun);
    formData.append('jenis_data', jenis_data);

    if (jenis_data == 'jumlah_usaha') {

      await fetch('/api/graph-json', {
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
        $('#loading-graph').remove();
        $('#myChart').remove();
        $('#graph-container').append('<canvas id="myChart" width="400" height="400"></canvas>');

        const ctx = document.getElementById("myChart").getContext('2d');

        let donutData = {
          labels: label_data,
          datasets: [
            {
              data: datasets_data,
              backgroundColor : datasets_backgroundColor,
            }
          ]
        }
           
        for (const iterator of res.data) {
          
          label_data.push(iterator.nama_produk);
          datasets_data.push(iterator.total_produk);
          datasets_backgroundColor.push(iterator.random_color);
          total_center += iterator.total_produk

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

        const myChart = new Chart(ctx, {
            type: graph_type,
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

      })
      .catch((err) => {
        console.log(err);
        swal('Ooops..', 'Data tidak ditemukan', 'error')

      })
                
    }
    else if (jenis_data == 'skala_usaha') {

      await fetch('/api/graph-json', {
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

        $('#myChart').remove();
        $('#graph-container').append('<canvas id="myChart" width="400" height="400"></canvas>');

        const ctx = document.getElementById("myChart").getContext('2d');

        let donutData = {
          labels: [Object.keys(res.data)[0], Object.keys(res.data)[1], Object.keys(res.data)[2] ],
          datasets: [
            {
              data: [Object.values(res.data)[0], Object.values(res.data)[1], Object.values(res.data)[2] ],
              backgroundColor : ['#FF0000', '#00FF00', '#0000FF'],
            }
          ]
        }

       
        // console.log(Object.keys(res.data)[0]);

        // for (let index = 0; index < res.data.length; index++) {
          
        //   label_data.push(Object.keys(res.data[index]));
        //   datasets_data.push(Object.values(res.data[index]));
        //   datasets_backgroundColor.push(res.data[index].random_color);
          
        // }
           
        // for (const iterator of res.data) {
          
        //   label_data.push(Object.keys(iterator));
        //   datasets_data.push(Object.values(iterator));
        //   datasets_backgroundColor.push(iterator.random_color);
        //   total_center += iterator

        // }

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

        const myChart = new Chart(ctx, {
            type: graph_type,
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

                var text = "100% (" + res.data.total + ")",
                  textX = Math.round((width - ctx.measureText(text).width) / 2),
                  textY = height / 2;

                ctx.fillText(text, textX, textY);
                ctx.save();
              }
            }]
        });

      })
      .catch((err) => {
        console.log(err);
        swal('Ooops..', 'Data tidak ditemukan', 'error')

      })
      
    }
      
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
