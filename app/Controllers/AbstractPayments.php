<?php

namespace App\Controllers;

use App\Models\TicketUser;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Abstrac;

class AbstractPayments extends BaseController
{
  protected $rule = [
    'store' => [],
    'update' => [
      'id' => 'required|is_not_unique[abstracs.id]',
      'ticket_user_id' => 'permit_empty|is_not_unique[ticket_user.id]',
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
    $abstract = Abstrac::with('ticketUser');

    $user = $this->getUser();

    if ($user->role->code == 3) {
      $abstract = $abstract->where('creator_id', $user->id);
    }

    return view('abstractpayments/index', [
      'abstracs' => $abstract->whereHas('status', function ($query) {
        $query->where('code', '7');
      })->get()->sortBy('topic_id'),
      'user' => $user,
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'deleted' => Abstrac::onlyTrashed()->with('creator', 'topic', 'reviewer')->get()->sortBy('topic_id'),
      'title' => 'Abstracs Payments'
    ]);

  }

  public function create()
  {
    // create form
    return view('abstractpayments/create', [
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
    return redirect()->to('/abstractpayments/')->with('message', 'Abstrac data has been saved successfully');
  }

  public function pay($id = null)
  {
    // find data
    $abstrac = Abstrac::find($id);

    // throw error if the data is not found
    if ($id == null || !$abstrac)
      throw new PageNotFoundException();

    $ticketUsers = TicketUser::all();
    $usedTicketUser = Abstrac::pluck('ticket_user_id')->toArray();

    // Deleted Ticket wichh has been used in list
    $ticketUsers = $ticketUsers->reject(function ($ticketUser) use ($usedTicketUser) {
      return in_array($ticketUser->id, $usedTicketUser);
    });

    // return view
    return view('abstractpayments/pay', [
      'abstract' => $abstrac,
      'ticketUsers' => $ticketUsers,
      'title' => 'Payment Abstrac'
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
    return redirect()->to('/abstractpayments/')->with('message', 'Abstrac Payments data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $abstrac = Abstrac::find($id);

    // throw error if the data is not found
    if (!$abstrac)
      throw new PageNotFoundException();

    // delete data
    $abstrac->update(['ticket_user_id' => null]);

    // redirect
    return redirect()->to('/abstractpayments/')->with('message', 'Abstract Ticket has been deleted successfully');
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
    return redirect()->to('/abstractpayments/')->with('message', 'Abstrac data has been restored successfully');
  }
}
