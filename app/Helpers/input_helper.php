<?php
function clean_input(array $input): array
{
  $cleanedInput = [];
  foreach ($input as $key => $value) {
    $cleanedInput[$key] = trim(htmlspecialchars($value));
  }
  return $cleanedInput;
}
