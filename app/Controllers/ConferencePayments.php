<?php

namespace App\Controllers;

use App\Models\Abstrac;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\TicketUser;

class Conferencepayments extends BaseController
{
  protected $rule = [
    'store' => [
      'ticket_id' => 'required|is_not_unique[tickets.id]',
      'proof' => 'uploaded[proof]|ext_in[proof,pdf,doc,docx,png,jpg,jpeg]|max_size[proof,5120]',
      'attachment' => 'permit_empty|uploaded[attachment]|max_size[attachment,5120]|ext_in[attachment,png,jpg,jpeg,pdf]',
    ],
    'update' => [
      'id' => 'required|is_not_unique[ticket_user.id]',
      'ticket_id' => 'required|is_not_unique[tickets.id]',
      'proof' => 'uploaded[proof]|ext_in[proof,pdf,doc,docx,png,jpg,jpeg]|max_size[proof,5120]',
      'attachment' => 'permit_empty|uploaded[attachment]|max_size[attachment,5120]|ext_in[attachment,png,jpg,jpeg,pdf]',
    ],
  ];

  public function __construct()
  {
    parent::__construct();
    $this->isNeedLogin();
  }

  public function index()
  {
    $ticket = TicketUser::with('abstrac', 'status', 'user', 'ticket');

    $user = $this->getUser();

    if ($user->role->code == 3 || $user->role->code == 4) {
      $ticket = $ticket->where('user_id', $user->id);
    }

    // main view
    return view('conferencepayments/index', [
      'user' => $this->getUser(),
      'ticketUsers' => $ticket->get()->sortByDesc('created_at'),
      'deleted' => TicketUser::onlyTrashed()->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Conference Payments'
    ]);
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
    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here

    $validInput['user_id'] = $this->getUser()->id;

    $validInput['status_id'] = Status::where('code', '2')->first()->id;

    $ticket = TicketUser::create($validInput);
    $files1 = $this->upload(['proof'], null, 'abs_proof_' . $ticket->id);
    $files2 = $this->upload(['attachment'], null, 'abs_att_' . $ticket->id);
    $ticket->proof = $files1['proof'];

    if(isset($files2['attachment'])){
      $ticket->attachment = $files2['attachment'];
    }
    $ticket->save();

    // send email to user
    $user = User::where('id', $validInput['user_id'])->first();
    $email = $user->email;

    $mail = set_mail(
      'You have Successfully Purchased a Ticket',
      "Congrats! Your ticket succesfully purchased. If you did not make this change, please contact our customer service.",
      base_url('/conferencepayments/index'),
      'Go to Conference Payment Page'
    );

    if (!send_email($mail, $email)) {
      $error = 'Failed to send email to ' . $email . ', please make sure your email is valid and try again. If the problem persists, please contact our customer service.';
    }

    $response = [
      'success' => 'Payment data has been saved successfully',
    ];

    if (isset($error))
      $response['error'] = $error;

    // redirect
    return redirect()->to('/conferencepayments/')->with('messages', $response);
  }

  public function edit($id = null)
  {
    // find data
    $ticketUser = TicketUser::find($id);

    // throw error if the data is not found
    if ($id == null || !$ticketUser)
      throw new PageNotFoundException();

    if ($ticketUser->status->code == 4) {
      return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been confirmed, cannot be edited');
    }

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
    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    $ticketUser = TicketUser::find($validInput['id']);
    $files1 = $this->upload(['proof'], null, 'abs_proof_' . $ticketUser->id);
    $files2 = $this->upload(['attachment'], null, 'abs_att_' . $ticketUser->id);

    $validInput['proof'] = $files1['proof'];

    if(isset($files2['attachment'])){
      $validInput['attachment'] = $files2['attachment'];
    }
    $ticketUser->update($validInput);

    // redirect
    return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $ticketUser = TicketUser::find($id);

    // throw error if the data is not found
    if (!$ticketUser)
      throw new PageNotFoundException();

    // delete data
    $ticketUser->delete();

    // redirect
    return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $ticketUser = TicketUser::withTrashed()->find($id);

    // throw error if the ticketUser is not found
    if (!$ticketUser)
      throw new PageNotFoundException();

    // restore data
    $ticketUser->restore();

    // redirect
    return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been restored successfully');
  }

  public function confirm($id = null)
  {
    // find data
    $ticketUser = TicketUser::find($id);

    // throw error if the data is not found
    if (!$ticketUser)
      throw new PageNotFoundException();


    if ($ticketUser->status_id == 4) {
      return redirect()->to('/conferencepayments/')->with('message', "This ticket already confirmed");
    }

    // manipulate data here
    $ticketUser->status_id = Status::where('code', '4')->first()->id;
    $ticketUser->save();

    return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been confirmed successfully');
  }

  public function reject($id = null)
  {
    // find data
    $ticketUser = TicketUser::find($id);
    $abstract = Abstrac::where('ticket_user_id', $id)->first();

    // throw error if the data is not found
    if (!$ticketUser)
      throw new PageNotFoundException();


    if ($ticketUser->status_id == 4) {
      return redirect()->to('/conferencepayments/')->with('message', "This ticket already confirmed");
    }

    // manipulate data here
    $ticketUser->status_id = Status::where('code', '3')->first()->id;
    $ticketUser->save();

    if (!empty($abstract)){
      $abstract->update(['ticket_user_id' => null]);
    }

    return redirect()->to('/conferencepayments/')->with('message', 'Payment data has been confirmed successfully');
  }
}



