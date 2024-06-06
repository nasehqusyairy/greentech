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

<form action="<?= base_url('papers/store'); ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="abstrac_id" class="form-label">Abstract Title</label>
        <select class="form-select" id="abstrac_id" name="abstrac_id">
          <option value="">Choose...</option>
          <?php foreach ($abstracs as $abstrac) : ?>
            <option value="<?= $abstrac->id ?>" <?= old('abstrac_id') == $abstrac->id ? 'selected' : '' ?>><?= $abstrac->title ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="publication_id" class="form-label">Publication</label>
        <select class="form-select" id="publication_id" name="publication_id">
          <option value="">Choose...</option>
          <?php foreach ($publications as $publication) : ?>
            <option value="<?= $publication->id ?>" <?= old('publication_id') == $publication->id ? 'selected' : '' ?>><?= $publication->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="file" class="form-label">File Paper</label>
        <input class="form-control" type="file" id="file" name="file" accept=".pdf,.doc,.docx">
        <small class="form-text">
          Allowed file types: pdf, doc, docx. Max file size: 5MB
        </small>
      </div>
      <div class="mb-3">
        <label for="provement" class="form-label">File Provement</label>
        <input class="form-control" type="file" id="provement" name="provement" accept=".pdf,.jpg,.png">
        <small class="form-text">
          Allowed file types: pdf, jpg, png. Max file size: 5MB
        </small>
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('papers'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>
</form>

<?php
$this->endSection();
$this->section('footer');
?>
<script>
  // select2
  $('#topic_id').select2({
    theme: 'bootstrap-5',
    width: '100%'
  });
</script>
<?php $this->endSection() ?>