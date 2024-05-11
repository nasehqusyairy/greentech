<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Ttype;

class Ttypes extends BaseController
{
  protected $rule = [
    'store' => [
      'code' => 'required|is_unique[ttypes.code]',
      'name' => 'required|alpha_numeric_punct',
    ],
    'update' => [
      'id' => 'required|is_not_unique[ttypes.id]',
      'code' => 'required|is_unique[ttypes.code,id,{id}]',
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
    return view('ttypes/index', [
      'ttypes' => Ttype::all(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Ticket Types',
      'deleted' => Ttype::onlyTrashed()->get()
    ]);
  }

  public function create()
  {
    // create form
    return view('ttypes/create', [
      'title' => 'New Ticket Type'
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
    Ttype::create($validInput);

    // redirect
    return redirect()->to('/ttypes/')->with('message', 'Ticket type data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $ttype = Ttype::find($id);

    // throw error if the data is not found
    if ($id == null || !$ttype) throw new PageNotFoundException();

    // return view
    return view('ttypes/edit', [
      'ttype' => $ttype,
      'title' => 'Edit Ticket Type'
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
    $ttype = Ttype::find($validInput['id']);
    $ttype->update($validInput);

    // redirect
    return redirect()->to('/ttypes/')->with('message', 'Ticket type data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $ttype = Ttype::find($id);

    // throw error if the data is not found
    if (!$ttype) throw new PageNotFoundException();

    // delete data
    $ttype->delete();

    // redirect
    return redirect()->to('/ttypes/')->with('message', 'Ticket type data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $ttype = Ttype::withTrashed()->find($id);

    // throw error if the ttype is not found
    if (!$ttype) throw new PageNotFoundException();

    // restore data
    $ttype->restore();

    // redirect
    return redirect()->to('/ttypes/')->with('message', 'Ticket type data has been restored successfully');
  }
}
