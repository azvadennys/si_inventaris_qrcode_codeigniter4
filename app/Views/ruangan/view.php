<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0"><?php echo $ruangan->nama_ruangan; ?></h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('ruangan'); ?>">Ruangan</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $ruangan->nama_ruangan; ?></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row align-content-center">
    <div class="col-md-4">
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
          <div class="card-body p-0">
            <div>
              <img alt="<?php echo $ruangan->nama_ruangan; ?>" class="img img-fluid rounded" src="<?php if ($ruangan->foto == NULL) {
                                                                                                    echo base_url('assets/uploads/ruangan/default.jpg');
                                                                                                  } else {
                                                                                                    echo base_url('assets/uploads/ruangan/' . $ruangan->foto);
                                                                                                  }  ?>">
            </div>

            <table class="table table-hover table-striped">
              <tr>
                <td>Nama Ruangan</td>
                <td>:</td>
                <td><b><?php echo $ruangan->nama_ruangan; ?></b></td>
              </tr>
              <tr>
                <td>Lokasi</td>
                <td>:</td>
                <td><b><?php echo $ruangan->nama_gedung; ?></b></td>
              </tr>
              <tr>
                <td>Kapasitas</td>
                <td>:</td>
                <td><b><?php echo $ruangan->kapasitas_ruangan;; ?></b></td>
              </tr>
              <tr>
                <td>Terisi</td>
                <td>:</td>
                <td><b><?php echo $ruangan->terisi_ruangan; ?></b></td>
              </tr>
              <tr>
                <td>Total Barang</td>
                <td>:</td>
                <td><b><?php echo $totalBarang; ?></b></td>
              </tr>

            </table>
          </div>
          <div class="card-footer text-right">
            <a href="<?php echo base_url('ruangan/edit/' . $ruangan->id_ruangan); ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
            <a href="#" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger"><i class="fa fa-trash"></i></a>
          </div>

        </div>

      </div>

    </div>
    <div class="col-md-8">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="mb-0">Data Barang di Ruangan</h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th scope="col">NO</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Merek Barang</th>
                  <th scope="col">Jenis Barang</th>
                  <th scope="col">Barang Bagus</th>
                  <th scope="col">Barang Rusak</th>
                  <th scope="col">Total Barang</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1 ?>
                <?php $barangs = barang_in_ruangan($ruangan->id_ruangan) ?>
                <?php if (count($barangs) > 0) : ?>
                  <?php foreach ($barangs as $barang) : ?>
                    <tr>
                      <th scope="col">
                        <?php echo $i++; ?>
                      </th>
                      <td><?php echo  anchor('barang/view/' . $barang->id_barang, $barang->nama_barang); ?></td>
                      <td><?php echo $barang->merek; ?></td>
                      <td><?php echo $barang->jenis; ?></td>
                      <td><?php echo $barang->barang_bagus; ?></td>
                      <td><?php echo $barang->barang_rusak; ?></td>
                      <td><?php echo ($barang->barang_rusak + $barang->barang_bagus); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr>
                    <td colspan="7" class="text-center">
                      <h2>Belum Ada Data Barang</h2>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-modal-dialog-centered modal-" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-default">Hapus Produk</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="#" id="deleteProductForm" method="POST">

          <input type="hidden" name="id" value="<?php echo $ruangan->id_ruangan; ?>">

          <div class="modal-body">
            <p class="deleteText">Yakin ingin menghapus produk ini? Semua data yang terkait seperti data order juga akan dihapus. Tindakan ini tidak dapat dibatalkan.</p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger btn-delete">Hapus</button>
            <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $('#deleteProductForm').submit(function(e) {
      e.preventDefault();

      var btn = $('.btn-delete');
      var data = $(this).serialize();

      btn.html('<i class="fa fa-spin fa-spinner"></i> Menghapus...').attr('disabled', true);

      $.ajax({
        method: 'POST',
        url: '<?php echo base_url('ruangan/product_api?action=delete_product'); ?>',
        data: data,
        success: function(res) {
          if (res.code == 204) {
            setTimeout(function() {
              btn.html('<i class="fa fa-check"></i> Terhapus!');
              $('.deleteText').fadeOut(function() {
                $(this).text('Produk berhasil dihapus')
              }).fadeIn();
            }, 2000);

            setTimeout(function() {
              $('.deleteText').fadeOut(function() {
                $(this).text('Mengalihkan...')
              }).fadeIn();
            }, 4000);

            setTimeout(function() {
              window.location = '<?php echo base_url('ruangan'); ?>';
            }, 6000);
          } else {
            console.log('Terjadi kesalahan sata menghapus produk');
          }
        }
      })
    })
  </script>

  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>