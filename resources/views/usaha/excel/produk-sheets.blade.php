<table>
  <thead>
    <tr>
      <th colspan="17">REKAP PEMETAAN USAHA EKONOMI MASYARAKAT</th>
    </tr>
    <tr>
      <th colspan="17">
        @if(isset($desa))
        DESA {{ strtoupper($desa->nama_desa) }}
        @endif 
        KECAMATAN {{ strtoupper($kecamatan->nama_kecamatan) }}
      </th>
    </tr>
    <tr>
      <th colspan="17">TAHUN {{ $tahun }}</th>
    </tr>
  </thead>
</table>

<table>
  <tbody>
    @php
      $total = 0;
    @endphp
    @for ($i = 0; $i < $size; $i++)
      <tr>
        @if(key_exists(0, $data))
          @if(key_exists($i, $data[0]))
            <td align="center">{{ $i+1 }}</td>
            <td>{{ $data[0][$i]->nama_produk }}</td>
            <td>:</td>
            <td>{{ $data[0][$i]->total }}</td>
            <td>UEM</td>
            <td></td>
          @endif
        @endif
        @if(key_exists('1', $data))
          @if(key_exists($i, $data[1]))
            <td align="center">{{ ($i+1)+count($data[0]) }}</td>
            <td>{{ $data[1][$i]->nama_produk }}</td>
            <td>:</td>
            <td>{{ $data[1][$i]->total }}</td>
            <td>UEM</td>
            <td></td>
          @endif
        @endif
        @if(key_exists('2', $data))
          @if(key_exists($i, $data[2]))
            <td align="center">{{ ($i+1)+count($data[0])+count($data[1]) }}</td>
            <td>{{ $data[2][$i]->nama_produk }}</td>
            <td>:</td>
            <td>{{ $data[2][$i]->total }}</td>
            <td>UEM</td>
            <td></td>
          @endif
        @endif
      </tr>
    @endfor
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <td align="right" colspan="17">Pelaihari, {{ $tgl_sekarang }}</td>
    </tr>
    <tr>
      <td align="right" colspan="17">{{ $setting->mengetahui }}</td>
    </tr>
    <tr>
      <td align="right" colspan="17">Dinas PMD Kabupaten Tanah Laut,</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
      <td align="right" colspan="17"><b style="border-bottom: 1px solid #000;">{{ $setting->nama_pptk }}</b></td>
    </tr>
    <tr>
      <td align="right" colspan="17">NIP. {{ $setting->nip }}</td>
    </tr>
  </tbody>
</table>