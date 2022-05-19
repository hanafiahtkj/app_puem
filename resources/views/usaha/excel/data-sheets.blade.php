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
    <tr>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>4</th>
      <th>5</th>
      <th>6</th>
      <th>7</th>
      <th>8</th>
      <th>9</th>
      <th>10</th>
      <th>11</th>
      <th>12</th>
      <th>13</th>
      <th>14</th>
      <th>15</th>
      <th>18</th>
    </tr>
  </thead>
  <tbody>
    @php
      $total = 0;
    @endphp
    @foreach ($data as $key => $value)
      <tr>
        <td align="center">{{ $loop->iteration+1 }}</td>
        <td>{{ $value->nama_pemilik }}</td>
        <td>{{ $value->nik }}</td>
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
        <td>Mikro</td>
        <td>Mikro</td>
        <td>{{ $value->nilai_investasi }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <td align="right" colspan="18">Pelaihari, {{ $tgl_sekarang }}</td>
    </tr>
    <tr>
      <td align="right" colspan="18">{{ $setting->mengetahui }}</td>
    </tr>
    <tr>
      <td align="right" colspan="18">Dinas PMD Kabupaten Tanah Laut,</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
      <td align="right" colspan="18"><b style="border-bottom: 1px solid #000;">{{ $setting->nama_pptk }}</b></td>
    </tr>
    <tr>
      <td align="right" colspan="18">NIP. {{ $setting->nip }}</td>
    </tr>
  </tbody>
</table>