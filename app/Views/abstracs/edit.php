<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');
$user = $user->role->code;

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


<form action="<?= base_url('abstracs/update/' . $abstract->id); ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $abstract->id; ?>">
  <input type="hidden" name="creator_id" value="<?= session('user'); ?>">
  <div class="card mb-3">
    <div class="card-body">
      <?php if ($user == '3') : ?>
        <div class="mb-3">
          <label for="topic_id" class="form-label">Topic</label>
          <select class="form-select" id="topic_id" name="topic_id">
            <option value="">Choose...</option>
            <?php foreach ($topics as $topic) : ?>
              <option value="<?= $topic->id ?>" <?= $abstract->topic_id == $topic->id ? 'selected' : '' ?>><?= $topic->name ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" value="<?= $abstract->title ?>">
        </div>
        <div class="mb-3">
          <label for="authors" class="form-label">Authors</label>
          <input type="text" class="form-control" id="authors" name="authors" value="<?= $abstract->authors ?>">
          <small class="form-text">
            Separate authors with comma (,)
          </small>
        </div>
        <div class="mb-3">
          <label for="emails" class="form-label">Emails</label>
          <input type="text" class="form-control" id="emails" name="emails" value="<?= $abstract->emails ?>">
          <small class="form-text">
            Separate emails with comma (,)
          </small>
        </div>
        <div class="mb-3">
          <label for="text" class="form-label">Abstract Text</label>
          <textarea class="form-control" id="text" name="text" rows="3"><?= $abstract->text ?></textarea>
        </div>
        <div class="mb-3">
          <label for="file" class="form-label">File</label>
          <input class="form-control" type="file" id="file" name="file" accept=".pdf,.doc,.docx">
          <small class="form-text">
            Allowed file types: pdf, doc, docx. Max file size: 5MB
          </small>
        </div>
      <?php else : ?>
        <div class="mb-3">
          <label for="reviewer_id" class="form-label">Reviewer</label>
          <select class="form-select" id="reviewer_id" name="reviewer_id">
            <option value="">Choose...</option>
            <?php foreach ($reviewers as $reviewer) : ?>
              <option value="<?= $reviewer->id ?>" <?= $abstract->reviewer_id == $reviewer->id ? 'selected' : '' ?>><?= $reviewer->name ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endif ?>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('abstracs'); ?>" class="btn btn-secondary">Cancel</a>
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