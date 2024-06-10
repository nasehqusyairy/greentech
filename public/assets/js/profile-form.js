// allow only number input
document.getElementById('phone').addEventListener('input', function (event) {
  this.value = this.value.replace(/\D/g, '');
});

// set value to gender select field
document.getElementById('gender').querySelector(`option[value="${server.gender}"]`).setAttribute('selected', true);

// Init select2 on gender select field
$('#gender').select2({
  theme: 'bootstrap-5',
  width: '100%'
});

// Fetch countries data
// const url = 'https://restcountries.com/v3.1/all?fields=name,cca2,idd'
// fetch(url)
//   .then(response => response.json())
//   .then(data => {

const transformedData = [];
const selectedCountry = server.country.toUpperCase();

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
  width: '100%'
});

// Set default value
// countrySelectField.val('+62').trigger('change');

// Set phone add-on onchange
countrySelectField.change(function () {
  const callingcode = transformedData.find(country => country.cca2 === this.value).callingcode;
  $('#phone-addon').text(callingcode);
  $('#callingcode').val(callingcode);
});

const callingcode = transformedData.find(country => country.cca2 === selectedCountry).callingcode;
$('#phone-addon').text(callingcode);
$('#callingcode').val(callingcode);

// })

// Image preview
document.getElementById('image').addEventListener('change', function (event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();

    reader.onload = function (event) {
      const img = new Image();
      img.src = event.target.result;

      img.onload = function () {
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
  } else {
    document.getElementById('image-preview').src = '/assets/img/person-circle.svg';
  }
});