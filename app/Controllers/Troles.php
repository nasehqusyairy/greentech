<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Trole;

class Troles extends BaseController
{
  protected $rule = [
    'store' => [
      'code' => 'required|is_unique[troles.code]',
      'name' => 'required|alpha_numeric_punct',
    ],
    'update' => [
      'id' => 'required|is_not_unique[troles.id]',
      'code' => 'required|is_unique[troles.code,id,{id}]',
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
    return view('troles/index', [
      'troles' => Trole::all(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Troles',
      'deleted' => Trole::onlyTrashed()->get()
    ]);
  }

  public function create()
  {
    // create form
    return view('troles/create', [
      'title' => 'New Trole'
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
    Trole::create($validInput);

    // redirect
    return redirect()->to('/troles/')->with('message', 'Trole data has been saved successfully');
  }

  public function edit($id)
  {
    // find data
    $trole = Trole::find($id);

    // throw error if the data is not found
    if ($id == null || !$trole) throw new PageNotFoundException();

    // return view
    return view('troles/edit', [
      'trole' => $trole,
      'title' => 'Edit Trole'
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
    $trole = Trole::find($validInput['id']);
    $trole->update($validInput);

    // redirect
    return redirect()->to('/troles/')->with('message', 'Trole data has been updated successfully');
  }

  public function delete($id)
  {
    // find data
    $trole = Trole::find($id);

    // throw error if the data is not found
    if (!$trole) throw new PageNotFoundException();

    // delete data
    $trole->delete();

    // redirect
    return redirect()->to('/troles/')->with('message', 'Trole data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $trole = Trole::withTrashed()->find($id);

    // throw error if the trole is not found
    if (!$trole) throw new PageNotFoundException();

    // restore data
    $trole->restore();

    // redirect
    return redirect()->to('/troles/')->with('message', 'Trole data has been restored successfully');
  }
}
