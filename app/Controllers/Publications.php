<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Publication;

class Publications extends BaseController
{
  protected $rule = [
    'store' => [
      'name' => 'required|alpha_numeric_punct',
    ],
    'update' => [
      'id' => 'required|is_not_unique[publications.id]',
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
    return view('publications/index',[
      'publications' => Publication::all(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Publications',
      'deleted' => Publication::onlyTrashed()->get()
    ]);
  }

  public function create()
  {
    // create form
    return view('publications/create', [
      'title' => 'New Publication'
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
    Publication::create($validInput);

    // redirect
    return redirect()->to('/publications/')->with('message', 'Publication data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $publication = Publication::find($id);

    // throw error if the data is not found
    if ($id == null || !$publication) throw new PageNotFoundException();

    // return view
    return view('publications/edit', [
      'publication' => $publication,
      'title' => 'Edit Publication'
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
    $publication = Publication::find($validInput['id']);
    $publication->update($validInput);

    // redirect
    return redirect()->to('/publications/')->with('message', 'Publication data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $publication = Publication::find($id);

    // throw error if the data is not found
    if (!$publication) throw new PageNotFoundException();

    // delete data
    $publication->delete();

    // redirect
    return redirect()->to('/publications/')->with('message', 'Publication data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $publication = Publication::withTrashed()->find($id);

    // throw error if the publication is not found
    if (!$publication) throw new PageNotFoundException();

    // restore data
    $publication->restore();

    // redirect
    return redirect()->to('/publications/')->with('message', 'Publication data has been restored successfully');
  }
}
