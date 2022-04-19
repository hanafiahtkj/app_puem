<table>
  <thead>
    <tr>
      <th colspan="10">BPMPD KABUPATEN TANAH LAUT</th>
    </tr>
    <tr>
      <th colspan="10">DATA PROFIL USAHA EKONOMI MASYARAKAT KECAMATAN {{ strtoupper($kecamatan->nama_kecamatan) }}</th>
    </tr>
  </thead>
</table>

<table>
  <thead>
    <tr>
      <th><b>No.</b></th>
      <th><b>Nama Pemilik Usaha</b></th>
      <th><b>Alamat Usaha</b></th>
      <th><b>Desa</b></th>
      <th><b>Kecamatan</b></th>
      <th><b>Nama Tempat Usaha</b></th>
      <th><b>Jenis Komoditas</b></th>
      <th><b>Produk yang dihasilkan</b></th>
      <th><b>Tahun Berdiri</b></th>
      <th><b>Jumlah TK</b></th>
    </tr>
  </thead>
  <tbody>
    @php
      $total = 0;
    @endphp
    @foreach ($data as $key => $value)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $value->nama_pemilik }}</td>
        <td>{{ $value->alamat_usaha }}</td>
        <td>{{ $value->nama_desa }}</td>
        <td>{{ $value->nama_kecamatan }}</td>
        <td>{{ $value->nama_usaha }}</td>
        <td>{{ $value->nama_sub_komoditas }}</td>
        <td>{{ $value->produk_dihasilkan }}</td>
        <td>{{ $value->tahun_berdiri }}</td>
        <td>{{ $value->jumlah_tenaga_kerja }}</td>
      </tr>
    @endforeach
  </tbody>
</table>