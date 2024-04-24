<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout')
?>

<!-- Header (Optional) -->
<?= $this->section('header') ?>
<style>
  body {
    background-color: #e0e0e0;
  }
</style>
<?= $this->endSection() ?>

<!-- Content -->
<?= $this->section('content') ?>
<?php if (session()->has('errors')) : ?>
  <ul>
    <?php foreach (session('errors') as $error) : ?>
      <li><?= $error ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<form action="/roles/store" method="post">
  <?= csrf_field() ?>
  <label for="name">Name</label>
  <input type="text" name="name" id="name" value="<?= old('name'); ?>">
  <br>
  <button type="submit">Submit</button>
</form>
<?= $this->endSection() ?>

<!-- Footer (Optional) -->
<?= $this->section('footer') ?>
<script>
  document.body.append('footer');
</script>
<?= $this->endSection() ?>