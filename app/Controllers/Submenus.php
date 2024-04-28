<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Submenu;

class Submenus extends BaseController
{
    protected $rule = [
      'store'=> [],
      'update'=> [
        'id' => 'required|is_not_unique[submenus.id]',
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
      // return view('submenus/index',[
      //   'submenus' => Submenu::all(),
      //   'message' => $this->session->has('message') ? $this->session->get('message') : '',
      //   'title' => 'Submenus'
      // ]);
      dd(Submenu::all()->toArray());
    }

    public function create()
    {
      // create form
      return view('submenus/create',[
        'title' => 'New Submenu'
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
      Submenu::create($validInput);

      // redirect
      return redirect()->to('/submenus/')->with('message', 'Submenu data has been saved successfully');
    }

    public function edit($id)
    {
      // find data
      $submenu = Submenu::find($id);

      // throw error if the data is not found
      if ($id == null || !$submenu) throw new PageNotFoundException();

      // return view
      return view('submenus/edit',[
        'submenu'=>$submenu,
        'title' => 'Edit Submenu'
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
      $submenu = Submenu::find($validInput['id']);
      $submenu->update($validInput);

      // redirect
      return redirect()->to('/submenus/')->with('message', 'Submenu data has been updated successfully');
    }
    
    public function delete($id)
    {
        // find data
        $submenu = Submenu::find($id);

        // throw error if the data is not found
        if (!$submenu) throw new PageNotFoundException();

        // delete data
        $submenu->delete();

        // redirect
        return redirect()->to('/submenus/')->with('message', 'Submenu data has been deleted successfully');
    }
    public function restore($id = null)
    {
      $submenu = Submenu::withTrashed()->find($id);

      // throw error if the submenu is not found
      if (!$submenu) throw new PageNotFoundException();

      // restore data
      $submenu->restore();

      // redirect
      return redirect()->to('/submenus/')->with('message', 'Submenu data has been restored successfully');
    }
}
