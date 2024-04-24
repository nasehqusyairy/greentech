<?php

/**
 * @var CodeIgniter\View\View $this
 * @var App\Models\User $user
 */
$user = user();
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
  // allow only number input
  document.getElementById('phone').addEventListener('input', function(event) {
    this.value = this.value.replace(/\D/g, '');
  });

  // set value to gender select field
  document.getElementById('gender').querySelector(`option[value="<?= $gender; ?>"]`).setAttribute('selected', true);

  // Init select2 on gender select field
  $('#gender').select2({
    theme: 'bootstrap-5',
    placeholder: 'Select...',
    width: '100%'
  });

  // Fetch countries data
  const url = 'https://restcountries.com/v3.1/all?fields=name,cca2,idd'
  fetch(url)
    .then(response => response.json())
    .then(data => {

      const transformedData = [];
      const selectedCountry = '<?= $country; ?>'.toUpperCase();

      data.forEach(entry => {
        entry.idd.suffixes.forEach(suffix => {
          transformedData.push({
            cca2: entry.cca2,
            name: entry.name.common,
            callingcode: entry.idd.root + suffix
          });
        });
      });

      transformedData.sort((a, b) => a.name.localeCompare(b.name))
        .map(country => {
          const option = document.createElement('option');
          option.value = country.cca2;
          option.textContent = `${country.name} (${country.callingcode})`;
          if (country.cca2 === selectedCountry) option.selected = true;
          document.getElementById('country').appendChild(option);
        });

      const countrySelectField = $('#country')

      countrySelectField.select2({
        theme: 'bootstrap-5',
        placeholder: 'Select...',
        width: '100%'
      });

      // Set default value
      // countrySelectField.val('+62').trigger('change');

      // Set phone add-on onchange
      countrySelectField.change(function() {
        const callingcode = transformedData.find(country => country.cca2 === this.value).callingcode;
        $('#phone-addon').text(callingcode);
        $('#callingcode').val(callingcode);
      });

    })

  // Image preview
  document.getElementById('image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(event) {
      const img = new Image();
      img.src = event.target.result;

      img.onload = function() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const maxSize = Math.min(img.width, img.height);

        canvas.width = maxSize;
        canvas.height = maxSize;

        const offsetX = (img.width - maxSize) / 2;
        const offsetY = (img.height - maxSize) / 2;

        ctx.drawImage(img, offsetX, offsetY, maxSize, maxSize, 0, 0, maxSize, maxSize);

        const croppedUrl = canvas.toDataURL(file.type);
        document.getElementById('image-preview').src = croppedUrl;
      };
    };

    reader.readAsDataURL(file);
  });
</script>
<?php $this->endSection() ?>