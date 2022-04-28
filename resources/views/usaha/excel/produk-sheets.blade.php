<table>
  <thead>
    <tr>
      <th colspan="17">DINAS PEMBERDAYAAN MASYARAKAT DAN DESA</th>
    </tr>
    <tr>
      <th colspan="17">REKAP PEMETAAN USAHA EKONOMI MASYARAKAT PEDESAAN</th>
    </tr>
    <tr>
      <th colspan="17">
        @if(isset($desa))
        DESA {{ strtoupper($desa->nama_desa) }}
        @endif 
        KECAMATAN {{ strtoupper($kecamatan->nama_kecamatan) }}
      </th>
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