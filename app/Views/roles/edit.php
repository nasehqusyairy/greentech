<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');
$name = !old('name') ? $role['name'] : old('name');
?>

<?php if (session()->has('errors')) : ?>
  <ul>
    <?php foreach (session('errors') as $error) : ?>
      <li><?= $error ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<form action="/roles/update/" method="post">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= current_url(true)->getSegment(3); ?>">
  <label for="name">Name</label>
  <input type="text" name="name" id="name" value="<?= $name; ?>">
  <br>
  <button type="submit">Submit</button>

</form>
<?= $this->endSection() ?>