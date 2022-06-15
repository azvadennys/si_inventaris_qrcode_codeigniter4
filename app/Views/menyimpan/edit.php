<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Edit Penyimpanan</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('penyimpanan'); ?>">Penyimpanan</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('penyimpanan/view/' . $penyimpanan->id_simpan); ?>"><?php echo $penyimpanan->id_simpan; ?></a></li>
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
  <?php echo form_open_multipart('penyimpanan/edit_simpan'); ?>
  <?php $validation = \Config\Services::validation() ?>
  <input type="hidden" name="id" value="<?php echo $penyimpanan->id_simpan; ?>">

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Data Penyimpanan</h3>
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
                    <option value="<?= $penyimpanan->id_ruangan ?>"><?= $penyimpanan->nama_ruangan ?></option>
                    <option>===========</option>
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
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="id_barang">Nama Barang :</label>
                  <select name="id_barang" class="form-control" id="id_barang">
                    <option value="<?= $penyimpanan->id_barang ?>"><?= $penyimpanan->nama_barang ?></option>
                    <option>===========</option>
                    <?php if (count($barangs) > 0) : ?>
                      <?php foreach ($barangs as $barang) : ?>
                        <option value="<?php echo $barang->id_barang; ?>" <?php echo set_select('id_barang', $barang->id_barang); ?>><?php echo $barang->nama_barang; ?></option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                  <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('id_barang'); ?></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="barang_bagus">Jumlah Barang Bagus:</label>
              <input type="number" name="barang_bagus" value="<?php echo (set_value('barang_bagus') == NULL) ? $penyimpanan->barang_bagus : set_value('barang_bagus'); ?>" class="form-control" id="barang_bagus">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('barang_bagus'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="barang_rusak">Jumlah Barang Rusak:</label>
              <input type="number" name="barang_rusak" value="<?php echo (set_value('barang_rusak') == NULL) ? $penyimpanan->barang_rusak : set_value('barang_rusak'); ?>" class="form-control" id="barang_rusak">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('barang_rusak'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="tgl_simpan">Tanggal Simpan:</label>
              <input type="date" name="tgl_simpan" value="<?php echo (set_value('tgl_simpan') == NULL) ? $penyimpanan->tgl_simpan : set_value('tgl_simpan'); ?>" class="form-control" id="tgl_simpan">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('tgl_simpan'); ?></div>
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