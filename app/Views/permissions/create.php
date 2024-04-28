<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
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

<form action="<?= base_url('permissions/store'); ?>" method="post">
  <?= csrf_field(); ?>
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="path" class="form-label">Path</label>
        <div class="input-group">
          <span class="input-group-text"><?= base_url(); ?></span>
          <input type="text" class="form-control" id="path" name="path" value="<?= old('path'); ?>" placeholder="your/path/here/...">
        </div>
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('permissions'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>

</form>

<?php
$this->endSection();
$this->section('footer');
?>
<script>
  // path value will be converted to lowercase and remove slash at the end and beginning
  document.getElementById('path').addEventListener('change', function() {
    this.value = this.value.toLowerCase().replace(/\/$/, '').replace(/^\//, '');
  })
</script>
<?php $this->endSection() ?>