<?php 
function skala_usaha($omzet) {
  $total = $omzet * 365;
  // mikro : <= 300 jt
  // kecil : >300 jt & <2,5 milyar
  // menengah : >=2,5 milyar & <50 milyar
  switch ($total) {
      case $total <= 300000000:
          return 'Mikro';
          break;
      case $total > 300000000 && $total < 2500000000:
          return 'Kecil';
          break;
      case $total >= 2500000000 && $total < 50000000000:
          return 'Menengah';
          break;
      default:
          return '-';
          break;
  }
  return $total;
}

function skala_asset($asset) {
  $total = $asset;
  // mikro : <= 300 jt
  // kecil : >300 jt & <2,5 milyar
  // menengah : >=2,5 milyar & <50 milyar
  switch ($total) {
      case $total <= 300000000:
          return 'Mikro';
          break;
      case $total > 300000000 && $total < 2500000000:
          return 'Kecil';
          break;
      case $total >= 2500000000 && $total < 50000000000:
          return 'Menengah';
          break;
      default:
          return '-';
          break;
  }
  return $total;
}
?>

<table>
  <thead>
    <tr>
      <th colspan="18">PEMERINTAH KABUPATEN TANAH LAUT</th>
    </tr>
    <tr>
      <th colspan="18">DINAS PEMBERDAYAAN MASYARAKAT DAN DESA</th>
    </tr>
    <tr>
      <th colspan="18">Jalan P. Antasari No. 2 Pelaihari  Telp. ( 0512 ) 21801 – 23001 Kode Pos 70815</th>
    </tr>
    <tr>
      <th colspan="18">PELAIHARI</th>
    </tr>
  </thead>
</table>

<table>
  <thead>
    <tr>
      <th colspan="18">REKAP PEMETAAN USAHA EKONOMI MASYARAKAT</th>
    </tr>
    <tr>
      <th colspan="18">
        @if(isset($desa))
        DESA {{ strtoupper($desa->nama_desa) }}
        @endif 
        KECAMATAN {{ strtoupper($kecamatan->nama_kecamatan) }}
      </th>
    </tr>
    <tr>
      <th colspan="18">TAHUN {{ $tahun }}</th>
    </tr>
  </thead>
</table>

<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama Pemilik Usaha</th>
      <th>NIK</th>
      <th>Jenis Kelamin</th>
      <th>Pendidikan Tertinggi</th>
      <th>Alamat Tempat Usaha</th>
      <th>Nama Tempat Usaha</th>
      <th>Jenis Komoditas</th>
      <th>Jenis Sub Komoditas</th>
      <th>Produk/Jenis Profesi</th>
      <th>Tahun Berdiri</th>
      <th>Jumlah Tenaga Kerja</th>
      <th>Harga Jual/Jasa Perunit</th>
      <th>Banyak Hari Kerja</th>
      <th>Omset Per Hari</th>
      <th>Skala Usaha</th>
      <th>Skala Asset</th>
      <th>Nilai Investasi</th>
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
        <td>{{ '\''.$value->nik }}</td>
        <td>{{ $value->jenis_kelamin }}</td>
        <td>{{ $value->nama_pendidikan }}</td>
        <td>{{ $value->alamat_usaha }}</td>
        <td>{{ $value->nama_usaha }}</td>
        <td>{{ $value->nama_komoditas }}</td>
        <td>{{ $value->nama_sub_komoditas }}</td>
        <td>{{ $value->nama_produk }}</td>
        <td>{{ $value->tahun_berdiri }}</td>
        <td>{{ $value->jumlah_tenaga_kerja }}</td>
        <td>{{ $value->harga_jual_produk }}</td>
        <td>{{ $value->hari_kerja_sebulan }}</td>
        <td>Rp. {{ number_format($value->omzet_perhari, 0, '.', ',') }}</td>
        <td>{{ skala_usaha($value->omzet_perhari) }}</td>
        <td>{{ skala_asset($value->nilai_asset) }}</td>
        <td>{{ $value->nilai_investasi }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <td colspan="15"></td>
      <td align="center" colspan="3">Pelaihari, {{ $tgl_sekarang }}</td>
    </tr>
    <tr>
      <td colspan="15"></td>
      <td align="center" colspan="3">{{ $setting->mengetahui }}</td>
    </tr>
    <tr>
      <td colspan="15"></td>
      <td align="center" colspan="3">Dinas PMD Kabupaten Tanah Laut,</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
      <td colspan="15"></td>
      <td align="center" colspan="3"><b style="border-bottom: 1px solid #000;">{{ $setting->nama_pptk }}</b></td>
    </tr>
    <tr>
      <td colspan="15"></td>
      <td align="center" colspan="3">NIP. {{ $setting->nip }}</td>
    </tr>
  </tbody>
</table>