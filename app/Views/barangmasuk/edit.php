<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Edit Barang Masuk</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('barangmasuk'); ?>">Barang Masuk</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('barangmasuk/view/' . $masuk->id_pengadaan); ?>"><?php echo $masuk->id_pengadaan; ?></a></li>
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
  <?php echo form_open_multipart('barangmasuk/edit_simpan'); ?>
  <?php $validation = \Config\Services::validation() ?>
  <input type="hidden" name="id" value="<?php echo $masuk->id_pengadaan; ?>">

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Data Barang Masuk</h3>
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
                  <label class="form-control-label" for="id_supplier">Nama Supplier :</label>
                  <select name="id_supplier" class="form-control" id="id_supplier">
                    <option value="<?= $masuk->id_supplier ?>"><?= $masuk->nama_supplier ?> - <?= $masuk->id_supplier ?></option>
                    <option>===========</option>
                    <?php if (count($suppliers) > 0) : ?>
                      <?php foreach ($suppliers as $supplier) : ?>
                        <option value="<?php echo $supplier->id_supplier; ?>" <?php echo set_select('id_supplier', $supplier->id_supplier); ?>><?php echo $supplier->nama_supplier; ?> - <?php echo $supplier->id_supplier; ?></option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                  <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('id_supplier'); ?></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="id_barang">Nama Barang :</label>
                  <select name="id_barang" class="form-control" id="id_barang">
                    <option value="<?= $masuk->id_barang ?>"><?= $masuk->nama_barang ?> - <?= $masuk->id_barang ?></option>
                    <option>===========</option>
                    <?php if (count($barangs) > 0) : ?>
                      <?php foreach ($barangs as $barang) : ?>
                        <option value="<?php echo $barang->id_barang; ?>" <?php echo set_select('id_barang', $barang->id_barang); ?>><?php echo $barang->nama_barang; ?> - <?php echo $barang->id_barang; ?></option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                  <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('id_barang'); ?></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="harga">Harga:</label>
              <input type="number" name="harga" value="<?php echo (set_value('harga') == NULL) ? $masuk->harga : set_value('harga'); ?>" class="form-control" id="harga">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('harga'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="jumlah">Jumlah:</label>
              <input type="number" name="jumlah" value="<?php echo (set_value('jumlah') == NULL) ? $masuk->jumlah : set_value('jumlah'); ?>" class="form-control" id="jumlah">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('jumlah'); ?></div>
            </div>
            <div class="form-group">
              <label class="form-control-label" for="tgl_pembelian">Tanggal Simpan:</label>
              <input type="date" name="tgl_pembelian" value="<?php echo (set_value('tgl_pembelian') == NULL) ? $masuk->tgl_pembelian : set_value('tgl_pembelian'); ?>" class="form-control" id="tgl_pembelian">
              <div class="form-error text-danger font-weight-bold"> <?= $validation->getError('tgl_pembelian'); ?></div>
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