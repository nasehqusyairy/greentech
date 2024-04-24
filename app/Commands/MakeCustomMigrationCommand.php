<?php

namespace App\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;

class MakeCustomMigrationCommand extends BaseCommand
{
  protected $group       = 'Custom';
  protected $name        = 'make:custom-migration';
  protected $description = 'Create a custom migration file';

  protected $usage = 'make:custom-migration <migration_name>';

  public function run(array $params)
  {
    $migrationName = array_shift($params);

    if (empty($migrationName)) {
      return CLI::error('You must provide a migration name.');
    }

    // Validate the format of the migration name
    if (!preg_match('/^Add[A-Z][a-zA-Z0-9]*$/', $migrationName)) {
      return CLI::error('Invalid migration name format. The migration name must start with "Add" followed by an uppercase letter and then alphanumeric characters.');
    }

    // Determine the path where migrations should be stored
    $path = APPPATH . 'Database/Migrations/';

    // Generate a filename based on the migration name
    $fileName = date('Y-m-d-His') . '_' . $migrationName . '.php';

    // Convert the migration name to the desired format
    $tableName = lcfirst(substr($migrationName, 3)); // Remove "Add" prefix

    // Load the template for custom migration
    $template = file_get_contents(APPPATH . 'Commands/templates/custom_migration_template.txt');

    // Replace placeholders in the template with actual content
    $template = str_replace('{migrationName}', $migrationName, $template);
    $template = str_replace('{tableName}', $tableName, $template);

    // Create the migration file
    if (!write_file($path . $fileName, $template)) {
      return CLI::error('Failed to create migration file.');
    }

    return CLI::write('File created: APPPATH\Database\Migrations\\' . $fileName, 'green');
  }
}
