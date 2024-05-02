<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');

$name = !old('name') ? $trole->name : old('name');
$code = !old('code') ? $trole->code : old('code');

if (session()->has('errors')) : ?>
  <div class="alert alert-danger alert-dismissible fade show">
    <ul class="m-0">
      <?php foreach (session('errors') as $error) : ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<form action="<?= base_url('troles/update'); ?>" method="post">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $trole->id ?>">
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="code" class="form-label">Code</label>
        <input type="text" class="form-control" id="code" name="code" value="<?= $code ?>">
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>">
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('troles'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>

</form>

<?= $this->endSection() ?>