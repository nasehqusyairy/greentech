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
  <title>Green Tech | Sign In</title>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/main.min.css">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/LOGO BULAT.png">

  <!-- Theme Color -->
  <meta name="theme-color" content="#008080">
  <!-- <meta name="theme-color" content="#0d6efd"> -->
  <style>
    .bd-login-form {
      min-height: 100vh;
      flex: 4;
      display: flex;
      align-items: center;
      background-position: center;
      background-size: cover;
    }

    .bd-login-cover {
      min-height: 100vh;
      flex: 3;
      background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1)), url(/assets/img/bg3.jpg);
      background-size: cover;
      background-position: center;
    }

    .alert ul {
      margin: 0;
    }
  </style>
</head>

<body style="background-color: var(--bs-gray-900);">
  <div class="bd-login-layout bg-light d-block d-lg-flex">

    <section class="bd-login-cover p-3 p-5 pb-0 d-flex flex-column justify-content-between">
      <!-- tampilkan logo dan deskripsi aplikasi -->
      <div class="text-center">
        <img src="<?= base_url(); ?>assets/img/LOGO_TRANSPARAN.png" alt="Logo" height="100">
      </div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-6">
            <div class="text-white text-center">
              <h1>THE 14TH INTERNATIONAL CONFERENCE ON GREEN TECHNOLOGY (ICGT)</h1>
              <p>ICGT is an annual multidisciplinary meeting for cultivating and promoting
                interactions between educators, scientists, engineers, and industry researchers in studying the development
                of science & technology and related area. </p>
              <p class="text-center">
                <a href="https://greentech.uin-malang.ac.id" class="text-white">Read more</a>
              </p>
				
              <p><a href="<?= base_url('auth/google'); ?>" class="btn btn-primary btn-lg"><i class="bi bi-google me-3"></i>
                  Continue
                  with
                  Google</a></p>
			
            </div>
          </div>
        </div>
      </div>
      <div>
        <p class="text-white text-center">© <?= date('Y'); ?>. All rights reserved.</p>
      </div>
    </section>

  </div>

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>