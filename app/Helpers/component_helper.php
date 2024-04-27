<?php
function badge($text, $color): string
{
  return "<span class='badge text-bg-$color'>$text</span>";
}

function genderOptions()
{
  $genders = [
    ['id' => 0, 'name' => 'Don\'t want to specify'],
    ['id' => 1, 'name' => 'Male'],
    ['id' => 2, 'name' => 'Female']
  ];
  foreach ($genders as $gender) : ?>
    <option value="<?= $gender['id']; ?>" <?= $gender['id'] == old('gender') ? 'selected' : '' ?>><?= $gender['name']; ?></option>
<?php endforeach;
}
