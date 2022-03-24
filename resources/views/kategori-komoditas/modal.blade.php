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
          <label for="title">Nama Kategori Komoditas</label>
          <input type="text" name="nama_kategori_komoditas" class="form-control" placeholder="Nama Kategori Komoditas..." required>
          <div class="invalid-feedback">Nama Kategori Komoditas wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Format Ekonomi Desa</label>
          <select class="form-control selectric" name="format_ekonomi_desa" required>
            <option value="">Pilih....</option>
            <option value="Format 1">Format 1</option>
            <option value="Format 2">Format 2</option>
            <option value="Format 3">Format 3</option>
          </select>
          <div class="invalid-feedback">Format Ekonomi Desa wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Alias</label>
          <input type="text" name="alias" class="form-control" placeholder="Alias..." required>
          <div class="invalid-feedback">Singkatan wajib diisi.</div>
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