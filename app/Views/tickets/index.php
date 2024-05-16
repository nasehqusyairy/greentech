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
<?php endif ?>
<div class="card">
  <div class="card-body">
    <div class="mb-3">
      <a href="/tickets/create" class="btn btn-primary"><i class="bi bi-plus"></i>New Ticket</a>
    </div>
    <ul class="nav nav-tabs" id="tab">
      <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#available-tab-pane" type="button">Available</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#deleted-tab-pane" type="button">Deleted</button>
      </li>
    </ul>
    <div class="tab-content" id="tabContent">
      <div class="tab-pane fade show active" id="available-tab-pane">
        <div class="table-responsive">
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
                <th>Actions</th>
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
                  <td><?= $ticket->currency . ' ' . $ticket->price ?></td>
                  <td>
                    <a href="/tickets/edit/<?= $ticket->id ?>" class="btn btn-warning mb-1"><i class="bi bi-pencil"></i></a>
                    <button onclick="handleDelete('<?= $ticket->id; ?>')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
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
                <th>Name</th>
                <th>Attendence</th>
                <th>Type</th>
                <th>Role</th>
                <th>State</th>
                <th>Study</th>
                <th>Price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($deleted as $ticket) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $ticket->name ?></td>
                  <td><?= $ticket->attendance ?></td>
                  <td><?= $ticket->ttype->name ?></td>
                  <td><?= $ticket->trole->name ?></td>
                  <td><?= $ticket->state->name ?></td>
                  <td><?= $ticket->study->name ?></td>
                  <td><?= $ticket->currency . ' ' . $ticket->price ?></td>
                  <td>
                    <a href="<?= base_url('tickets/restore/' . $ticket->id); ?>" class="btn btn-secondary">
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
  const handleDelete = (id) => document.querySelector('#deleteModal .modal-footer a').href = '<?= base_url(); ?>' + 'tickets/delete/' + id;
  // DataTables
  const table = new DataTable('#available');
  const table_deleted = new DataTable('#deleted');
</script>
<?php
$this->endSection();
?>