<?php

/**
 * @var CodeIgniter\View\View $this
 */

use App\Models\User;

$user = User::find(session('user'));
// dd(session()->get('user'));
$name = old('name') ?? $user->name;
$phone = old('phone') ?? $user->phone;
$institution = old('institution') ?? $user->institution;
$gender = old('gender') ?? $user->gender;
$img = $user->image ?? base_url('assets/img/person-circle.svg');
$country = old('country') ?? $user->country;
$callingcode = old('callingcode') ?? $user->callingcode;

$this->extend('components/layout');
$this->section('content');
if (!empty($message)) :
?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
<?php if (session()->has('errors')) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="m-0">
      <?php foreach (session('errors') as $error) : ?>
        <li><?= $error; ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
<form action="<?= base_url('profile/update/'); ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <input type="hidden" name="id" value="<?= $user->id; ?>">
  <div class="row flex-lg-row-reverse align-items-center">
    <div class="col-12 col-lg-4">
      <div class="card mb-3">
        <div class="card-body">
          <img src="<?= $img; ?>" id="image-preview" alt="PROFILE PICTURE" class="img-fluid w-100 img-thumbnail mb-3">
          <label for="image" class="form-label">Profile Picture</label>
          <input class="form-control" type="file" id="image" name="image">
        </div>
      </div>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">More</h5>
          <ul>
            <li><a href="./change-email.html">Change Email</a></li>
            <li> <a href="<?= base_url('auth/forgot'); ?>">Reset Password</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg">
      <div class="card mb-3">
        <div class="card-body">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $user->email; ?>" disabled>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $name; ?>">
          </div>
          <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" id="country" name="country" value="<?= $country; ?>">
              <option value="" disabled selected>Select...</option>
            </select>
          </div>
          <input type="hidden" name="callingcode" id="callingcode" value="<?= $callingcode; ?>">
          <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <div class="input-group">
              <span class="input-group-text" id="phone-addon"><?= $callingcode; ?></span>
              <input type="text" class="form-control" id="phone" name="phone" placeholder="81234567890" value="<?= $phone; ?>">
            </div>
          </div>
          <div class="mb-3">
            <label for="institution" class="form-label">Institution</label>
            <input type="text" class="form-control" id="institution" name="institution" value="<?= $institution; ?>">
          </div>
          <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender" value="<?= $gender; ?>">
              <option value="">Select...</option>
              <option value="0">Don't want to specify</option>
              <option value="1">Male</option>
              <option value="2">Female</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <!-- select -->
            <select class="form-select" id="role" name="role_id">
              <?php foreach ($roles as $role) : ?>
                <option value="<?= $role->id; ?>" <?= $role->id == $user->role_id ? 'selected' : ''; ?>><?= $role->name; ?></option>
              <?php endforeach  ?>
            </select>
          </div>
          <div class="d-grid d-lg-block gap-2">
            <button class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</form>

<?php $this->endSection() ?>

<?php $this->section('footer'); ?>
<script>
  const server = {
    gender: '<?= $gender; ?>',
    country: '<?= $country; ?>',
  }
  // select2 role
  $('#role').select2({
    theme: 'bootstrap-5',
    width: '100%'
  });
</script>
<script src="<?= base_url('assets/js/profile-form.js'); ?>"></script>
<?php $this->endSection() ?>