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
          <label for="title">Nama Kecamatan</label>
          <input type="text" name="nama_kecamatan" class="form-control" placeholder="Nama Kecamatan..." required>
          <div class="invalid-feedback">Nama Kecamatan wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Kouta</label>
          <input type="text" name="kouta" class="form-control" placeholder="Kouta..." required>
          <div class="invalid-feedback">Kouta wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Geojson</label>
          <input type="file" class="form-control" name="geojson">
          <div class="invalid-feedback">Geojson wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Warna</label>
          <input type="text" name="warna" class="form-control colorpickerinput colorpicker-element" data-colorpicker-id="1" required>
          <div class="invalid-feedback">Warna wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Garis</label>
          <input type="text" name="garis" class="form-control colorpickerinput colorpicker-element" data-colorpicker-id="2" required>
          <div class="invalid-feedback">Garis Produk wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Latitude</label>
          <input type="text" name="latitude" class="form-control" placeholder="Latitude..." required>
          <div class="invalid-feedback">Latitude wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Langtitude</label>
          <input type="text" name="langtitude" class="form-control" placeholder="Langtitude..." required>
          <div class="invalid-feedback">Langtitude wajib diisi.</div>
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