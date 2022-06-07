<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Kelola gedung</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="<?php echo base_url('gedung/tambah'); ?>" class="btn btn-sm btn-neutral">Tambah</a>
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
          <h3 class="mb-0">Kelola gedung</h3>
        </div>

        <?php if (count($gedung) > 0) : ?>
          <div class="card-body">
            <div class="row">
              <?php foreach ($gedung as $gedungs) : ?>
                <div class="col-md-3">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-heading"><?php echo $gedungs['nama_gedung']; ?></h3>
                    </div>
                    <div class="card-body">
                      <div class="text-center">
                        <img alt="<?php echo $gedungs['nama_gedung']; ?>" class="img img-fluid rounded" src="<?php if ($gedungs['foto'] == NULL) {
                                                                                                                echo base_url('assets/uploads/gedung/default.jpg');
                                                                                                              } else {
                                                                                                                echo base_url('assets/uploads/gedung/' . $gedungs['foto']);
                                                                                                              } ?>" style="width: 1000px; max-height: 800px">
                      </div>

                    </div>
                    <div class="card-footer text-center">
                      <a href="<?php echo base_url('gedung/view/' . $gedungs['id_gedung']); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                      <a href="<?php echo base_url('gedung/edit/' . $gedungs['id_gedung']); ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="card-footer">
            <?php echo $pager->links('card', 'pagination'); ?>
          </div>
        <?php else : ?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-primary">
                  Belum ada data gedung yang ditambahkan. Silahkan menambahkan baru.
                </div>
              </div>
              <div class="col-md-4">
                <a href="<?php echo base_url('gedung/tambah'); ?>"><i class="fa fa-plus"></i> Tambah produk baru</a>
              </div>
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>