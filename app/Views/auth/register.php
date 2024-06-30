<?php

/**
 * @var CodeIgniter\View\View $this
 */
$this->extend('auth/layout');
$this->section('content');
$name = old('name', $user['name']);
$email = old('email', $user['email']);
$callingcode = old('callingcode');
$gender = old('gender' . $user['gender']);
$country = old('country' . $user['country']);
$institution = old('institution');
$phone = old('phone');
// dd(session('errors'));
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card my-3">
      <div class="card-body">
        <h3 class="text-center">Sign Up</h3>
        <?php if (session()->has('errors')) : ?>
          <div class="alert alert-danger" role="alert">
            <ul>
              <?php foreach (session('errors') as $error) : ?>
                <li><?= $error ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <form action="<?= base_url('auth/store'); ?>" method="post">
          <?= csrf_field(); ?>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
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
                <option value="<?= $role->id; ?>"><?= $role->name; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <button onsubmit="loadingButton(event)" type="submit" class="btn btn-primary w-100 mb-3">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('footer'); ?>
<script>
  const server = {
    gender: '<?= $gender; ?>',
    country: '<?= $country; ?>',
  }

  const data = <?= json_encode(countries()); ?>;
  // select2 role
  $('#role').select2({
    theme: 'bootstrap-5',
    width: '100%'
  });
</script>
<script src="<?= base_url('assets/js/profile-form.js'); ?>"></script>
<?php $this->endSection() ?>