<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Abstrac;

class AbstractPayments extends BaseController
{
  protected $rule = [
    'store' => [],
    'update' => [
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
    $abstract = Abstrac::with('creator', 'topic', 'reviewer');

    $user = $this->getUser();
    if ($user->role->code == 3) {
      $abstract = $abstract->where('creator_id', $user->id);
    } else if ($user->role->code == 2) {
      $abstract = $abstract->where('reviewer_id', $user->id);
    }
    // main view
    return view('abstractpayments/index', [
      'user' => $user,
      'abstracts' => $abstract->get()->sortBy('topic_id'),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Abstracts',
      'deleted' => Abstrac::onlyTrashed()->with('creator', 'topic', 'reviewer')->get()->sortBy('topic_id'),
    ]);
  }

  public function create()
  {
    // create form
    return view('abstractpayment/create', [
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
    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    Abstrac::create($validInput);

    // redirect
    return redirect()->to('/abstractpayment/')->with('message', 'Abstrac data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $abstrac = Abstrac::find($id);

    // throw error if the data is not found
    if ($id == null || !$abstrac)
      throw new PageNotFoundException();

    // return view
    return view('abstractpayment/edit', [
      'abstrac' => $abstrac,
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
    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    $abstrac = Abstrac::find($validInput['id']);
    $abstrac->update($validInput);

    // redirect
    return redirect()->to('/abstractpayment/')->with('message', 'Abstrac data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $abstrac = Abstrac::find($id);

    // throw error if the data is not found
    if (!$abstrac)
      throw new PageNotFoundException();

    // delete data
    $abstrac->delete();

    // redirect
    return redirect()->to('/abstractpayment/')->with('message', 'Abstrac data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $abstrac = Abstrac::withTrashed()->find($id);

    // throw error if the abstrac is not found
    if (!$abstrac)
      throw new PageNotFoundException();

    // restore data
    $abstrac->restore();

    // redirect
    return redirect()->to('/abstractpayment/')->with('message', 'Abstrac data has been restored successfully');
  }
}
