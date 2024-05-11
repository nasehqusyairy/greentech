<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Paper;

class Papers extends BaseController
{
  protected $rule = [
    'store' => [],
    'update' => [
      'id' => 'required|is_not_unique[papers.id]',
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
    // return view('papers/index',[
    //   'papers' => Paper::all(),
    //   'message' => $this->session->has('message') ? $this->session->get('message') : '',
    //   'title' => 'Papers'
    // ]);
    dd(Paper::all()->toArray());
  }

  public function create()
  {
    // create form
    return view('papers/create', [
      'title' => 'New Paper'
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
    Paper::create($validInput);

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $paper = Paper::find($id);

    // throw error if the data is not found
    if ($id == null || !$paper) throw new PageNotFoundException();

    // return view
    return view('papers/edit', [
      'paper' => $paper,
      'title' => 'Edit Paper'
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
    $paper = Paper::find($validInput['id']);
    $paper->update($validInput);

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $paper = Paper::find($id);

    // throw error if the data is not found
    if (!$paper) throw new PageNotFoundException();

    // delete data
    $paper->delete();

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $paper = Paper::withTrashed()->find($id);

    // throw error if the paper is not found
    if (!$paper) throw new PageNotFoundException();

    // restore data
    $paper->restore();

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been restored successfully');
  }
}
