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
      <a href="/submenus/create" class="btn btn-primary"><i class="bi bi-plus"></i>New Submenu</a>
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
                <th>URL</th>
                <th>Code</th>
                <th>Parent</th>
                <th>Icon</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($submenus as $submenu) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $submenu->name ?></td>
                  <td>
                    <a href="<?= $submenu->is_path ? base_url($submenu->url . '/') : $submenu->url ?>"><?= $submenu->is_path ? base_url($submenu->url . '/') : $submenu->url ?></a>
                  </td>
                  <td><?= $submenu->code; ?></td>
                  <td><?= $submenu->menu->name; ?></td>
                  <td>
                    <button class="btn btn-primary">
                      <i class="<?= $submenu->icon ?>"></i>
                    </button>
                  </td>
                  <td>
                    <a href="/submenus/edit/<?= $submenu->id ?>" class="btn btn-warning mb-1"><i class="bi bi-pencil"></i></a>
                    <button onclick="handleDelete(<?= $submenu->id; ?>)" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
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
                <th>URL</th>
                <th>Code</th>
                <th>Parent</th>
                <th>Icon</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($deleted as $submenu) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $submenu->name ?></td>
                  <td>
                    <a href="<?= $submenu->is_path ? base_url($submenu->url . '/') : $submenu->url ?>"><?= $submenu->is_path ? base_url($submenu->url . '/') : $submenu->url ?></a>
                  </td>
                  <td><?= $submenu->code; ?></td>
                  <td><?= $submenu->menu->name; ?></td>
                  <td>
                    <button class="btn btn-primary">
                      <i class="bi bi-<?= $submenu->icon ?>"></i>
                    </button>
                  </td>
                  <td>
                    <a href="<?= base_url('submenus/restore/' . $submenu->id); ?>" class="btn btn-secondary">
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
  const handleDelete = (id) => document.querySelector('#deleteModal .modal-footer a').href = '<?= base_url(); ?>' + 'submenus/delete/' + id;
  // DataTables
  const table = new DataTable('#available');
  const table_deleted = new DataTable('#deleted');
</script>
<?php
$this->endSection();
?>