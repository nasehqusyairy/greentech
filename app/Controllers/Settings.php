<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Setting;

class Settings extends BaseController
{
    protected $rule = [
      'store'=> [
        'name' => 'required|alpha_numeric_punct',
      ],
      'update'=> [
        'name' => 'required|alpha_numeric_punct',
        'id' => 'required|is_not_unique[settings.id]',
      ],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->isNeedLogin();
    }

    public function index()
    {
      // main view
      return view('settings/index',[
        'settings' => Setting::all(),
        'deleted' => Setting::onlyTrashed()->get(),
        'message' => $this->session->has('message') ? $this->session->get('message') : '',
        'title' => 'Settings'
      ]);      
    }

    public function create()
    {
      // create form
      return view('settings/create',[
        'title' => 'New Setting',
        'setting' => new Setting()
      ]);
    }

    public function store()
    {
      // check if the request is POST
      $this->isPostRequest();

      // set validation rules
      $this->validator->setRules($this->rule['store']);

      // validated input
      $validInput = $this->validInput();

      // return response if the input is invalid
      if (!$validInput) return $this->invalidInputResponse($this->validator->getErrors());

      // manipulate data here
      Setting::create($validInput);

      // redirect
      return redirect()->to('/settings/')->with('message', 'Setting data has been saved successfully');
    }

    public function edit($id)
    {
      // find data
      $setting = Setting::find($id);

      // throw error if the data is not found
      if ($id == null || !$setting) throw new PageNotFoundException();

      // return view
      return view('settings/edit',[
        'setting'=>$setting,
        'title' => 'Edit Setting'
      ]);
    }

    public function update()
    {
       // check if the request is POST
      $this->isPostRequest();

      // set validation rules
      $this->validator->setRules($this->rule['update']);

      // validated input
      $validInput = $this->validInput();

      // return response if the input is invalid
      if (!$validInput) return $this->invalidInputResponse($this->validator->getErrors());

      // manipulate data here
      $setting = Setting::find($validInput['id']);
      $setting->update($validInput);

      // redirect
      return redirect()->to('/settings/')->with('message', 'Setting data has been updated successfully');
    }
    
    public function delete($id)
    {
        // find data
        $setting = Setting::find($id);

        // throw error if the data is not found
        if (!$setting) throw new PageNotFoundException();

        // delete data
        $setting->delete();

        // redirect
        return redirect()->to('/settings/')->with('message', 'Setting data has been deleted successfully');
    }
    public function restore($id = null)
    {
      $setting = Setting::withTrashed()->find($id);

      // throw error if the setting is not found
      if (!$setting) throw new PageNotFoundException();

      // restore data
      $setting->restore();

      // redirect
      return redirect()->to('/settings/')->with('message', 'Setting data has been restored successfully');
    }
}
