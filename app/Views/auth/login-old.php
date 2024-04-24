<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');
?>

<!-- message -->
<?php if (session()->has('message')) : ?>
  <p><?= session('message') ?></p>
<?php endif; ?>
<!-- errors -->
<?php if (session()->has('errors')) : ?>
  <ul>
    <?php foreach (session('errors') as $error) : ?>
      <li><?= $error ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<form action="<?= base_url('/auth/login'); ?>" method="post">
  <?= csrf_field(); ?>
  <label for="email">Email</label>
  <input type="email" name="email" id="email" value="<?= old('email'); ?>">
  <br>
  <label for="password">Password</label>
  <input type="password" name="password" id="password">
  <br>
  <button type="submit">Submit</button>
  <a href="<?= base_url('/auth/register'); ?>">register</a>
</form>

<?php $this->endSection(); ?>