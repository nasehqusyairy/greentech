<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');
?>
<?php
if (!empty($message)) : ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $message ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>
<div class="card">
  <div class="card-body">
    <div class="d-flex flex-wrap gap-2 mb-3">
      <div>
        <a href="<?= base_url('users/create'); ?>" class="btn btn-primary"><i class="bi bi-plus"></i>New User</a>
      </div>
      <div>
        <form class="dropdown btn-group" id="columnForm">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <i class="bi bi-columns"></i> More Columns
          </button>
          <ul class="dropdown-menu">
            <li>
              <label class="dropdown-item">
                <input type="checkbox" class="form-check-input"> Phone
              </label>
            </li>
            <li>
              <label class="dropdown-item">
                <input type="checkbox" class="form-check-input"> Country
              </label>
            </li>
            <li>
              <label class="dropdown-item">
                <input type="checkbox" class="form-check-input"> Institution
              </label>
            </li>
          </ul>
        </form>
      </div>
      <div>
        <a href="<?= base_url('users/export'); ?>" class="btn btn-secondary"> <i class="bi bi-download"></i> Export</a>
      </div>
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
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
                <th>Institution</th>
                <th>Gender</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // $countries = json_decode(file_get_contents('https://restcountries.com/v3.1/all?fields=name,cca2'));
              $i = 1;
              foreach ($users as $user) :
                // lewati apabila kode role user = 0
                if ($user->role->code == 0) continue;
                // $country = array_values(array_filter($countries, fn ($c) => $c->cca2 == strtoupper($user->country)));
                // $country = !empty($country) ? $country[0]->name->common : '-';
                $country = !empty($user->country) ? strtoupper($user->country) : '-';
              ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td>
                    <img loading="lazy" src="<?= $user->image ? $user->image : base_url('assets/img/person-circle.svg') ?>" alt="<?= $user->name ?>" class="rounded-circle" width="50" height="50">
                  </td>
                  <td><?= $user->name ?></td>
                  <td><?= $user->email ?></td>
                  <td><?= $user->phone ? $user->callingcode . $user->phone : '-' ?></td>
                  <td><?= $country ?></td>
                  <td><?= $user->institution ?? '-' ?></td>
                  <td><?= gender($user->gender) ?></td>
                  <td><?= $user->role->name ?></td>
                  <td><?= badge($user->isActive ? 'Active' : 'Inactive', $user->isActive ? 'success' : 'danger') ?></td>
                  <td>
                    <a href="<?= base_url('users/edit/' . $user->id); ?>" class="btn btn-warning mb-1"><i class="bi bi-pencil"></i></a>
                    <button class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="handleDelete(<?= $user->id ?>)"><i class="bi bi-trash"></i></button>
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
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
                <th>Institution</th>
                <th>Gender</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($deleted as $user) :
                if ($user->role->code == 0) continue;
                // $country = array_values(array_filter($countries, fn ($c) => $c->cca2 == strtoupper($user->country)));
                // $country = !empty($country) ? $country[0]->name->common : '-';
                $country = !empty($user->country) ? strtoupper($user->country) : '-';
              ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td>
                    <img loading="lazy" src="<?= $user->image ? $user->image : base_url('assets/img/person-circle.svg') ?>" alt="<?= $user->name ?>" class="rounded-circle" width="50" height="50">
                  </td>
                  <td><?= $user->name ?></td>
                  <td><?= $user->email ?></td>
                  <td><?= $user->phone ? $user->callingcode . $user->phone : '-' ?></td>
                  <td><?= $country ?></td>
                  <td><?= $user->institution ?? '-' ?></td>
                  <td><?= gender($user->gender) ?></td>
                  <td><?= $user->role->name ?></td>
                  <td><?= badge($user->isActive ? 'Active' : 'Inactive', $user->isActive ? 'success' : 'danger') ?></td>
                  <td>
                    <a href="<?= base_url('users/restore/' . $user->id); ?>" class="btn btn-secondary"><i class="bi bi-arrow-repeat"></i></a>
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
  const showColumns = (tableId) => {
    const columnForm = document.getElementById('columnForm');
    const checkboxes = columnForm.querySelectorAll('input[type=checkbox]');
    const table = document.getElementById(tableId);

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const columnName = this.parentNode.textContent.trim();
        const columnIndex = Array.from(columnForm.children).indexOf(this.parentNode);
        const headerCells = table.querySelectorAll('thead th');
        let targetIndex = -1;

        // Cari indeks kolom yang sesuai dengan teks label checkbox
        headerCells.forEach((cell, index) => {
          if (cell.textContent.trim() === columnName) {
            targetIndex = index;
            return;
          }
        });

        if (targetIndex !== -1) {
          const cells = table.querySelectorAll(`tr > *:nth-child(${targetIndex + 1})`);
          cells.forEach(cell => {
            cell.style.display = this.checked ? '' : 'none';
          });
        }
      });

      // Inisialisasi: sembunyikan kolom yang bersangkutan
      const columnName = checkbox.parentNode.textContent.trim();
      const columnIndex = Array.from(columnForm.children).indexOf(checkbox.parentNode);
      const headerCells = table.querySelectorAll('thead th');
      let targetIndex = -1;

      headerCells.forEach((cell, index) => {
        if (cell.textContent.trim() === columnName) {
          targetIndex = index;
          return;
        }
      });

      if (targetIndex !== -1) {
        const cells = table.querySelectorAll(`tr > *:nth-child(${targetIndex + 1})`);
        cells.forEach(cell => {
          cell.style.display = 'none';
        });
      }
    });
  }
  showColumns('available');
  showColumns('deleted');
</script>
<script>
  const handleDelete = (id) => document.querySelector('#deleteModal .modal-footer a').href = '<?= base_url(); ?>' + 'users/delete/' + id;
  // DataTables
  const table1 = new DataTable('#available');
  const table_deleted = new DataTable('#deleted');

  document.querySelectorAll('colgroup').forEach(col => col.remove());
</script>
<?php
$this->endSection();
?>