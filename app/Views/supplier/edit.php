<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Edit Supplier</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('supplier'); ?>">Supplier</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('supplier/view/' . $supplier->id_supplier); ?>"><?php echo $supplier->nama_supplier; ?></a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
  <?php echo form_open_multipart('supplier/edit_supplier'); ?>
  <?php $validation = \Config\Services::validation() ?>
  <input type="hidden" name="id" value="<?php echo $supplier->id_supplier; ?>">

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Data Supplier</h3>
            <?php if ($flash) : ?>
              <span class="float-right text-success font-weight-bold" style="margin-top: -30px">
                <?php echo $flash; ?>
              </span>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label class="form-control-label" for="nama_toko">Nama Toko :</label>
              <input type="text" name="nama_toko" value="<?php echo set_value('nama_toko', $supplier->nama_toko); ?>" class="form-control" id="nama_toko">
              <? //php echo form_error('stock'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('nama_toko'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="nama_supplier">Nama Supplier:</label>
              <input type="text" name="nama_supplier" value="<?php echo set_value('nama_supplier', $supplier->nama_supplier); ?>" class="form-control" id="nama_supplier">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('nama_supplier'); ?></div>
              <input type="text" name="id_user" value="<?php echo session()->get('id_user') ?>" class="form-control" id="id_user" hidden>
              <input type="text" name="id" value="<?php echo $supplier->id_supplier ?>" class="form-control" id="id" hidden>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="kontak_supplier">Kontak :</label>
              <input type="text" name="kontak_supplier" value="<?php echo set_value('kontak_supplier', $supplier->kontak_supplier); ?>" class="form-control" id="kontak_supplier">
              <? //php echo form_error('stock'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('kontak_supplier'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="alamat">Alamat :</label>
              <input type="text" name="alamat" value="<?php echo set_value('alamat', $supplier->alamat); ?>" class="form-control" id="alamat">
              <? //php echo form_error('stock'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('alamat'); ?></div>
            </div>
          </div>
          <div class="card-footer text-right">
            <input type="submit" value="Simpan" class="btn btn-primary">
          </div>
        </div>
      </div>
    </div>
  </div>

  </form>

  <script>
    $('.deletePictureBtn').click(function(e) {
      e.preventDefault();

      $(this).html('<i class="fa fa-spin fa-spinner"></i> Menghapus...');

      $.ajax({
        method: 'POST',
        url: '<?php echo base_url('supplier/product_api?action=delete_image'); ?>',
        data: {
          id: <?php echo $supplier->id_supplier; ?>
        },
        context: this,
        success: function(res) {
          if (res.code == 204) {
            $('.deleteText').text('Gambar berhasil dihapus. Produk ini akan menggunakan gambar default jika tidak ada gambar baru yang diunggah');
            $(this).html('<i class="fa fa-check"></i> Terhapus!');

            setTimeout(function() {
              $('.newUploadText').text('Pilih gambar baru untuk mengganti gambar yang dihapus');
              $('#pills-delete, #pills-delete-tab, #pills-current, #pills-current-tab').hide('fade');
              $('#pills-edit').tab('show');
              $('#pills-edit-tab').addClass('active').text('Upload baru');
            }, 3000);
          } else {
            console.log('Terdapat kesalahan');
          }
        }
      })
    });
  </script>
  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>