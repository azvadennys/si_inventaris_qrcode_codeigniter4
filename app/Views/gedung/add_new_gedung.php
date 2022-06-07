<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Tambah Gedung</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('gedung'); ?>">Gedung</a></li>
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
  <?php echo form_open_multipart('gedung/add_gedung'); ?>
  <?php $validation = \Config\Services::validation() ?>
  <div class="row">
    <div class="col-md-8">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Data Gedung</h3>
            <?php if ($flash) : ?>
              <span class="float-right text-success font-weight-bold" style="margin-top: -30px">
                <?php echo $flash; ?>
              </span>
            <?php endif; ?>
          </div>

          <div class="card-body">
            <div class="form-group">
              <label class="form-control-label" for="nama_gedung">Nama gedung:</label>
              <input type="text" name="nama_gedung" value="<?php echo set_value('nama_gedung'); ?>" class="form-control" id="name">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('nama_gedung'); ?></div>
            </div>
            <input type="text" name="id_user" value="<?php echo session()->get('id_user') ?>" class="form-control" id="id_user" hidden>
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
          <input type="submit" value="Tambah Produk Baru" class="btn btn-primary">
        </div>
      </div>
    </div>
  </div>

  </form>
  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>