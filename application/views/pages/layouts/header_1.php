<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?= $description ?>">
    <meta name="keywords" content="<?= $keywords ?>">
    <meta name="author" content="<?= $author ?>">

    <title><?= $title ?></title>

    <!-- Main styles -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/animate.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/pnotify/css/pnotify.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/pnotify/css/pnotify.mobile.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/pnotify/css/pnotifybrighttheme.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/main-styles.css">

    <?= $links ?>

</head>

<body>

    <div class="bs-total-page-loader" id="bs-total-page-loader">
        <img src="<?= base_url() ?>assets/images/spinning-circles-1.svg" alt="Gif de carga">
    </div>

    <!-- Full page wrapper -->
    <div class="full-page-wrapper" id="full-page-wrapper">

        <!-- Navigation -->
        <div class="hw-navigation">

            <!-- Top -->
            <div class="hw-top-navigation">
                <a href="<?= base_url() ?>" class="hw-brand">
                    <span class="hw-brand-small">MedSystem</span>
                    <span class="hw-brand-large">MedSystem | Hewks</span>
                </a>
                <div class="hw-top-right-navigation">
                    <div class="hw-navigation-toggler" id="sidebarToggler">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
            </div>

            <!-- Left -->
            <div class="hw-left-navigation" id="primarySidebar">
                <div class="hw-module-divider">
                    <span>Usuarios</span>
                </div>
                <div class="hw-module-container">
                    <div class="hw-module">
                        <a href="<?= base_url() ?>">Pacientes</a>
                    </div>
                    <div class="hw-module">
                        <a href="<?= base_url() ?>">Doctor</a>
                    </div>
                </div>
                <div class="hw-module-divider">
                    <span>Configuracion</span>
                </div>
                <div class="hw-module-container">
                    <div class="hw-module">
                        <a href="<?= base_url() ?>">Administradores</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Navigation -->