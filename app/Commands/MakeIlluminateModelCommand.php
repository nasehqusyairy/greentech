<?php

namespace App\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;

class MakeIlluminateModelCommand extends BaseCommand
{
  protected $group       = 'Custom';
  protected $name        = 'make:custom-model';
  protected $description = 'Create an Illuminate model file';

  protected $usage = 'make:illuminate-model <model_name>';

  public function run(array $params)
  {
    $modelName = array_shift($params);

    if (empty($modelName)) {
      return CLI::error('You must provide a model name.');
    }

    // Determine the path where models should be stored
    $path = APPPATH . 'Models/';

    // Generate a filename based on the model name
    $fileName = $modelName . '.php';

    // Load the template for Illuminate model
    $template = file_get_contents(APPPATH . 'Commands/templates/illuminate_model_template.txt');

    // Replace placeholders in the template with actual content
    $template = str_replace('{modelName}', $modelName, $template);

    // Create the model file
    if (!write_file($path . $fileName, $template)) {
      return CLI::error('Failed to create model file.');
    }

    return CLI::write('File created: APPPATH\Models\\' . $fileName, 'green');
  }
}
