<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');

$name = !old('name') ? $topic->name : old('name');

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

<form action="<?= base_url('topics/update'); ?>" method="post">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $topic->id ?>">
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?= old('description') ? old('description') : $topic->description ?></textarea>
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button onsubmit="loadingButton(event)" type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('topics'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>

</form>

<?= $this->endSection() ?>