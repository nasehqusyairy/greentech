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

<form action="<?= base_url("abstracs/$abstract->id/reviews/store"); ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input class="form-control" type="text" name="title" id="title" disabled value="<?= $abstract->title; ?>">
      </div>
      <div class="mb-3">
        <label for="comment" class="form-label">Comment</label>
        <textarea class="form-control" name="comment" id="comment" rows="5"><?= old('comment'); ?></textarea>
      </div>
      <div class="mb-3">
        <label for="file" class="form-label">File</label>
        <input class="form-control" type="file" name="file" id="file">
      </div>
      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" name="status_id" id="status">
          <?php foreach ($statuses as $status) : ?>
            <option value="<?= $status->id; ?>" <?= old('status') == $status->id ? 'selected' : ''; ?>>
              <?= $status->text; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url("abstracs/$abstract->id/reviews/"); ?>" class="btn btn-secondary">Cancel</a>
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
  $('#status').select2({
    theme: 'bootstrap-5',
    width: '100%',
  });
</script>
<?php $this->endSection() ?>