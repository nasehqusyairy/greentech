<?php


/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('components/layout');
$this->section('content');

$name = old('name') ?? $user->name;
$email = old('email') ?? $user->email;
$phone = old('phone') ?? $user->phone;
$institution = old('institution') ?? $user->institution;
$role_id = old('role_id') ?? $user->role_id;
$callingcode = old('callingcode') ?? $user->callingcode;
$institution = old('institution') ?? $user->institution;
$image = $user->image ?? base_url('assets/img/person-circle.svg');

$gender = old('gender') ?? 0;
$country = old('country') ?? 'id';

if (session()->has('errors')) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="m-0">
      <?php foreach (session('errors') as $error) : ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<form action="<?= base_url('users/update'); ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $user->id; ?>">
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $name; ?>">
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Photo</label>
        <input class="form-control" type="file" id="image" name="image">
      </div>
      <img src="<?= $image; ?>" id="image-preview" alt="Placeholder Image" width="100" class="img-thumbnail mb-3">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $email; ?>">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="<?= old('password'); ?>">
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?= old('confirm_password'); ?>">
      </div>
      <div class="mb-3">
        <label for="country" class="form-label">Country</label>
        <select class="form-select" id="country" name="country">
          <option value="" disabled selected>Select...</option>
        </select>
      </div>
      <input type="hidden" name="callingcode" id="callingcode" value="<?= $callingcode; ?>">
      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <div class="input-group">
          <span class="input-group-text" id="phone-addon"><?= $callingcode; ?></span>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="81234567890" value="<?= $phone ?>">
        </div>
      </div>
      <div class="mb-3">
        <label for="institution" class="form-label">Institution</label>
        <input type="text" class="form-control" id="institution" name="institution" value="<?= $institution ?>">
      </div>
      <div class="mb-3">
        <label for="gender" class="form-label">Gender</label>
        <select class="form-select" id="gender" name="gender">
          <?php genderOptions() ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role_id">
          <?php foreach ($roles as $role) : ?>
            <option value="<?= $role->id; ?>" <?= $role->id == $role_id ? 'selected' : '' ?>><?= $role->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="d-grid d-lg-block gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('users/index'); ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </div>
  </div>

</form>

<?php $this->endSection() ?>

<?php $this->section('footer'); ?>
<script>
  const server = {
    gender: '<?= $gender ?>',
    country: '<?= $country ?>',
  }
  $('#role').select2({
    theme: 'bootstrap-5',
    placeholder: 'Select...',
    width: '100%'
  });
</script>
<script src="<?= base_url('assets/js/profile-form.js'); ?>"></script>
<?php $this->endSection() ?>