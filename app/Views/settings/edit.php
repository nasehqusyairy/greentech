<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');

$category = !old('category') ? $setting->category : old('category');
$title = !old('title') ? $setting->title : old('title');
$description = !old('description') ? $setting->description : old('description');
$name = !old('name') ? $setting->name : old('name');
$value = !old('value') ? $setting->value : old('value');


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

<form action="<?= base_url('settings/update'); ?>" method="post">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $setting->id ?>">
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <input type="text" class="form-control" id="category" name="category" value="<?= $setting->category ?>">
      </div>
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $setting->title ?>">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" name="description" value="<?= $setting->description ?>">
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>">
      </div>
      <div class="mb-3">
        <label for="value" class="form-label">Value</label>
        <input type="text" class="form-control" id="value" name="value" value="<?= $setting->value ?>">
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button onsubmit="loadingButton(event)" type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('settings'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>

</form>

<?= $this->endSection() ?>