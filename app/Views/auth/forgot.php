<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Green Tech | Forgot Password</title>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/main.min.css">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/LOGO BULAT.png">

  <!-- Theme Color -->
  <meta name="theme-color" content="#008080">
  <!-- <meta name="theme-color" content="#0d6efd"> -->
</head>

<body class="bg-light">

  <!-- login form -->
  <div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
      <div class="col-md-6 col-lg-4">
        <div class="card mb-3">
          <div class="card-body">
            <form action="<?= base_url('auth/reset'); ?>" method="POST">
              <?= csrf_field(); ?>
              <h3 class="text-center">Forgot Password?</h3>
              <p class="text-muted text-center">Enter your email address and we'll send you a link to reset your
                password.</p>
              <?php if (session()->has('error')) : ?>
                <div class="alert alert-danger" role="alert">
                  <?= session('error') ?>
                </div>
              <?php endif; ?>
              <?php if (session()->has('message')) : ?>
                <div class="alert alert-success" role="alert">
                  <?= session('message') ?>
                </div>
              <?php endif; ?>
              <form action="#" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="d-grid gap-2 mb-3">
                  <button type="submit" class="btn btn-primary">Send Email</button>
                </div>
                <p class="text-center m-0"><a href="<?= base_url('auth'); ?>"><i class="bi bi-arrow-left"></i> Back to
                    Authentication</a></p>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>