<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Tambah Ruangan</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('ruangan'); ?>">Ruangan</a></li>
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
  <?php echo form_open_multipart('ruangan/add_ruangan'); ?>
  <?php $validation = \Config\Services::validation() ?>
  <div class="row">
    <div class="col-md-8">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Data Ruangan</h3>
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
                  <label class="form-control-label" for="id_gedung">Nama Gedung :</label>
                  <select name="id_gedung" class="form-control" id="id_gedung">
                    <option>Pilih Gedung</option>
                    <?php if (count($gedungs) > 0) : ?>
                      <?php foreach ($gedungs as $gedung) : ?>
                        <option value="<?php echo $gedung->id_gedung; ?>" <?php echo set_select('id_gedung', $gedung->id_gedung); ?>><?php echo $gedung->nama_gedung; ?></option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                  <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('id_gedung'); ?></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="nama_ruangan">Nama Ruangan :</label>
              <input type="text" name="nama_ruangan" value="<?php echo set_value('nama_ruangan'); ?>" class="form-control" id="nama_ruangan">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('nama_ruangan'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="kapasitas_ruangan">Kapasitas Ruangan :</label>
              <input type="number" name="kapasitas_ruangan" value="<?php echo set_value('kapasitas_ruangan'); ?>" class="form-control" id="kapasitas_ruangan">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('kapasitas_ruangan'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="terisi_ruangan">Terisi :</label>
              <input type="number" name="terisi_ruangan" value="<?php echo set_value('terisi_ruangan'); ?>" class="form-control" id="terisi_ruangan">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('terisi_ruangan'); ?></div>
              <?php if ($flash_error) : ?>
                <div class="form-error text-danger font-weight-bold">
                  <?php echo $flash_error; ?>
                </div>
              <?php endif; ?>
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
          <input type="submit" value="Tambah Ruangan Baru" class="btn btn-primary">
        </div>
      </div>
    </div>
  </div>

  </form>
  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>