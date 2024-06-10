<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');

?>
<?php
if (!empty($message)) : ?>
  <div class="alert alert-success alert-dismissible fade show">
    <?= $message ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif;

if (session()->has('messages')) :  
?>
  <?php if (!empty(session('messages')['error'])) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session('messages')['error'] ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  <?php if (!empty(session('messages')['success'])) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session('messages')['success'] ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  
<?php endif ?>

<div class="card">
  <div class="card-body">
    <div class="mb-3">
      <?php if($user->role->code == '3') : ?>
      <a href="/conferencepayments/create" class="btn btn-primary"><i class="bi bi-plus"></i>New Payment</a>
      <?php endif ?>
    </div>
    <ul class="nav nav-tabs" id="tab">
      <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#available-tab-pane" type="button">Available</button>
      </li>
    </ul>
    <div class="tab-content" id="tabContent">
      <div class="tab-pane fade show active" id="available-tab-pane">
        <div class="table-responsive">
          <table class="table table-striped table-hover w-100" id="available">
            <thead>
              <tr>
                <th>#</th>
                <th>Created At</th>
                <th>Name</th>
                <th>Ticket</th>
                <th>Proof</th>
                <th>Attachment</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($ticketUsers as $ticketUser) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $ticketUser->created_at ?></td>
                  <td><?= $ticketUser->user->name ?></td>
                  <td><?= $ticketUser->ticket->name ?></td>
                  <td>
                    <a href="<?= $ticketUser->proof ?>" download class="btn btn-primary">
                      <i class="bi bi-download"></i>
                    </a>
                  </td>
                  <td>
                    <a href="<?= $ticketUser->attachment ?>" download class="btn btn-primary">
                      <i class="bi bi-person-vcard"></i>
                    </a>
                  </td>
                  <td>
                    <?= badge($ticketUser->status->text, $ticketUser->status->color) ?>
                  </td>
                  <td>
                    <?php if ($user->role->code == '0' || $user->role->code == '1') : ?>
                      <a href="/conferencepayments/confirm/<?= $ticketUser->id ?>" class="btn btn-primary mb-1"><i class="bi bi-check-all"></i></a>
                    <?php endif; ?>
                    <a href="/conferencepayments/edit/<?= $ticketUser->id ?>" title="Edit" class="btn btn-warning mb-1"><i class="bi bi-pencil"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this item?</p>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" class="btn btn-danger">Delete</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- END OF DELETE MODAL -->
<?php
$this->endSection();
$this->section('footer');
?>
<script>
  const handleDelete = (id) => document.querySelector('#deleteModal .modal-footer a').href = '<?= base_url(); ?>' + 'conferencepayments/delete/' + id;
  // DataTables
  const table = new DataTable('#available');
  const table_deleted = new DataTable('#deleted');
</script>
<?php
$this->endSection();
?>