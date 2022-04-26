<table>
  <thead>
    <tr>
      <th colspan="16">DINAS PEMBERDAYAAN MASYARAKAT DAN DESA</th>
    </tr>
    <tr>
      <th colspan="16">REKAP PEMETAAN USAHA EKONOMI MASYARAKAT PEDESAAN</th>
    </tr>
    <tr>
      <th colspan="16">
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
    @foreach ($data as $key => $value)
      <tr>
        <td align="center">{{ $loop->iteration }}</td>
        <td>{{ $value->nama_produk }}</td>
        <td>:</td>
        <td>{{ $value->total }}</td>
        <td>UEM</td>
      </tr>
    @endforeach
  </tbody>
</table>