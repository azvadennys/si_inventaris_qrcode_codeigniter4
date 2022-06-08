<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Tambah Barang</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('barang'); ?>">Barang</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
  <?php echo form_open_multipart('barang/add_barang'); ?>
  <?php $validation = \Config\Services::validation() ?>
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
            <div class="form-group">
              <label class="form-control-label" for="id_ruangan">Ruangan :</label>
              <select name="id_ruangan" class="form-control" id="id_ruangan">
                <option>Pilih Ruangan</option>
                <?php if (count($ruangans) > 0) : ?>
                  <?php foreach ($ruangans as $ruangan) : ?>
                    <option value="<?php echo $ruangan->id_ruangan; ?>" <?php echo set_select('id_ruangan', $ruangan->id_ruangan); ?>>› <?php echo $ruangan->nama_ruangan; ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('id_ruangan'); ?></div>
              <? //php echo form_error('category_id'); 
              ?>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="nama_barang">Nama Barang :</label>
              <input type="text" name="nama_barang" value="<?php echo set_value('nama_barang'); ?>" class="form-control" id="nama_barang">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('nama_barang'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="stock">Tahun :</label>
              <input type="text" name="tahun" value="<?php echo set_value('tahun'); ?>" class="form-control" id="tahun">
              <? //php echo form_error('stock'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('tahun'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="unit">Jumlah :</label>
              <input type="number" name="jumlah" value="<?php echo set_value('jumlah'); ?>" class="form-control" id="jumlah">
              <? //php echo form_error('unit'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('jumlah'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="merek">Merek :</label>
              <input type="text" name="merek" value="<?php echo set_value('merek'); ?>" class="form-control" id="merek">
              <? //php echo form_error('stock'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('merek'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="jenis">Jenis :</label>
              <input type="text" name="jenis" value="<?php echo set_value('jenis'); ?>" class="form-control" id="jenis">
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
          <h3 class="mb-0">Foto</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-control-label" for="pic">Foto:</label>
            <input type="file" name="picture" class="form-control" id="pic">
            <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 2MB</small>
            <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('picture'); ?></div>
          </div>
        </div>
        <div class="card-footer text-right">
          <input type="submit" value="Tambah Barang Baru" class="btn btn-primary">
        </div>
      </div>
    </div>
  </div>

  </form>
  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>