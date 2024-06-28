<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');
?>

<?php
if (session()->has('errors')) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="m-0">
      <?php foreach (session('errors') as $error) : ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif;

if (!empty($message)) : ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $message ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<form action="<?= base_url('systems/update'); ?>" method="post">
  <?= csrf_field(); ?>

  <!-- SWITCHES -->
  <div class="card mb-3">
    <div class="card-body">
      <div class="list-group mb-3">
        <?php foreach ($settings as $setting) : ?>
          <label class="list-group-item d-flex justify-content-between form-check form-switch">
            <span>
              <?= $setting->title ?>
              <small class="d-block text-body-secondary"><?= $setting->description ?? '-' ?></small>
            </span>
            <input class="form-check-input flex-shrink-0" type="checkbox" role="switch" name="settings[<?= $setting->id ?>]" value="1" <?= ($setting->value == 1) ? 'checked' : '' ?>>
          </label>
        <?php endforeach; ?>
      </div>
      <div class="text-end d-grid d-lg-block gap-2">
        <button onsubmit="loadingButton(event)" type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
  <!-- END OF SWITCHES -->

</form>


<?= $this->endSection() ?>