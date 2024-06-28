<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');

if (session()->has('errors')) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="m-0">
      <?php foreach (session('errors') as $error) : ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<form action="<?= base_url('settings/store'); ?>" method="post">
  <?= csrf_field(); ?>
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <input type="text" class="form-control" id="category" name="category" value="<?= old('category'); ?>">
      </div>
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= old('title'); ?>">
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= old('name'); ?>">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" name="description" value="<?= old('description'); ?>">
      </div>
      <div class="mb-3">
        <label for="value" class="form-label">Value</label>
        <input type="text" class="form-control" id="value" name="value" value="<?= old('value'); ?>">
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button onsubmit="loadingButton(event)" type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('settings'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>

</form>

<?php
$this->endSection();
$this->section('footer');
?>
<script>

</script>
<?php $this->endSection() ?>