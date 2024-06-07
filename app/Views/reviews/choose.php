<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');
?>
<div class="card">
  <div class="card-body">
    <form>
      <select name="abstrac_id" id="abstrac_id" class="form-select">
        <option value="">Choose...</option>
        <?php foreach ($abstracs as $abstrac) : ?>
          <option value="<?= $abstrac->id ?>"><?= $abstrac->title ?></option>
        <?php endforeach; ?>
      </select>
      <div class="d-grid d-lg-block gap-2 mt-3">
        <a id="goto" href="javascript:void(0)" class="btn btn-primary">Go</a>
      </div>
    </form>
  </div>
</div>

<?php
$this->endSection();
$this->section('footer');
?>
<script>
  $('#abstrac_id').change(function() {
    $('#goto').attr('href', '<?= base_url('reviews/?abstract_id=') ?>' + $(this).val());
  })
  // select2
  $('#abstrac_id').select2({
    theme: 'bootstrap-5',
    width: '100%'
  });
</script>
<?php $this->endSection() ?>