<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Topic;

class Topics extends BaseController
{
  protected $rule = [
    'store' => [
      'name' => 'required|alpha_numeric_punct',
    ],
    'update' => [
      'id' => 'required|is_not_unique[topics.id]',
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
    return view('topics/index', [
      'topics' => Topic::all(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Topics',
      'deleted' => Topic::onlyTrashed()->get()
    ]);
  }

  public function create()
  {
    // create form
    return view('topics/create', [
      'title' => 'New Topic'
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
    Topic::create($validInput);

    // redirect
    return redirect()->to('/topics/')->with('message', 'Topic data has been saved successfully');
  }

  public function edit($id)
  {
    // find data
    $topic = Topic::find($id);

    // throw error if the data is not found
    if ($id == null || !$topic) throw new PageNotFoundException();

    // return view
    return view('topics/edit', [
      'topic' => $topic,
      'title' => 'Edit Topic'
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
    $topic = Topic::find($validInput['id']);
    $topic->update($validInput);

    // redirect
    return redirect()->to('/topics/')->with('message', 'Topic data has been updated successfully');
  }

  public function delete($id)
  {
    // find data
    $topic = Topic::find($id);

    // throw error if the data is not found
    if (!$topic) throw new PageNotFoundException();

    // delete data
    $topic->delete();

    // redirect
    return redirect()->to('/topics/')->with('message', 'Topic data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $topic = Topic::withTrashed()->find($id);

    // throw error if the topic is not found
    if (!$topic) throw new PageNotFoundException();

    // restore data
    $topic->restore();

    // redirect
    return redirect()->to('/topics/')->with('message', 'Topic data has been restored successfully');
  }
}
