<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Stype;

class Stypes extends BaseController
{
  protected $rule = [
    'store' => [
      'code' => 'required|is_unique[stypes.code]',
      'name' => 'required|alpha_numeric_punct',
    ],
    'update' => [
      'id' => 'required|is_not_unique[stypes.id]',
      'code' => 'required|is_unique[stypes.code,stypes.id,{id}]',
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
    return view('stypes/index', [
      'title' => 'Status Types',
      'stypes' => Stype::all(),
      'deleted' => Stype::onlyTrashed()->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
    ]);
  }

  public function create()
  {
    // create form
    return view('stypes/create', [
      'title' => 'New Status Type'
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
    Stype::create($validInput);

    // redirect
    return redirect()->to('/stypes/')->with('message', 'Stype data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $stype = Stype::find($id);

    // throw error if the data is not found
    if ($id == null || !$stype) throw new PageNotFoundException();

    // return view
    return view('stypes/edit', [
      'stype' => $stype,
      'title' => 'Edit Status Type'
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
    $stype = Stype::find($validInput['id']);
    $stype->update($validInput);

    // redirect
    return redirect()->to('/stypes/')->with('message', 'Stype data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $stype = Stype::find($id);

    // throw error if the data is not found
    if (!$stype) throw new PageNotFoundException();

    // delete data
    $stype->delete();

    // redirect
    return redirect()->to('/stypes/')->with('message', 'Stype data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $stype = Stype::withTrashed()->find($id);

    // throw error if the stype is not found
    if (!$stype) throw new PageNotFoundException();

    // restore data
    $stype->restore();

    // redirect
    return redirect()->to('/stypes/')->with('message', 'Stype data has been restored successfully');
  }
}
