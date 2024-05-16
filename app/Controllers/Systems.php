<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Setting;

class Systems extends BaseController
{
  protected $rule = [
    'update' => [
      'name' => 'alpha_numeric_space|required',
      'value' => 'required|in_list[0,1]',
    ],
  ];

  public function __construct()
  {
    parent::__construct();
    $this->isNeedLogin();
  }

  public function index()
  {
    $settings = Setting::all();
    // main view
    return view('systems/index', [
      'settings' => $settings,
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'System'
    ]);
  }


  public function update()
  {
    // Check if the request is POST
    $this->isPostRequest();

    // set validation rules
    $this->validator->setRules([
      'settings' => 'permit_empty',
      'settings.*' => 'permit_empty|alpha_numeric',
    ]);

    // validated input
    $validInput = $this->validInput(null, true);

    // // return response if the input is invalid
    if ($validInput === false) return $this->invalidInputResponse($this->validator->getErrors());

    // turn value of settings into null except the one that has value
    Setting::all()->each(function ($setting) use ($validInput) {

      // if the id of the setting is not in the input, set the value to null
      $setting->value = null;
      if (array_key_exists('settings', $validInput)) {
        if (array_key_exists($setting->id, $validInput['settings'])) {
          $setting->value = $validInput['settings'][$setting->id];
        }
      }
      $setting->save();
    });

    // return response
    return redirect()->to('/systems/')->with('message', 'System saved successfully');
  }
}
