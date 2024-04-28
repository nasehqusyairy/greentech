<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');

if (session()->has('errors')) :
  $errors = session('errors');
?>
  <div class="alert alert-danger alert-dismissible fade show">
    <?php
    if (count($errors) > 1) : ?>
      <ul class="m-0">
        <?php foreach ($errors as $error) : ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else :
      echo array_values($errors)[0];
    endif; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif;

if (session()->has('message')) : ?>
  <div class="alert alert-success alert-dismissible fade show">
    <?= session('message'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<form action="<?= base_url('permissions/addroles/' . $permission->id); ?>" method="post">
  <?= csrf_field(); ?>
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role_id">
          <option value="">Select role</option>
          <?php foreach ($roles as $role) : ?>
            <option value="<?= $role->id; ?>"><?= $role->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Add</button>
        <a href="<?= base_url('permissions'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>
</form>

<div class="card mb-3">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover w-100" id="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Path</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach ($permission->roles as $role) : ?>
            <tr>
              <td><?= $i++; ?></td>
              <td><?= $role->name ?></td>
              <td>
                <a href="javascript:void(0)" onclick="handleDelete('<?= $permission->id; ?>','<?= $role->id; ?>')" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-x"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="alert alert-info alert-dismissible fade show">
  <h5>Notes</h5>
  <ul class="m-0">
    <li>Only users with the selected role can see this permission in the sidebar</li>
    <li>Make sure to specify <a href="<?= base_url('permissions'); ?>">permissions</a> to limit the access</li>
  </ul>
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
        <p>Are you sure you want to <u>permanently</u> delete this item?</p>
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
  $('#role').select2({
    theme: 'bootstrap-5',
    placeholder: 'Select...',
    width: '100%'
  });

  const handleDelete = (permissionId, roleId) => document.querySelector('#deleteModal .modal-footer a').href = '<?= base_url(); ?>' + 'permissions/removerole/' + permissionId + '/' + roleId;

  // DataTable
  const table = new DataTable('#table');
</script>
<?php $this->endSection() ?>