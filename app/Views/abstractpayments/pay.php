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

<form action="<?= base_url('abstractpayments/update/' . $abstract->id); ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $abstract->id; ?>">
  <input type="hidden" name="creator_id" value="<?= session('user'); ?>">
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="ticket_user_id" class="form-label">Tickert User</label>
        <select class="form-select" id="ticket_user_id" name="ticket_user_id">
          <?php foreach ($ticketUsers as $ticketUser) : ?>
            <option value="<?= $ticketUser->id ?>" <?= $abstract->ticket_user_id == $ticketUser->id ? 'selected' : '' ?>><?= $ticketUser->attachment ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('abstractpayments'); ?>" class="btn btn-secondary">Cancel</a>
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