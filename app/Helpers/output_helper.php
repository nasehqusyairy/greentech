<?php
function gender(int $gender): string
{
  return $gender === 0 ? "Don't want to specify" : ($gender === 1 ? 'Male' : 'Female');
}
