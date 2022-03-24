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
          <label for="title">Nama Instansi Pembina</label>
          <input type="text" name="nama_instansi_pembina" class="form-control" placeholder="Nama Instansi Pembina..." required>
          <div class="invalid-feedback">Nama Instansi Pembina wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Singkatan</label>
          <input type="text" name="singkatan" class="form-control" placeholder="Singkatan..." required>
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