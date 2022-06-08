<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Kelola Ruangan</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="<?php echo base_url('ruangan/tambah'); ?>" class="btn btn-sm btn-neutral">Tambah</a>
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
          <h3 class="mb-0">Kelola Ruangan</h3>
        </div>

        <?php if (count($ruangan) > 0) : ?>
          <div class="card-body">
            <div class="row">
              <?php foreach ($ruangan as $ruangans) : ?>
                <div class="col-md-3">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-heading"><?php echo $ruangans['nama_ruangan']; ?></h3>
                    </div>
                    <div class="card-body">
                      <div class="text-center">
                        <img alt="<?php echo $ruangans['nama_ruangan']; ?>" class="img img-fluid rounded" src="<?php if ($ruangans['foto'] == NULL) {
                                                                                                                  echo base_url('assets/uploads/ruangan/default.jpg');
                                                                                                                } else {
                                                                                                                  echo base_url('assets/uploads/ruangan/' . $ruangans['foto']);
                                                                                                                } ?>" style="width: 1000px; max-height: 800px">
                      </div>

                    </div>
                    <div class="card-footer text-center">
                      <a href="<?php echo base_url('ruangan/view/' . $ruangans['id_ruangan']); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                      <a href="<?php echo base_url('ruangan/edit/' . $ruangans['id_ruangan']); ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
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
                  Belum ada data ruangan yang ditambahkan. Silahkan menambahkan baru.
                </div>
              </div>
              <div class="col-md-4">
                <a href="<?php echo base_url('ruangan/tambah'); ?>"><i class="fa fa-plus"></i> Tambah Ruangan baru</a>
              </div>
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>