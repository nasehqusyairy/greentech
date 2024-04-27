<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Photo</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Country</th>
      <th>Institution</th>
      <th>Gender</th>
      <th>Role</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $countries = json_decode(file_get_contents('https://restcountries.com/v3.1/all?fields=name,cca2'));
    $i = 1;
    foreach ($users as $user) :
      // lewati apabila kode role user = 0
      if ($user->role->code == 0) continue;
      $country = array_values(array_filter($countries, fn ($c) => $c->cca2 == strtoupper($user->country)));
      $country = !empty($country) ? $country[0]->name->common : '-';
    ?>
      <tr>
        <td><?= $i++; ?></td>
        <td>
          <img src="<?= $user->image ? $user->image : base_url('assets/img/person-circle.svg') ?>" alt="<?= $user->name ?>" class="rounded-circle" width="50" height="50">
        </td>
        <td><?= $user->name ?></td>
        <td><?= $user->email ?></td>
        <td><?= $user->phone ? $user->callingcode . $user->phone : '-' ?></td>
        <td><?= $country ?></td>
        <td><?= $user->institution ?? '-' ?></td>
        <td><?= gender($user->gender) ?></td>
        <td><?= $user->role->name ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>