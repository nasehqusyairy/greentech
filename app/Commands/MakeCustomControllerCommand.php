<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeCustomControllerCommand extends BaseCommand
{
  protected $group       = 'custom';
  protected $name        = 'make:custom-controller';
  protected $description = 'Create a new custom controller file.';
  protected $usage       = 'make:custom-controller [controllerName] [modelName]';
  protected $arguments   = [
    'controllerName' => 'The name of the controller to be created',
    'modelName'      => 'The name of the model associated with the controller',
  ];

  public function run(array $params)
  {
    if (count($params) == 2) {
      $controllerName = $params[0];
      $modelName = $params[1];
    }

    if (empty($controllerName)) {
      $controllerName = CLI::prompt('Controller class name: ');
    }

    if (empty($modelName)) {
      $modelName = CLI::prompt('Model class name: ');
    }

    if (empty($controllerName) || empty($modelName)) {
      CLI::error('Controller name and model name are required.');
      return;
    }

    $segment = strtolower($controllerName);
    $modelVar = lcfirst($modelName);

    // Read the template file
    $templatePath = APPPATH . 'Commands/templates/custom_controller_template.txt';
    $template = file_get_contents($templatePath);

    // Replace placeholders with actual values
    $template = str_replace('{controllerName}', $controllerName, $template);
    $template = str_replace('{modelName}', $modelName, $template);
    $template = str_replace('{modelVar}', $modelVar, $template);
    $template = str_replace('{segment}', $segment, $template);

    // Determine the file path
    $filePath = APPPATH . 'Controllers/' . $controllerName . '.php';

    // Check if the controller already exists
    if (file_exists($filePath)) {
      CLI::error('Controller already exists.');
      return;
    }

    // Write the template to the file
    if (!write_file($filePath, $template)) {
      CLI::error('Failed to create the controller file.');
      return;
    }

    return CLI::write('File created: APPPATH\Controllers\\' . $filePath, 'green');
  }
}
