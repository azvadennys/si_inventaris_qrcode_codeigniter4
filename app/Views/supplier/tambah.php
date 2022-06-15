<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Tambah Supplier</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('supplier'); ?>">Supplier</a></li>
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
  <?php echo form_open_multipart('supplier/add_supplier'); ?>
  <?php $validation = \Config\Services::validation() ?>

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Tambah Supplier</h3>
            <?php if ($flash) : ?>
              <span class="float-right text-success font-weight-bold" style="margin-top: -30px">
                <?php echo $flash; ?>
              </span>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label class="form-control-label" for="nama_toko">Nama Toko :</label>
              <input type="text" name="nama_toko" value="<?php echo set_value('nama_toko'); ?>" class="form-control" id="nama_toko">
              <? //php echo form_error('stock'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('nama_toko'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="nama_supplier">Nama Supplier:</label>
              <input type="text" name="nama_supplier" value="<?php echo set_value('nama_supplier'); ?>" class="form-control" id="nama_supplier">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('nama_supplier'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="kontak_supplier">Kontak :</label>
              <input type="text" name="kontak_supplier" value="<?php echo set_value('kontak_supplier'); ?>" class="form-control" id="kontak_supplier">
              <? //php echo form_error('stock'); 
              ?><div class="form-error text-danger font-weight-bold"> <?= $validation->getError('kontak_supplier'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="alamat">Alamat :</label>
              <input type="text" name="alamat" value="<?php echo set_value('alamat'); ?>" class="form-control" id="alamat">
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

  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>