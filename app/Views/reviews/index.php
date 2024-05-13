<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('header');
?>
<style>
  table tbody tr td:nth-child(4) {
    max-width: 50vmin;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  /* media query on lg */
  @media (min-width: 992px) {
    table tbody tr td:nth-child(4) {
      max-width: unset;
      white-space: unset;
    }
  }
</style>
<?php
$this->endSection();
$this->section('content');
?>

<?php if (!empty($message)) : ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $message ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<div class="card">
  <div class="card-body">
    <div class="mb-3">
      <a href="<?= base_url("abstracs/$abstract_id/reviews/create"); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> New Review</a>
    </div>
    <ul class="nav nav-tabs" id="tab">
      <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#available-tab-pane" type="button">Available</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#deleted-tab-pane" type="button">Deleted</button>
      </li>
    </ul>
    <!-- tab contents -->
    <div class="tab-content" id="tabContent">
      <div class="tab-pane fade show active" id="available-tab-pane">
        <div class="table-responsive">
          <table class="table table-striped table-hover w-100" id="reviewsTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Comment</th>
                <th>File</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($reviews as $review) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $review->created_at ?></td>
                  <td><?= $review->updated_at ?? $review->created_at ?></td>
                  <td>
                    <?= $review->comment ?>
                  </td>
                  <td>
                    <a href="<?= $review->file ?>" class="btn btn-primary" download><i class="bi bi-download"></i></a>
                  </td>
                  <td><?= badge($review->status->text, $review->status->color) ?></td>
                  <td class="text-nowrap">
                    <a href="edit/<?= $review->id ?>" class="btn btn-warning mb-1"><i class="bi bi-pencil"></i></a>
                    <button onclick="handleDelete(<?= $review->id; ?>)" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
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
                <th>Created At</th>
                <th>Updated At</th>
                <th>Comment</th>
                <th>File</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($deleted as $review) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $review->created_at ?></td>
                  <td><?= $review->updated_at ?? $review->created_at ?></td>
                  <td>
                    <?= $review->comment ?>
                  </td>
                  <td>
                    <a href="<?= $review->file ?>" class="btn btn-primary" download><i class="bi bi-download"></i></a>
                  </td>
                  <td><?= badge($review->status->text, $review->status->color) ?></td>
                  <td>
                    <a href="<?= base_url('abstracs/' . $abstract_id . '/reviews/restore/' . $review->id); ?>" class="btn btn-secondary">
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
  const handleDelete = (id) => document.querySelector('#deleteModal .modal-footer a').href = '<?= base_url(); ?>' + 'abstracs/<?= $abstract_id; ?>/reviews/delete/' + id;
  // DataTables
  const table = new DataTable('#reviewsTable');
  const table_deleted = new DataTable('#deleted');
  // delete colgroup element
  document.querySelectorAll('colgroup').forEach(e => e.remove());
  // select2
  $('#status').select2({
    theme: 'bootstrap-5',
    width: '100%'
  });
</script>
<?php
$this->endSection();
?>