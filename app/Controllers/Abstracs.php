<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Abstrac;

class Abstracs extends BaseController
{
    protected $rule = [
      'store'=> [],
      'update'=> [
        'id' => 'required|is_not_unique[abstracs.id]',
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
      // return view('abstracs/index',[
      //   'abstracs' => Abstrac::all(),
      //   'message' => $this->session->has('message') ? $this->session->get('message') : '',
      //   'title' => 'Abstracs'
      // ]);
      dd(Abstrac::all()->toArray());
    }

    public function create()
    {
      // create form
      return view('abstracs/create',[
        'title' => 'New Abstrac'
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
      Abstrac::create($validInput);

      // redirect
      return redirect()->to('/abstracs/')->with('message', 'Abstrac data has been saved successfully');
    }

    public function edit($id)
    {
      // find data
      $abstrac = Abstrac::find($id);

      // throw error if the data is not found
      if ($id == null || !$abstrac) throw new PageNotFoundException();

      // return view
      return view('abstracs/edit',[
        'abstrac'=>$abstrac,
        'title' => 'Edit Abstrac'
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
      $abstrac = Abstrac::find($validInput['id']);
      $abstrac->update($validInput);

      // redirect
      return redirect()->to('/abstracs/')->with('message', 'Abstrac data has been updated successfully');
    }
    
    public function delete($id)
    {
        // find data
        $abstrac = Abstrac::find($id);

        // throw error if the data is not found
        if (!$abstrac) throw new PageNotFoundException();

        // delete data
        $abstrac->delete();

        // redirect
        return redirect()->to('/abstracs/')->with('message', 'Abstrac data has been deleted successfully');
    }
    public function restore($id = null)
    {
      $abstrac = Abstrac::withTrashed()->find($id);

      // throw error if the abstrac is not found
      if (!$abstrac) throw new PageNotFoundException();

      // restore data
      $abstrac->restore();

      // redirect
      return redirect()->to('/abstracs/')->with('message', 'Abstrac data has been restored successfully');
    }
}
