<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Edit Barang</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('barang'); ?>">Barang</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('barang/view/' . $barang->id_barang); ?>"><?php echo $barang->nama_barang; ?></a></li>
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
  <?php echo form_open_multipart('barang/edit_barang'); ?>
  <?php $validation = \Config\Services::validation() ?>
  <input type="hidden" name="id" value="<?php echo $barang->id_barang; ?>">

  <div class="row">
    <div class="col-md-8">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Data Barang</h3>
            <?php if ($flash) : ?>
              <span class="float-right text-success font-weight-bold" style="margin-top: -30px">
                <?php echo $flash; ?>
              </span>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="id_ruangan">Nama Ruangan :</label>
                  <select name="id_ruangan" class="form-control" id="id_ruangan">
                    <option>Pilih Ruangan</option>
                    <?php if (count($ruangans) > 0) : ?>
                      <?php foreach ($ruangans as $ruangan) : ?>
                        <option value="<?php echo $ruangan->id_ruangan; ?>" <?php echo set_select('id_ruangan', $ruangan->id_ruangan); ?>><?php echo $ruangan->nama_ruangan; ?></option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                  <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('id_ruangan'); ?></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="nama_barang">Nama Barang:</label>
              <input type="text" name="nama_barang" value="<?php echo set_value('nama_barang', $barang->nama_barang); ?>" class="form-control" id="nama_barang">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('nama_barang'); ?></div>
              <input type="text" name="id_user" value="<?php echo session()->get('id_user') ?>" class="form-control" id="id_user" hidden>
              <input type="text" name="id" value="<?php echo $barang->id_barang ?>" class="form-control" id="id" hidden>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="stock">Tahun :</label>
              <input type="text" name="tahun" value="<?php echo set_value('tahun', $barang->tahun); ?>" class="form-control" id="tahun">
              <? //php echo form_error('stock'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('tahun'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="unit">Jumlah :</label>
              <input type="number" name="jumlah" value="<?php echo set_value('jumlah', $barang->jumlah); ?>" class="form-control" id="jumlah">
              <? //php echo form_error('unit'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('jumlah'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="merek">Merek :</label>
              <input type="text" name="merek" value="<?php echo set_value('merek', $barang->merek); ?>" class="form-control" id="merek">
              <? //php echo form_error('stock'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('merek'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="jenis">Jenis :</label>
              <input type="text" name="jenis" value="<?php echo set_value('jenis', $barang->jenis); ?>" class="form-control" id="jenis">
              <? //php echo form_error('unit'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('jenis'); ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-4">
              <h3 class="mb-0">Foto</h3>
            </div>
            <?php if ($barang->foto) : ?>
              <div class="col-8">
                <ul class="nav nav-pills mb-3 float-right" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link p-1 active" id="pills-current-tab" data-toggle="pill" href="#pills-current" role="tab" aria-controls="pills-home" aria-selected="true">Current</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link p-1" id="pills-edit-tab" data-toggle="pill" href="#pills-edit" role="tab" aria-controls="pills-profile" aria-selected="false">Ganti</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link p-1" id="pills-delete-tab" data-toggle="pill" href="#pills-delete" role="tab" aria-controls="pills-contact" aria-selected="false">Hapus</a>
                  </li>
                </ul>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="card-body">
          <?php if ($barang->foto != NULL) : ?>
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-current" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="text-center">
                  <img alt="<?php echo $barang->nama_barang; ?>" src="<?php echo base_url('assets/uploads/barang/' . $barang->foto); ?>" class="img img-fluid rounded">
                </div>
              </div>
              <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="form-group">
                  <label class="form-control-label" for="pic">Foto:</label>
                  <input type="file" name="picture" class="form-control" id="picture">
                  <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('picture'); ?></div>
                  <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 2MB</small>
                  <small class="newUploadText">Unggah file baru untuk mengganti foto saat ini.</small>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-delete" role="tabpanel" aria-labelledby="pills-contact-tab">
                <p class="deleteText">Klik link dibawah untuk menghapus foto. Tindakan ini tidak dapat dibatalkan.</p>
                <div class="text-right">
                  <a href="#" class="deletePictureBtn btn btn-danger">Hapus</a>
                </div>
              </div>
            </div>
          <?php else : ?>
            <div class="form-group">
              <label class="form-control-label" for="picture">Foto:</label>
              <input type="file" name="picture" class="form-control" id="picture">
              <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 2MB</small>
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('picture'); ?></div>
            </div>
          <?php endif; ?>
        </div>
        <div class="card-footer text-right">
          <input type="submit" value="Simpan" class="btn btn-primary">
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
        url: '<?php echo base_url('barang/product_api?action=delete_image'); ?>',
        data: {
          id: <?php echo $barang->id_barang; ?>
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