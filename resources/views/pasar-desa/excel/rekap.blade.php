<table>
  <thead>
    <tr>
      <th colspan="19">PEMERINTAH KABUPATEN TANAH LAUT</th>
    </tr>
    <tr>
      <th colspan="19">DINAS PEMBERDAYAAN MASYARAKAT DAN DESA</th>
    </tr>
    <tr>
      <th colspan="19">Jalan P. Antasari No. 2 Pelaihari  Telp. ( 0512 ) 21001 – 23001 Kode Pos 70815</th>
    </tr>
    <tr>
      <th colspan="19">PELAIHARI</th>
    </tr>
  </thead>
</table>

<table>
  <thead>
    <tr>
      <th colspan="19">DATA PASAR DESA</th>
    </tr>
    <tr>
      <th colspan="19">KECAMATAN {{ strtoupper($kecamatan->nama_kecamatan) }}
        @if(isset($desa))
        DESA {{ strtoupper($desa->nama_desa) }}
        @endif
      </th>
    </tr>
    <tr>
      <th colspan="19">TAHUN {{ date('Y') }}</th>
    </tr>
  </thead>
</table>

<table>
  <thead>
    <tr>
      <th><b>No.</b></th>
      <th><b>Desa</b></th>
      <th><b>Kecamatan</b></th>
      <th><b>Tahun Berdiri</b></th>
      <th><b>Jumlah Pasar</b></th>
      <th><b>Sejarah Perkembangan</b></th>
      {{-- <th><b>Instansi yang membina</b></th> --}}
      <th><b>Kegiatan Pasar dalam sebulan</b></th>
      <th><b>Status Lahan</b></th>
      <th><b>Status Pengelolaan</b></th>
      <th><b>Sumber Dana Pembangunan</b></th>
      <th><b>Kondisi Bangunan</b></th>
      <th><b>Kondisi Fisik Bangunan</b></th>
      <th><b>Perlu Adanya Perbaikan Fisik</b></th>
      <th><b>Pernah Menerima Bantuan dari</b></th>
      <th><b>Omzet Pasar Satu Kegiatan</b></th>
      <th><b>Jumlah Pelaku Usaha</b></th>
      <th><b>Asal Pelaku Usaha</b></th>
      <th><b>Dampak Sosial</b></th>
      <th><b>Keterangan</b></th>
    </tr>
  </thead>
  <tbody>
    @php
      $total = 0;
    @endphp
    @foreach ($data as $key => $value)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $value->nama_desa }}</td>
        <td>{{ $value->nama_kecamatan }}</td>
        <td>{{ $value->tahun_berdiri }}</td>
        <td>{{ $value->jumlah_pasar }}</td>
        <td>{{ $value->sejarah }}</td>
        {{-- <td></td> --}}
        <td>{{ $value->kegiatan_pasar }}</td>
        <td>{{ $value->status_lahan }}</td>
        <td>{{ $value->status_pengelolaan }}</td>
        <td>{{ $value->sumber_dana_pembangunan }}</td>
        <td>{{ $value->kondisi_bangunan }}</td>
        <td>{{ $value->kondisi_fisik_bangunan }}</td>
        <td>{{ $value->perlu_perbaikan }}</td>
        <td>{{ $value->bantuan_dari }}</td>
        <td>{{ $value->omzet }}</td>
        <td>{{ $value->jumlah_pelaku_usaha }}</td>
        <td>{{ $value->asal_pelaku_usaha }}</td>
        <td>{{ $value->dampak_sosial }}</td>
        <td>{{ $value->keterangan }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <td colspan="16"></td>
      <td align="center" colspan="3">Pelaihari, {{ $tgl_sekarang }}</td>
    </tr>
    <tr>
      <td colspan="16"></td>
      <td align="center" colspan="3">{{ $setting->mengetahui }}</td>
    </tr>
    <tr>
      <td colspan="16"></td>
      <td align="center" colspan="3">Dinas PMD Kabupaten Tanah Laut,</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
      <td colspan="16"></td>
      <td align="center" colspan="3"><b style="border-bottom: 1px solid #000;">{{ $setting->nama_pptk }}</b></td>
    </tr>
    <tr>
      <td colspan="16"></td>
      <td align="center" colspan="3">NIP. {{ $setting->nip }}</td>
    </tr>
  </tbody>
</table>