<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('auth/layout');
$this->section('content');
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card my-3">
      <div class="card-body">
        <form action="<?= base_url('auth/login'); ?>" method="post">
          <?= csrf_field(); ?>
          <h3 class="text-center">Welcome Back!</h3>
          <?php if (session()->has('errors')) : ?>
            <div class="alert alert-danger" role="alert">
              <?php
              if (count(session('errors')) > 1) :
              ?>
                <ul>
                  <?php foreach (session('errors') as $error) : ?>
                    <li><?= $error ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php else : ?>
                <?= array_values(session('errors'))[0] ?>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if (session()->has('message')) : ?>
            <div class="alert alert-success" role="alert">
              <?= session('message') ?>
            </div>
          <?php endif; ?>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email'); ?>" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="<?= old('password'); ?>" required>
          </div>
          <p>
            <a href="<?= base_url('auth/forgot'); ?>">Forgot Password?</a>
          </p>
          <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="<?= base_url('auth/register'); ?>" class="btn btn-secondary">Sign Up</a>
          </div>
          <p class="text-center">Or</p>
        <!--  <a href="<?= base_url('auth/google'); ?>" class="btn btn-outline-primary w-100 mb-3"><i class="bi bi-google me-3"></i>
            Continue
            with
            Google</a> -->
        </form>
      </div>
    </div>
  </div>
</div>
<?php $this->endSection(); ?>