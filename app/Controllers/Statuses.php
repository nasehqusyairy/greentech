<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Status;

class Statuses extends BaseController
{
  protected $rule = [
    'store' => [
      'code' => 'required|is_unique[statuses.code]',
      'text' => 'required',
      'color' => 'required',
      'stype_id' => 'required|is_not_unique[stypes.id]',
    ],
    'update' => [
      'id' => 'required|is_not_unique[statuses.id]',
      'code' => 'required|is_unique[statuses.code,statuses.id,{id}]',
      'text' => 'required',
      'color' => 'required',
      'stype_id' => 'required|is_not_unique[stypes.id]',
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
    return view('statuses/index', [
      'statuses' => Status::with("stype")->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'deleted' => Status::onlyTrashed()->get(),
      'title' => 'statuses'
    ]);
  }

  public function create()
  {
    // create form
    return view('statuses/create', [
      'title' => 'New Status',
      'stypes' => \App\Models\Stype::get()
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
    Status::create($validInput);

    // redirect
    return redirect()->to('/statuses/')->with('message', 'Status data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $status = Status::find($id);

    // throw error if the data is not found
    if ($id == null || !$status) throw new PageNotFoundException();

    // return view
    return view('statuses/edit', [
      'status' => $status,
      'title' => 'Edit Status',
      'stypes' => \App\Models\Stype::get()
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
    $status = Status::find($validInput['id']);
    $status->update($validInput);

    // redirect
    return redirect()->to('/statuses/')->with('message', 'Status data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $status = Status::find($id);

    // throw error if the data is not found
    if (!$status) throw new PageNotFoundException();

    // delete data
    $status->delete();

    // redirect
    return redirect()->to('/statuses/')->with('message', 'Status data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $status = Status::withTrashed()->find($id);

    // throw error if the status is not found
    if (!$status) throw new PageNotFoundException();

    // restore data
    $status->restore();

    // redirect
    return redirect()->to('/statuses/')->with('message', 'Status data has been restored successfully');
  }
}
