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

<form action="<?= base_url('tickets/update'); ?>" method="post">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $ticket->id; ?>">
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $ticket->name); ?>">
      </div>
      <div class="mb-3">
        <label for="attendance" class="form-label">Attendance</label>
        <select name="attendance" id="attendance" class="form-select">
          <option value="offline" <?= old('attendance', $ticket->attendance) == 'offline' ? 'selected' : ''; ?>>Offline</option>
          <option value="online" <?= old('attendance', $ticket->attendance) == 'online' ? 'selected' : ''; ?>>Online</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="ttype_id" class="form-label">Type</label>
        <select name="ttype_id" id="ttype_id" class="form-select">
          <?php foreach ($ttypes as $ttype) : ?>
            <option value="<?= $ttype->id ?>" <?= old('ttype_id', $ticket->ttype_id) == $ttype->id ? 'selected' : ''; ?>><?= $ttype->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="trole_id" class="form-label">Role</label>
        <select name="trole_id" id="trole_id" class="form-select">
          <?php foreach ($troles as $trole) : ?>
            <option value="<?= $trole->id ?>" <?= old('trole_id', $ticket->trole_id) == $trole->id ? 'selected' : ''; ?>><?= $trole->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="state_id" class="form-label">State</label>
        <select name="state_id" id="state_id" class="form-select">
          <?php foreach ($states as $state) : ?>
            <option value="<?= $state->id ?>" <?= old('state_id', $ticket->state_id) == $state->id ? 'selected' : ''; ?>><?= $state->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="study_id" class="form-label">Study</label>
        <select name="study_id" id="study_id" class="form-select">
          <?php foreach ($studies as $study) : ?>
            <option value="<?= $study->id ?>" <?= old('study_id', $ticket->study_id) == $study->id ? 'selected' : ''; ?>><?= $study->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" value="<?= old('price', $ticket->price); ?>">
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('tickets'); ?>" class="btn btn-secondary">Cancel</a>
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
  const options = {
    theme: 'bootstrap-5',
    width: '100%'
  };
  $('#attendance').select2(options);
  $('#ttype_id').select2(options);
  $('#trole_id').select2(options);
  $('#state_id').select2(options);
  $('#study_id').select2(options);
</script>
<?php $this->endSection() ?>