<?php

use App\Models\User;

function user()
{
  return User::find(session()->get('user'));
}
