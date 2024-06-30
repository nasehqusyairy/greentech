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

<form action="<?= base_url('conferencepayments/store'); ?>" method="post" enctype="multipart/form-data">
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
      <div class="mb-3">
        <label for="proof" class="form-label">Proof</label>
        <input type="file" name="proof" id="proof" class="form-control">
      </div>
      <div class="mb-3">
        <label for="attachment" class="form-label">Attachment</label>
        <input type="file" name="attachment" id="attachment" class="form-control">
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button onsubmit="loadingButton(event)" type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('conferencepayments'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>

</form>

<div class="card">
  <div class="card-body">
    <h5>Available Ticket Details</h5>
    <table class="table table-striped table-hover w-100" id="available">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Attendence</th>
          <th>Type</th>
          <th>Role</th>
          <th>State</th>
          <th>Study</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        foreach ($tickets as $ticket) : ?>
          <tr>
            <td><?= $i++; ?></td>
            <td><?= $ticket->name ?></td>
            <td><?= $ticket->attendance ?></td>
            <td><?= $ticket->ttype->name ?></td>
            <td><?= $ticket->trole->name ?></td>
            <td><?= $ticket->state->name ?></td>
            <td><?= $ticket->study->name ?></td>
            <td>Rp. <?= $ticket->price ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
$this->endSection();
$this->section('footer');
?>
<script>
  const table = new DataTable('#available');

  // select2
  $('#ticket').select2({
    theme: 'bootstrap-5',
    width: '100%'
  });

  $('#status').select2({
    theme: 'bootstrap-5',
    width: '100%'
  });
</script>
<?php $this->endSection() ?>