<style>
  table {
    font-family: "Times New Roman", Times, serif;
  }
  #table-head {
    width: 100%;
  }
  #table-body {
    width: 100%;
    margin-top: 15px;
    margin-bottom: 15px;
  }
  #table-body, #table-body th, #table-body td {
    border: 1px solid #000;
    border-collapse: collapse;
    padding: .3rem;
  }
  #table-footer {
    width: 100%;
  }
  .bg-yellow {
    background: #dd5;
    color: #222;
  }
</style>

<table id="table-head">
  <thead>
    <tr>
      <th>BPMPD KABUPATEN TANAH LAUT</th>
    </tr>
    <tr>
      <th>DATA PROFIL USAHA EKONOMI MASYARAKAT KECAMATAN {{ strtoupper($kecamatan->nama_kecamatan) }}</th>
    </tr>
  </thead>
</table>

<table border="1" id="table-body">
  <thead>
    <tr class="bg-yellow">
      <th>No.</th>
      <th>Nama Pemilik Usaha</th>
      <th>Desa</th>
      <th>Kecamatan</th>
      <th>Nama Tempat Usaha</th>
      <th>Alamat Usaha</th>
      <th>Jenis Komoditas</th>
      <th>Produk yang dihasilkan</th>
      <th>Tahun Berdiri</th>
      <th>Jumlah TK</th>
    </tr>
  </thead>
  <tbody>
    @php
      $total = 0;
    @endphp
    @foreach ($data as $key => $value)
      <tr>
        <td align="center">{{ $loop->iteration }}</td>
        <td>{{ $value->nama_pemilik }}</td>
        <td>{{ $value->nama_desa }}</td>
        <td>{{ $value->nama_kecamatan }}</td>
        <td>{{ $value->nama_usaha }}</td>
        <td>{{ $value->alamat_usaha }}</td>
        <td>{{ $value->nama_sub_komoditas }}</td>
        <td>{{ $value->produk_dihasilkan }}</td>
        <td>{{ $value->tahun_berdiri }}</td>
        <td>{{ $value->jumlah_tenaga_kerja }}</td>
      </tr>
    @endforeach
  </tbody>
</table>