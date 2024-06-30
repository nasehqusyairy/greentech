<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');
// dd($abstract->toArray());
?>

<div class="card">
  <div class="card-body">
    <h3 class="card-title"><?= $abstract->title ?></h3>
    <p class="text-muted">Submitted by <b><?= $abstract->creator->name; ?></b> at <b><?= $abstract->created_at; ?></b></p>

    <hr>
    <div class="row">
      <div class="col-12 col-lg-8">

        <p>
          <a href="<?= base_url('/abstracs'); ?>" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
          <a href="<?= $abstract->file; ?>" class="btn btn-primary"><i class="bi bi-download"></i> Download</a>
        </p>

        <h5>Topic</h5>
        <p><?= $abstract->topic->name; ?></p>

        <h5>Abstract</h5>
        <p class="text-justify">
          <?= $abstract->text; ?>
        </p>
      </div>
      <div class="col border-start">
        <h6>Status</h6>
        <p>
          <?= badge($abstract->status->text, $abstract->status->color); ?>
          <?= $abstract->ticketUser ? badge($abstract->ticketUser->status->text, $abstract->ticketUser->status->color) : ''; ?>
        </p>
        <hr>

        <h6>Reviewer</h6>
        <p>
          <?= $abstract->reviewer ? $abstract->reviewer->name : 'No reviwer yet'; ?>
        </p>
        <hr>

        <h6>Authors</h6>
        <ul>
          <?php foreach (explode(',', $abstract->authors) as $author) : ?>
            <li><?= trim($author); ?></li>
          <?php endforeach; ?>
        </ul>
        <hr>

        <h6>Emails</h6>
        <ul>
          <?php foreach (explode(',', $abstract->emails) as $email) : ?>
            <li>
              <a href="mailto:<?= trim($email); ?>"><?= trim($email); ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>