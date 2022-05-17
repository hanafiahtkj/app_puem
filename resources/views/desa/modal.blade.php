<form id="formWrapperModal" method="POST" action="" class="needs-validation" novalidate>
@method('PATCH')
<div class="modal fade" id="formModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="formModalLabel">Tambah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="title">Kecamatan</label>
          <select id="id_kecamatan" class="form-control selectric" name="id_kecamatan" required>
            <option value="">Pilih....</option>
            @foreach($kecamatan as $value)
              <option value="{{ $value->id }}">{{ $value->nama_kecamatan }}</option>
            @endforeach
          </select>
          <div class="invalid-feedback">Kecamatan wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Nama Desa</label>
          <input type="text" name="nama_desa" class="form-control" placeholder="Nama Desa..." required>
          <div class="invalid-feedback">Nama Desa wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Status</label>
          <select id="status" class="form-control selectric" name="status" required>
            <option value="">Pilih....</option>
            <option value="Desa">Desa</option>
            <option value="Kelurahan">Kelurahan</option>
          </select>
          <div class="invalid-feedback">Kategori Komoditas wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Geojson</label>
          <input type="file" class="form-control" name="geojson">
          <div class="invalid-feedback">Geojson wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Warna</label>
          <input type="text" name="warna" class="form-control colorpickerinput colorpicker-element" data-colorpicker-id="1">
          <div class="invalid-feedback">Warna wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Garis</label>
          <input type="text" name="garis" class="form-control colorpickerinput colorpicker-element" data-colorpicker-id="2">
          <div class="invalid-feedback">Garis Produk wajib diisi.</div>
        </div>
      </div>
      <div class="modal-footer border-top-0 d-flex">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" id="btn-store" class="btn btn-dark">Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>