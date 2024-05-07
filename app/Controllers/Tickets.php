<?php

namespace App\Controllers;

use App\Models\State;
use App\Models\Study;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Ticket;
use App\Models\Trole;
use App\Models\Ttype;

class Tickets extends BaseController
{
  protected $rule = [
    'store' => [
      'name' => 'required|alpha_numeric_punct',
      'attendance' => 'required|in_list[online,offline]',
      'ttype_id' => 'required|is_not_unique[ttypes.id]',
      'trole_id' => 'required|is_not_unique[troles.id]',
      'state_id' => 'required|is_not_unique[states.id]',
      'study_id' => 'required|is_not_unique[studies.id]',
      'price' => 'required|numeric',
    ],
    'update' => [
      'id' => 'required|is_not_unique[tickets.id]',
      'name' => 'required|alpha_numeric_punct',
      'attendance' => 'required|in_list[online,offline]',
      'ttype_id' => 'required|is_not_unique[ttypes.id]',
      'trole_id' => 'required|is_not_unique[troles.id]',
      'state_id' => 'required|is_not_unique[states.id]',
      'study_id' => 'required|is_not_unique[studies.id]',
      'price' => 'required|numeric',
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
    return view('tickets/index', [
      'tickets' => Ticket::with('ttype', 'trole', 'state', 'study')->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Tickets',
      'deleted' => Ticket::onlyTrashed()->with('ttype', 'trole', 'state', 'study')->get()
    ]);
    // dd(Ticket::with('ttype', 'trole', 'state', 'study')->get()[0]->attendance);
  }

  public function create()
  {
    // create form
    return view('tickets/create', [
      'title' => 'New Ticket',
      'ttypes' => Ttype::all(),
      'troles' => Trole::all(),
      'states' => State::all(),
      'studies' => Study::all(),
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
    Ticket::create($validInput);

    // redirect
    return redirect()->to('/tickets/')->with('message', 'Ticket data has been saved successfully');
  }

  public function edit($id)
  {
    // find data
    $ticket = Ticket::find($id);

    // throw error if the data is not found
    if ($id == null || !$ticket) throw new PageNotFoundException();

    // return view
    return view('tickets/edit', [
      'ticket' => $ticket,
      'title' => 'Edit Ticket',
      'ttypes' => Ttype::all(),
      'troles' => Trole::all(),
      'states' => State::all(),
      'studies' => Study::all(),
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
    $ticket = Ticket::find($validInput['id']);
    $ticket->update($validInput);

    // redirect
    return redirect()->to('/tickets/')->with('message', 'Ticket data has been updated successfully');
  }

  public function delete($id)
  {
    // find data
    $ticket = Ticket::find($id);

    // throw error if the data is not found
    if (!$ticket) throw new PageNotFoundException();

    // delete data
    $ticket->delete();

    // redirect
    return redirect()->to('/tickets/')->with('message', 'Ticket data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $ticket = Ticket::withTrashed()->find($id);

    // throw error if the ticket is not found
    if (!$ticket) throw new PageNotFoundException();

    // restore data
    $ticket->restore();

    // redirect
    return redirect()->to('/tickets/')->with('message', 'Ticket data has been restored successfully');
  }
}
