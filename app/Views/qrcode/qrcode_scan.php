<?= $this->extend('header'); ?>

<?= $this->section('konten'); ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Scan QRCode</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('scan'); ?>">Scanner</a></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">QRCode Scanner</h3>
          </div>
          <div class="card-body p-0">
            <div id="qrcode" class="row justify-content-center">
              <video id="priview" width="80%"></video>
            </div>

          </div>
          <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
          <script>
            let scanner = new Instascan.Scanner({
              video: document.getElementById('priview')
            });
            Instascan.Camera.getCameras().then(function(cameras) {
              if (cameras.length > 0) {
                scanner.start(cameras[0]);
              } else {
                alert('No Cameras Found!');
              }
            }).catch(function(e) {
              console.error(e);
            });
            scanner.addListener('scan', function(c) {
              window.location.replace(c);
              // location.href = c;
              // window.open = (c, '_blank');
              document.getElementById('link').value = c;
            });
          </script>
          <div class="card-footer text-center">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <input type="text" name="link" id="link" readonly placeholder="Scan QRCode" class="form-control text-center">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


  <?= $this->include('footer') ?>
  <?= $this->endSection(); ?>