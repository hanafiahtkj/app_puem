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
          <label for="title">Kategori Komoditas</label>
          <select id="id_kategori_komoditas" onChange="getKomoditas(this.value);" class="form-control selectric" name="id_kategori_komoditas" required>
            <option value="">Pilih....</option>
            @foreach($kategori_komoditas as $value)
              <option value="{{ $value->id }}">{{ $value->nama_kategori_komoditas }}</option>
            @endforeach
          </select>
          <div class="invalid-feedback">Kategori Komoditas wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Komoditas</label>
          <select id="id_komoditas" onChange="getSubKomoditas(this.value);" class="form-control selectric" name="id_komoditas" required>
            <option value="">Pilih....</option>
          </select>
          <div class="invalid-feedback">Komoditas wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Sub Komoditas</label>
          <select id="id_sub_komoditas" class="form-control selectric" name="id_sub_komoditas" required>
            <option value="">Pilih....</option>
          </select>
          <div class="invalid-feedback">Sub Komoditas wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Nama Produk</label>
          <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk..." required>
          <div class="invalid-feedback">Nama Produk wajib diisi.</div>
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