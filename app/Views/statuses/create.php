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

<form action="<?= base_url('statuses/store'); ?>" method="post">
  <?= csrf_field(); ?>
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="code" class="form-label">Code</label>
        <input type="text" class="form-control" id="code" name="code" value="<?= old('code'); ?>">
      </div>
      <div class="mb-3">
        <label for="text" class="form-label">Text</label>
        <input type="text" class="form-control" id="text" name="text" value="<?= old('text'); ?>">
      </div>
      <div class="mb-3">
        <label for="color" class="form-label">Color</label>
        <select class="form-select" id="color" name="color">
          <option value="">Select Color</option>
          <option value="primary" <?= old('color') == 'primary' ? 'selected' : ''; ?>>Primary</option>
          <option value="secondary" <?= old('color') == 'secondary' ? 'selected' : ''; ?>>Secondary</option>
          <option value="success" <?= old('color') == 'success' ? 'selected' : ''; ?>>Success</option>
          <option value="danger" <?= old('color') == 'danger' ? 'selected' : ''; ?>>Danger</option>
          <option value="warning" <?= old('color') == 'warning' ? 'selected' : ''; ?>>Warning</option>
          <option value="info" <?= old('color') == 'info' ? 'selected' : ''; ?>>Info</option>
          <option value="light" <?= old('color') == 'light' ? 'selected' : ''; ?>>Light</option>
          <option value="dark" <?= old('color') == 'dark' ? 'selected' : ''; ?>>Dark</option>
        </select>
      </div>
      <!-- Type Drop down -->
      <div class="mb-3">
        <label for="stype_id" class="form-label">Type</label>
        <select class="form-select" id="stype_id" name="stype_id">
          <option value="">Select Type</option>
          <?php foreach ($stypes as $stype) : ?>
            <option value="<?= $stype->id; ?>" <?= old('stype_id') == $stype->id ? 'selected' : ''; ?>><?= $stype->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button onsubmit="loadingButton(event)" type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('statuses'); ?>" class="btn btn-secondary">Cancel</a>
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