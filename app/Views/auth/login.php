<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Sistem Informasi</title>
    <!-- <link rel="canonical" href="https://www.creative-tim.com/product/argon-dashboard" /> -->
    <link rel="icon" href=<?= base_url('assets/themes/argon/img/brand/favicon.png'); ?> type="image/png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">

    <link rel="stylesheet" href=<?= base_url('assets/themes/argon/js/plugins/nucleo/css/nucleo.css'); ?> type="text/css">
    <link rel="stylesheet" href=<?= base_url('assets/themes/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css'); ?> type="text/css">
    <link rel="stylesheet" href=<?= base_url('assets/themes/argon/css/argon9f1e.css'); ?> type="text/css">

</head>

<body class="bg-default">

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    <div class="main-content">

        <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                            <h1 class="text-white">Welcome!</h1>
                            <p class="text-lead text-white">Sistem Informasi Inventaris<br>SD Negeri 41 Kota Bengkulu </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-header bg-transparent pb-5">
                            <div class="text-center text-muted mt-3 mb-5">
                                <medium>Login Account</medium>
                            </div>
                            <form action="auth/auth" method="POST">
                                <?php if (session()->getFlashdata('msg')) : ?>
                                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                                <?php endif; ?>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-user-run"></i></span>
                                        </div>
                                        <input name="username" class="form-control" placeholder="Username" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input name="password" class="form-control" placeholder="Password" type="password">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="row mt-3">
                        <div class="col-6">
                            <a href="#" class="text-light"><small>Forgot password?</small></a>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" class="text-light"><small>Create new account</small></a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <footer class="py-5" id="footer-main">
        <div class="container">
            <div class="row align-items-center justify-content-xl-center">
                <div class="col-xl-12">
                    <div class="copyright text-center text-xl-center text-muted">
                        &copy; <script>
                            document.write(new Date().getFullYear());
                        </script> <a href="#" class="font-weight-bold ml-1" target="_blank">Sistem Informasi Inventaris</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src=<?= base_url('assets/themes/argon/vendor/jquery/dist/jquery.min.js'); ?>></script>
    <script src=<?= base_url('assets/themes/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>></script>
    <script src=<?= base_url('assets/themes/argon/vendor/js-cookie/js.cookie.js'); ?>></script>
    <script src=<?= base_url('assets/themes/argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js'); ?>></script>
    <script src=<?= base_url('assets/themes/argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js'); ?>></script>
    <script src=<?= base_url('assets/themes/argon/js/argon.min.js?v=1.2.0'); ?>></script>
</body>

</html>