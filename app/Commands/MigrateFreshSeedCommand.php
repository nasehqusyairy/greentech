<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;

class MigrateFreshSeedCommand extends BaseCommand
{
  protected $group       = 'Database';
  protected $name        = 'migrate:fresh';
  protected $description = 'Refresh the migrations and seeds the database';
  protected $options     = [
    '--seed' => 'Seed the database after migrating',
  ];

  public function run(array $params)
  {
    $this->call('migrate:refresh');
    // run only if --seed is passed
    if (array_key_exists('seed', $params)) {
      $this->call('db:seed', ['DatabaseSeeder']);
    }
  }
}
