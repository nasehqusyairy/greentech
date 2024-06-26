<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\TicketUser;

class TicketUsers extends BaseController
{
  protected $rule = [
    'store' => [],
    'update' => [
      'id' => 'required|is_not_unique[ticketUsers.id]',
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
    // return view('ticketusers/index',[
    //   'ticketUsers' => TicketUser::all(),
    //   'message' => $this->session->has('message') ? $this->session->get('message') : '',
    //   'title' => 'TicketUsers'
    // ]);
    dd(TicketUser::all()->toArray());
  }

  public function create()
  {
    // create form
    return view('ticketusers/create', [
      'title' => 'New TicketUser'
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
    TicketUser::create($validInput);

    // redirect
    return redirect()->to('/ticketusers/')->with('message', 'TicketUser data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $ticketUser = TicketUser::find($id);

    // throw error if the data is not found
    if ($id == null || !$ticketUser) throw new PageNotFoundException();

    // return view
    return view('ticketusers/edit', [
      'ticketUser' => $ticketUser,
      'title' => 'Edit TicketUser'
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
    $ticketUser = TicketUser::find($validInput['id']);
    $ticketUser->update($validInput);

    // redirect
    return redirect()->to('/ticketusers/')->with('message', 'TicketUser data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $ticketUser = TicketUser::find($id);

    // throw error if the data is not found
    if (!$ticketUser) throw new PageNotFoundException();

    // delete data
    $ticketUser->delete();

    // redirect
    return redirect()->to('/ticketusers/')->with('message', 'TicketUser data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $ticketUser = TicketUser::withTrashed()->find($id);

    // throw error if the ticketUser is not found
    if (!$ticketUser) throw new PageNotFoundException();

    // restore data
    $ticketUser->restore();

    // redirect
    return redirect()->to('/ticketusers/')->with('message', 'TicketUser data has been restored successfully');
  }
}
