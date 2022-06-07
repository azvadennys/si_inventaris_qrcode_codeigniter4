<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- Card stats -->
      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Produk</h5>
                  <span class="h2 font-weight-bold mb-0"><?//php echo $total_products; ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                    <i class="ni ni-shop"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                <span class="text-nowrap">Jumlah produk yang tersedia</span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Pelanggan</h5>
                  <span class="h2 font-weight-bold mb-0"><?//php echo $total_customers; ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                    <i class="ni ni-circle-08"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                <span class="text-nowrap">Pelanggan yang terdaftar</span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Pesanan</h5>
                  <span class="h2 font-weight-bold mb-0"><?//php echo $total_order; ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                    <i class="ni ni-chart-bar-32"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                <span class="text-nowrap">Jumlah pesanan diterima</span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Pendapatan</h5>
                  <span class="h2 font-weight-bold mb-0">Rp <?//php echo format_rupiah($total_income); ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                    <i class="ni ni-money-coins"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                <span class="text-nowrap">Total pendapatan</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">

  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>