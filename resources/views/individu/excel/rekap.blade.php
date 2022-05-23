<table>
  <thead>
    <tr>
      <th colspan="10">PEMERINTAH KABUPATEN TANAH LAUT</th>
    </tr>
    <tr>
      <th colspan="10">DINAS PEMBERDAYAAN MASYARAKAT DAN DESA</th>
    </tr>
    <tr>
      <th colspan="10">Jalan P. Antasari No. 2 Pelaihari  Telp. ( 0512 ) 21001 – 23001 Kode Pos 70815</th>
    </tr>
    <tr>
      <th colspan="10">PELAIHARI</th>
    </tr>
  </thead>
</table>

<table>
  <thead>
    <tr>
      <th colspan="10">DATA PROFIL INDIVIDU USAHA EKONOMI MASYARAKAT</th>
    </tr>
    <tr>
      <th colspan="10">KECAMATAN {{ strtoupper($kecamatan->nama_kecamatan) }}
        @if(isset($desa))
        DESA {{ strtoupper($desa->nama_desa) }}
        @endif
      </th>
    </tr>
    <tr>
      <th colspan="10">TAHUN {{ date('Y') }}</th>
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

<table>
  <tbody>
    <tr>
      <td colspan="7"></td>
      <td align="center" colspan="3">Pelaihari, {{ $tgl_sekarang }}</td>
    </tr>
    <tr>
      <td colspan="7"></td>
      <td align="center" colspan="3">{{ $setting->mengetahui }}</td>
    </tr>
    <tr>
      <td colspan="7"></td>
      <td align="center" colspan="3">Dinas PMD Kabupaten Tanah Laut,</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
      <td colspan="7"></td>
      <td align="center" colspan="3"><b style="border-bottom: 1px solid #000;">{{ $setting->nama_pptk }}</b></td>
    </tr>
    <tr>
      <td colspan="7"></td>
      <td align="center" colspan="3">NIP. {{ $setting->nip }}</td>
    </tr>
  </tbody>
</table>