<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\State;

class States extends BaseController
{
    protected $rule = [
      'store'=> [],
      'update'=> [
        'id' => 'required|is_not_unique[states.id]',
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
      // return view('states/index',[
      //   'states' => State::all(),
      //   'message' => $this->session->has('message') ? $this->session->get('message') : '',
      //   'title' => 'States'
      // ]);
      dd(State::all()->toArray());
    }

    public function create()
    {
      // create form
      return view('states/create',[
        'title' => 'New State'
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
      State::create($validInput);

      // redirect
      return redirect()->to('/states/')->with('message', 'State data has been saved successfully');
    }

    public function edit($id)
    {
      // find data
      $state = State::find($id);

      // throw error if the data is not found
      if ($id == null || !$state) throw new PageNotFoundException();

      // return view
      return view('states/edit',[
        'state'=>$state,
        'title' => 'Edit State'
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
      $state = State::find($validInput['id']);
      $state->update($validInput);

      // redirect
      return redirect()->to('/states/')->with('message', 'State data has been updated successfully');
    }
    
    public function delete($id)
    {
        // find data
        $state = State::find($id);

        // throw error if the data is not found
        if (!$state) throw new PageNotFoundException();

        // delete data
        $state->delete();

        // redirect
        return redirect()->to('/states/')->with('message', 'State data has been deleted successfully');
    }
    public function restore($id = null)
    {
      $state = State::withTrashed()->find($id);

      // throw error if the state is not found
      if (!$state) throw new PageNotFoundException();

      // restore data
      $state->restore();

      // redirect
      return redirect()->to('/states/')->with('message', 'State data has been restored successfully');
    }
}
