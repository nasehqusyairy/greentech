<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('auth/layout');
$this->section('content');
$google_account_info = session()->get('google_account_info');
$name = $google_account_info['name'] ?? old('name');
$email = $google_account_info['email'] ?? old('email')
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card my-3">
      <div class="card-body">
        <form action="<?= base_url('auth/store'); ?>" method="post">
          <?= csrf_field(); ?>
          <h3 class="text-center">Sign Up</h3>
          <?php if (session()->has('errors')) : ?>
            <div class="alert alert-danger" role="alert">
              <ul>
                <?php foreach (session('errors') as $error) : ?>
                  <li><?= $error ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="name" class="form-control" id="name" name="name" value="<?= $name; ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $email; ?>" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100 mb-3">Submit</button>
          <p class="text-center">Or</p>
          <a href="<?= base_url('auth/google'); ?>" class="btn btn-outline-primary w-100 mb-3"><i class="bi bi-google me-3"></i>
            Continue
            with
            Google</a>
          <p class="text-center m-0">Already have an account? <a href="<?= base_url('auth'); ?>">Login</a></p>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $this->endSection(); ?>