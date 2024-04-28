<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');

$this->section('header');
?>
<link href="<?= base_url('assets/css/bootstrapicons-iconpicker.css'); ?>" rel="stylesheet" />
<?php
$this->endSection();
$this->section('content');

$menu_id = old('menu_id') ?? $submenu->menu_id;

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

<form action="<?= base_url('submenus/update'); ?>" method="post">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $submenu->id; ?>">
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="code" class="form-label">Code</label>
        <input type="text" class="form-control" id="code" name="code" value="<?= old('code') ?? $submenu->code; ?>">
      </div>
      <div class="mb-3">
        <label for="menu_id" class="form-label">Parent</label>
        <select class="form-select" id="menu_id" name="menu_id">
          <option value="">Choose...</option>
          <?php foreach ($menus as $menu) : ?>
            <option value="<?= $menu->id; ?>" <?= $menu_id == $menu->id ? 'selected' : ''; ?>><?= $menu->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="icon" class="form-label">Icon</label>
        <input type="text" name="icon" value="<?= old('icon') ?? $submenu->icon; ?>" class="form-control iconpicker" placeholder="Icon Picker" autocomplete="off" />
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?? $submenu->name; ?>">
      </div>
      <div class="mb-3">
        <label for="url" class="form-label">URL</label>
        <input type="url" class="form-control" id="url" name="url" value="<?= old('url') ?? $submenu->url; ?>">
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('submenus'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>

</form>

<?php
$this->endSection();
$this->section('footer');
?>
<script src="<?= base_url('assets/js/bootstrapicon-iconpicker.js'); ?>"></script>
<script>
  $('.iconpicker').iconpicker({
    placement: "bottomLeft",
    inputSearch: true,
    animation: false,
    selectedCustomClass: "bg-primary text-white",
    hideOnSelect: true,
    templates: {
      iconpickerItem: `<a href="javascript:void(0)" class="iconpicker-item text-primary"><i></i></a>`
    }
  });
  $('#menu_id').select2({
    theme: 'bootstrap-5',
    placeholder: 'Select...',
    width: '100%'
  });
</script>
<?php $this->endSection() ?>