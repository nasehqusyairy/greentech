<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');
$user = $user->role->code;
?>
<?php if (!empty($message)): ?>
  <div class="alert alert-success alert-dismissible fade show">
    <?= $message ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<div class="card">
  <div class="card-body">
    <?php if ($user == '1' || $user == '2'): ?>
      <div class="mb-3">
        <a href="/abstracs/create" class="btn btn-primary"><i class="bi bi-plus"></i>New Abstract</a>
      </div>
    <?php endif ?>

    <ul class="nav nav-tabs" id="tab">
      <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#available-tab-pane"
          type="button">Available</button>
      </li>
      <?php //if ($user == '0' || $user == '1'): ?>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#deleted-tab-pane" type="button">Deleted</button>
        </li>
      <?php //endif ?>
    </ul>
    <div class="tab-content" id="tabContent">
      <div class="tab-pane fade show active" id="available-tab-pane">
        <div class="table-responsive">
          <table class="table table-striped table-hover w-100" id="available">
            <thead>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Ticket</th>
                <th>File</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($ticketUsers as $ticketUser): ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $ticketUser->abstrac->title ?></td>
                  <td><?= $ticketUser->ticket->name ?></td>
                  <td>
                    <a href="<?= $ticketUser->file ?>" title="Download" class="btn btn-primary" download><i
                        class="bi bi-download"></i></a>
                  </td>
                  <td>
                    <?= $ticketUser->status ? badge($ticketUser->status->text, $ticketUser->status->color) : badge('Unknown', 'secondary') ?>
                  </td>
                  <td class="text-nowrap">
                    <?php //if ($user == '3'): ?>
                      <a href="/abstractpayments/pay/<?= $ticketUser->id ?>" title="Edit" class="btn btn-primary mb-1"><i
                          class="bi bi-wallet2"></i></a>
                    <?php //endif ?>
                    <?php //if ($user == '1' || $user == '2'): ?>
                      <button onclick="handleDelete(<?= $ticketUser->id; ?>)" title="Delete" class="btn btn-danger"
                        data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
                    <?php //endif ?>

                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="deleted-tab-pane">
        <div class="table-responsive">
          <table class="table table-striped table-hover w-100" id="deleted">
            <thead>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Ticket</th>
                <th>File</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($deleted as $ticketUser): ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $ticketUser->abstrac->title ?></td>
                  <td><?= $ticketUser->ticket->name ?></td>
                  <td>
                    <a href="<?= $ticketUser->file ?>" class="btn btn-primary" download><i class="bi bi-download"></i></a>
                  </td>
                  <td>
                    <?= $ticketUser->status ? badge($ticketUser->status->text, $ticketUser->status->color) : badge('Unknown', 'secondary') ?>
                  </td>
                  <td>
                    <a href="<?= base_url('abstracs/restore/' . $ticketUser->id); ?>" title="Restore"
                      class="btn btn-secondary">
                      <i class="bi bi-arrow-repeat"></i>
                    </a>
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
  const handleDelete = (id) => document.querySelector('#deleteModal .modal-footer a').href = '<?= base_url(); ?>' + 'abstracs/delete/' + id;
  // DataTables
  const table = new DataTable('#available');
  const table_deleted = new DataTable('#deleted');
</script>
<?php
$this->endSection();
?>