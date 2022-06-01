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
        <th colspan="10">REKAP DATA BUMDES {{ strtoupper($kecamatan) }}</th>
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
        <th><b>Kecamatan</b></th>
        <th><b>Desa</b></th>
        <th><b>Bumdes</b></th>
        <th><b>Direktur</b></th>
        <th><b>No Perdes</b></th>
        <th><b>Tahun</b></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $key => $value)
        <tr>
          <td>{{ $value['no'] }}</td>
          <td>{{ $value['kecamatan'] }}</td>
          <td>{{ $value['desa'] }}</td>
          <td>{{ $value['nama_bumdes'] }}</td>
          <td>{{ $value['nama_direktur'] }}</td>
          <td>{{ $value['no_perdes'] }}</td>
          <td>{{ $value['tahun'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  
  <table>
    <tbody>
      <tr>
        <td colspan="6"></td>
        <td align="center" colspan="3">Pelaihari, {{ $tgl_sekarang }}</td>
      </tr>
      <tr>
        <td colspan="6"></td>
        <td align="center" colspan="3">{{ $setting->mengetahui }}</td>
      </tr>
      <tr>
        <td colspan="6"></td>
        <td align="center" colspan="3">Dinas PMD Kabupaten Tanah Laut,</td>
      </tr>
      <tr></tr>
      <tr></tr>
      <tr></tr>
      <tr>
        <td colspan="6"></td>
        <td align="center" colspan="3"><b style="border-bottom: 1px solid #000;">{{ $setting->nama_pptk }}</b></td>
      </tr>
      <tr>
        <td colspan="6"></td>
        <td align="center" colspan="3">NIP. {{ $setting->nip }}</td>
      </tr>
    </tbody>
  </table>