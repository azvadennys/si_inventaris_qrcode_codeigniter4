<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-3">
          <h6 class="h2 text-white d-inline-block mb-0">Kelola Barang Masuk</h6>
        </div>
        <div class="col-lg-6 col-6 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Barang Masuk</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col">
      <div class="card">
        <!-- Card header -->
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-lg-6  text-left">
              <h3 class="mb-0">Barang Masuk</h3>
            </div>
            <div class="col-lg-6  text-right">
              <a href="<?php echo base_url('barangmasuk/tambah'); ?>" class="btn btn-sm btn-primary">Tambah</a>
            </div>
            <div class="col-lg-6  text-right">
              <?php if ($flash) : ?>
                <span class="float-right text-primary font-weight-bold" style="margin-top: -30px">
                  <?php echo $flash; ?>
                </span>
              <?php endif; ?>
            </div>
          </div>

        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-items-center table-flush" id="customerList" style="width: 100%">
              <thead class="thead-light">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Nama Supplier</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Tanggal Pembelian</th>
                  <th class="text-right">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1 + (10 * ($currentPage - 1)) ?>
                <?php if (count($barangmasuks) > 0) : ?>
                  <?php foreach ($barangmasuks as $barangmasuk) : ?>
                    <tr>
                      <th scope="col">
                        <?php echo $i++; ?>
                      </th>
                      <td><?php echo $barangmasuk['nama_barang']; ?></td>
                      <td>
                        <?php echo $barangmasuk['nama_supplier']; ?>
                      </td>
                      <td>
                        <?php echo $barangmasuk['harga']; ?>
                      </td>
                      <td>
                        <?php echo $barangmasuk['jumlah']; ?>
                      </td>
                      <td>
                        <?php echo get_formatted_date($barangmasuk['tgl_pembelian']); ?>
                      </td>
                      <td>
                        <div class="text-right"><a href="<?= base_url('barangmasuk/edit/' . $barangmasuk['id_pengadaan']) ?>" class="btn btn-warning btn-sm btnEdit"><i class="fa fa-edit"></i> Edit</a>
                          <a href="<?= base_url('barangmasuk/hapus/' . $barangmasuk['id_pengadaan']) ?>" class="btn btn-danger btn-sm btnDelete"><i class="fa fa-trash"> Delete</i></a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr>
                    <td colspan="7" class="text-center">
                      <h2>Belum Ada Data Barang Masuk</h2>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          <?php echo $pager->links('table', 'pagination'); ?>
        </div>
      </div>
    </div>
  </div>
  <link href="<?php echo base_url('assets/themes/argon/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
  <script src="<?php echo base_url('assets/themes/argon/vendor/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/themes/argon/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables.lang.js'); ?>"></script>


  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>