<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Green Tech | <?= $title; ?></title>
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/main.min.css">
  <link rel="shortcut icon" href="<?= base_url() ?>assets/img/LOGO BULAT.png">

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <!-- DataTables -->
  <link href="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.js"></script>

  <!-- Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <?= $this->renderSection('header'); ?>

  <!-- Theme Color -->
  <meta name="theme-color" content="#008080">
  <!-- <meta name="theme-color" content="#0d6efd"> -->
</head>

<body style="background-color: var(--bs-gray-900);">

  <!-- CONTAINER -->
  <div class="container-fluid bd-layout p-0">
    <!-- <div class="container-xxl bd-layout bg-white p-0"> -->

    <!-- HEADER -->
    <header class="bd-header shadow z-3">
      <!-- NAVBAR -->
      <nav class="bg-white p-3">
        <h5 class="m-0 text-truncate">
          <button class="btn btn-link d-inline-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="bi bi-list"></i>
          </button>
          <button class="btn btn-link d-none d-lg-inline-block" type="button" id="sidebar-toggler">
            <i class="bi bi-list"></i>
          </button>
          <?= $title; ?>
        </h5>
      </nav>
      <!-- END OF NAVBAR -->

    </header>
    <!-- END OF HEADER -->

    <?= $this->include('components/sidebar'); ?>

    <!-- MAIN -->
    <main class="bd-main p-3 bg-light">
      <?= $this->renderSection('content'); ?>
      <!-- <div class="bg-danger" style="height: 100vh;"></div> -->
    </main>
    <!-- END OF MAIN -->

    <!-- FOOTER -->
    <footer class="bd-footer text-bg-primary text-center py-3">
      Copyrigth &copy; <?= date('Y'); ?>. All rights reserved
    </footer>
    <!-- END OF FOOTER -->

  </div>
  <!-- END OF CONTAINER -->

  <!-- Modals -->

  <!-- LOGOUT MODAL -->
  <div class="modal fade" id="logoutModal">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Log Out</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to log out?</p>
        </div>
        <div class="modal-footer">
          <a href="<?= base_url('auth/logout') ?>" class="btn btn-primary">Yes</a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- END OF LOGOUT MODAL -->

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <!-- Main Script -->
  <script src="<?= base_url() ?>assets/js/blank.js"></script>

  <?= $this->renderSection('footer'); ?>
</body>

</html>