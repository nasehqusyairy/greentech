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

<form action="<?= base_url('conferencepayments/update'); ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="ticket" class="form-label">Ticket</label>
        <select name="ticket_id" id="ticket" class="form-select">
          <option value="">Select Ticket</option>
          <?php foreach ($tickets as $ticket) : ?>
            <option value="<?= $ticket->id; ?>" <?= $ticket->id == old('ticket_id') ? 'selected' : ''; ?>><?= $ticket->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <input type="hidden" name="id" value="<?= old('id', $ticketUser->id) ?>">
      <div class="mb-3">
        <label for="proof" class="form-label">Proof</label>
        <input type="file" name="proof" id="proof" class="form-control">
      </div>
      <div class="mb-3">
        <label for="attachment" class="form-label">Attachment</label>
        <input type="file" name="attachment" id="attachment" class="form-control">
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('conferencepayments'); ?>" class="btn btn-secondary">Cancel</a>
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
  // $('#ticket').select2({
  //   theme: 'bootstrap-5',
  //   width: '100%'
  // });

  $('#status').select2({
    theme: 'bootstrap-5',
    width: '100%'
  });
</script>
<?php $this->endSection() ?>