<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');
?>
<?php if (!empty($message)) : ?>
  <div class="alert alert-success alert-dismissible fade show">
    <?= $message ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>
<div class="card">
  <div class="card-body">
    <div class="mb-3">
      <a href="/abstracs/create" class="btn btn-primary"><i class="bi bi-plus"></i>New Abstract</a>
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
                <th>Topic</th>
                <th>Title</th>
                <th>Reviewer</th>
                <th>File</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($abstracts as $abstract) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $abstract->topic->name ?></td>
                  <td><?= $abstract->title ?></td>
                  <td><?= $abstract->reviewer->name ?? '-' ?></td>
                  <td>
                    <a href="<?= $abstract->file ?>" class="btn btn-primary" download><i class="bi bi-download"></i></a>
                  </td>
                  <td><?= $abstract->status ? badge($abstract->status->text, $abstract->status->color) : badge('Unknown', 'secondary') ?></td>
                  <td class="text-nowrap">
                    <a href="/abstracs/<?= $abstract->id ?>/reviews/" class="btn btn-info mb-1"><i class="bi bi-chat-left-text"></i></a>
                    <a href="/abstracs/edit/<?= $abstract->id ?>" class="btn btn-warning mb-1"><i class="bi bi-pencil"></i></a>
                    <button onclick="handleDelete(<?= $abstract->id; ?>)" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
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
                <th>Topic</th>
                <th>Title</th>
                <th>Reviewer</th>
                <th>File</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($deleted as $abstract) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $abstract->topic->name ?></td>
                  <td><?= $abstract->title ?></td>
                  <td><?= $abstract->reviewer->name ?? '-' ?></td>
                  <td>
                    <a href="<?= $abstract->file ?>" class="btn btn-primary" download><i class="bi bi-download"></i></a>
                  </td>
                  <td><?= $abstract->status ? badge($abstract->status->text, $abstract->status->color) : badge('Unknown', 'secondary') ?></td>
                  <td>
                    <a href="<?= base_url('abstracs/restore/' . $abstract->id); ?>" class="btn btn-secondary">
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