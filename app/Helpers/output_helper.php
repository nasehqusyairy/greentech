<?php
function gender(int $gender): string
{
  return $gender === 0 ? "Don't want to specify" : ($gender === 1 ? 'Male' : 'Female');
}

function guarded_roles(): array
{
  return [0, 1];
}

function guarded_menus(): array
{
  return ['Dashboard', 'Users', 'Roles', 'Menus', 'Submenus'];
}

function guarded_submenus(): array
{
  return ['Dashboard', 'Users', 'Roles', 'Menus', 'Submenus'];
}
