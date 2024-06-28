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

<form action="<?= base_url('submenus/store'); ?>" method="post">
  <?= csrf_field(); ?>
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="code" class="form-label">Code</label>
        <input type="text" class="form-control" id="code" name="code" value="<?= old('code'); ?>">
      </div>
      <div class="mb-3">
        <label for="menu_id" class="form-label">Parent</label>
        <select class="form-select" id="menu_id" name="menu_id">
          <option value="">Choose...</option>
          <?php foreach ($menus as $menu) : ?>
            <option value="<?= $menu->id; ?>" <?= old('menu_id') == $menu->id ? 'selected' : ''; ?>><?= $menu->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="icon" class="form-label">Icon</label>
        <input type="text" name="icon" value="<?= old('icon'); ?>" class="form-control iconpicker" placeholder="Icon Picker" autocomplete="off" />
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= old('name'); ?>">
      </div>
      <div class="mb-3">
        <label for="is_path" class="form-label">Is Path</label>
        <select class="form-select" id="is_path" name="is_path">
          <option value="1" <?= old('is_path') == '1' ? 'selected' : ''; ?>>Yes</option>
          <option value="0" <?= old('is_path') == '0' ? 'selected' : ''; ?>>No</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="url" class="form-label">URL</label>
        <div class="input-group">
          <span class="input-group-text"><?= base_url(); ?></span>
          <input type="text" class="form-control" id="url" name="url" value="<?= old('url'); ?>">
        </div>
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button onsubmit="loadingButton(event)" type="submit" class="btn btn-primary">Save</button>
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
    width: '100%'
  });
  $('#is_path').select2({
    theme: 'bootstrap-5',
    width: '100%'
  });

  // hilangkan input-group-text jika is_path = 0
  $('#is_path').on('change', function() {
    if ($(this).val() == 0) {
      $('#url').val('');
      const parent = $('#url').parent()
      // hilangkan class input-group
      parent.removeClass('input-group');
      parent.find('.input-group-text').hide();
    } else {
      const parent = $('#url').parent()
      // tambahkan class input-group
      parent.addClass('input-group');
      parent.find('.input-group-text').show();
    }
  });
</script>
<?php $this->endSection() ?>