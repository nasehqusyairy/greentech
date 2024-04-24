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
<form action="/home/store" method="post">
  <?= csrf_field() ?>
  <label for="name">Name</label>
  <input type="text" name="name" id="name" value="<?= old('name'); ?>">
  <br>
  <label for="email">Email</label>
  <input type="email" name="email" id="email" value="<?= old('email'); ?>">
  <br>
  <label for="password">Password</label>
  <input type="password" name="password" id="password" value="<?= old('password'); ?>">
  <br>
  <label for="role_id">Role ID</label>
  <select name="role_id" id="role_id">
    <?php foreach ($roles as $role) : ?>
      <option value="<?= $role['id'] ?>" <?= old('role_id') == $role['id'] ? 'selected' : '' ?>><?= $role['name'] ?></option>
    <?php endforeach; ?>
  </select>
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