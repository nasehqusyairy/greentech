<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');

if (session()->has('errors')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="m-0">
      <?php foreach (session('errors') as $error): ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<form action="<?= base_url('papers/update/' . $paper->id); ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $paper->id; ?>">
  <div class="card mb-3">
    <div class="card-body">
      <?php if ($user == '3'): ?>
        <div class="mb-3">
          <label for="abstrac_id" class="form-label">Abstract Title</label>
          <select class="form-select" id="abstrac_id" name="abstrac_id">
            <?php foreach ($abstracs as $abstrac): ?>
              <option value="<?= $abstrac->id ?>" <?= $paper->abstrac_id == $abstrac->id ? 'selected' : '' ?>>
                <?= $abstrac->title ?>
              </option>
            <?php endforeach; ?>
          </select>

        </div>
        <div class="mb-3">
          <label for="publication_id" class="form-label">Publication</label>
          <select class="form-select" id="publication_id" name="publication_id">
            <?php foreach ($publications as $publication): ?>
              <option value="<?= $publication->id ?>" <?= $paper->publication_id == $publication->id ? 'selected' : '' ?>>
                <?= $publication->name ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endif ?>
      <?php if ($user == '1' or $user == '0'): ?>
        <div class="mb-3">
          <label for="status_id" class="form-label">Payment Status</label>
          <select class="form-select" id="status_id" name="status_id">
            <?php foreach ($statuses as $status): ?>
              <option value="<?= $status->id ?>" <?= $paper->status_id == $status->id ? 'selected' : '' ?>><?= $status->text ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endif ?>
      <?php if ($user == '3'): ?>
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
      <?php endif ?>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
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
  // $('#reviewer_id').select2({
  //   theme: 'bootstrap-5',
  //   width: '100%'
  // });
</script>
<?php $this->endSection() ?>