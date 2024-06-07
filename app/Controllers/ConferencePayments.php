<?php

namespace App\Controllers;

use App\Models\Status;
use App\Models\Ticket;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\TicketUser;

class ConferencePayments extends BaseController
{
  protected $rule = [
    'store' => [
      'ticket_id' => 'required|is_not_unique[tickets.id]',
      'proof' => 'uploaded[proof]|ext_in[proof,pdf,doc,docx,png,jpg,jpeg]|max_size[proof,5120]',
      'attachment' => 'uploaded[attachment]|max_size[attachment,5120]|ext_in[attachment,png,jpg,jpeg,pdf]',
    ],
    'update' => [
      'id' => 'required|is_not_unique[ticket_user.id]',
      'ticket_id' => 'required|is_not_unique[tickets.id]',
      'proof' => 'uploaded[proof]|ext_in[proof,pdf,doc,docx,png,jpg,jpeg]|max_size[proof,5120]',
      'attachment' => 'uploaded[attachment]|max_size[attachment,5120]|ext_in[attachment,png,jpg,jpeg,pdf]',
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
    return view('conferencepayments/index', [
      'ticketUsers' => TicketUser::with('abstrac', 'status', 'user', 'ticket')->get(),
      'deleted' => TicketUser::onlyTrashed()->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Conference Payments'
    ]);
    // dd(TicketUser::all()->toArray());
  }

  public function create()
  {
    // create form
    return view('conferencepayments/create', [
      'tickets' => Ticket::all(),
      'statuses' => Status::whereHas('stype', function ($query) {
        $query->where('code', 0);
      })->get(),
      'title' => 'New Payment'
    ]);
  }

  public function store()
  {
    // check if the request is POST
    $this->isPostRequest();

    // set validation rules
    $this->validator->setRules($this->rule['store']);

    // validated input
    $validInput = $this->validInput(['proof', 'attachment']);

    // return response if the input is invalid
    if (!$validInput) return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    $files = $this->upload(['proof', 'attachment']);
    $validInput['proof'] = $files['proof'];
    $validInput['attachment'] = $files['attachment'];
    $validInput['user_id'] = $this->getUser()->id;

    $validInput['status_id'] = Status::where('code', '4')->first()->id;

    TicketUser::create($validInput);

    // redirect
    return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $ticketUser = TicketUser::find($id);

    // throw error if the data is not found
    if ($id == null || !$ticketUser) throw new PageNotFoundException();

    // return view
    return view('conferencepayments/edit', [
      'ticketUser' => $ticketUser,
      'tickets' => Ticket::all(),
      'title' => 'Edit Payment'
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
    return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been updated successfully');
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
    return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $ticketUser = TicketUser::withTrashed()->find($id);

    // throw error if the ticketUser is not found
    if (!$ticketUser) throw new PageNotFoundException();

    // restore data
    $ticketUser->restore();

    // redirect
    return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been restored successfully');
  }
}
