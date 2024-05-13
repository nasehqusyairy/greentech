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
      'title' => 'Settings'
    ]);
  }


  public function update()
  {
    // Check if the request is POST
    $this->isPostRequest();

    // Get the settings data from the POST request
    $settingsData = $this->request->getPost('settings');

    foreach ($settingsData as $settingId => $settingValues) {
      // Sanitize individual setting values if needed
      $value = htmlspecialchars($settingValues['value']);

      // Update the setting in your database
      $setting = Setting::find($settingId);
      if ($setting) {
        $setting->update([          
          'value' => $value,
        ]);
      } else {
        // Handle error if setting with the given ID is not found
      }
    }
    return redirect()->to('/systems/')->with('message', 'Systems saved successfully');
  }

}
