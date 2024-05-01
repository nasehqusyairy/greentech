<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Study;

class Studies extends BaseController
{
    protected $rule = [
      'store' => [
        'code' => 'required|is_unique[roles.code]',
        'name' => 'required|alpha_numeric_punct',
      ],
      'update' => [
        'id' => 'required|is_not_unique[roles.id]',
        'code' => 'required|is_unique[roles.code,roles.id,{id}]',
        'name' => 'required|alpha_numeric_punct',
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
      return view('studies/index',[
        'studies' => Study::all(),
        'deleted' => Study::onlyTrashed()->get(),
        'message' => $this->session->has('message') ? $this->session->get('message') : '',
        'title' => 'studies'
        
      ]);
      dd(Study::all()->toArray());
    }

    public function create()
    {
      // create form
      return view('studies/create',[
        'title' => 'New Study'
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
      Study::create($validInput);

      // redirect
      return redirect()->to('/studies/')->with('message', 'Study data has been saved successfully');
    }

    public function edit($id)
    {
      // find data
      $study = Study::find($id);

      // throw error if the data is not found
      if ($id == null || !$study) throw new PageNotFoundException();

      // return view
      return view('studies/edit',[
        'study'=>$study,
        'title' => 'Edit Study'
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
      $study = Study::find($validInput['id']);
      $study->update($validInput);

      // redirect
      return redirect()->to('/studies/')->with('message', 'Study data has been updated successfully');
    }
    
    public function delete($id)
    {
        // find data
        $study = Study::find($id);

        // throw error if the data is not found
        if (!$study) throw new PageNotFoundException();

        // delete data
        $study->delete();

        // redirect
        return redirect()->to('/studies/')->with('message', 'Study data has been deleted successfully');
    }
    public function restore($id = null)
    {
      $study = Study::withTrashed()->find($id);

      // throw error if the study is not found
      if (!$study) throw new PageNotFoundException();

      // restore data
      $study->restore();

      // redirect
      return redirect()->to('/studies/')->with('message', 'Study data has been restored successfully');
    }
}
