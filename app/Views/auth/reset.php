<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Green Tech | Reset Password</title>
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/main.min.css">
  <link rel="shortcut icon" href="<?= base_url() ?>assets/img/LOGO BULAT.png">

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
            <form action="<?= base_url('auth/reset/' . $resetPasswordCode); ?>" method="POST">
              <?= csrf_field(); ?>
              <h3 class="text-center">Reset Password</h3>
              <p class="text-muted text-center">You can now enter your new password. Press <strong>Resend
                  Email</strong> button if you haven't received the email.</p>
              </p>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
              </div>
              <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?= base_url('auth/forgot'); ?>" class="btn btn-secondary">Resend Email</a>
              </div>
              <p class="text-center m-0"><a href="<?= base_url('auth') ?>"><i class="bi bi-arrow-left"></i> Back to
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