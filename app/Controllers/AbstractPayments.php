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
        $query->where('code', '8');
      })->get()->sortBy('topic_id'),
      'user' => $user,
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'deleted' => Abstrac::onlyTrashed()->with('creator', 'topic', 'reviewer')->get()->sortBy('topic_id'),
      'title' => 'Abstracts Payments'
    ]);
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
      'title' => 'New Payment'
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

    // send email to user
    $emails = $abstrac->emails;
    $emailArray = explode(',', $emails);
    $emails = array_map('trim', $emailArray);
    $title = $abstrac->title;

    if($validInput['ticket_user_id'] != null){
      $mail = set_mail(
        'Your Abstract Proof of Payment has Been Uplouded',
        "Hello! $title proof of payment has been uplouded. Let's check it!",
        base_url('/abstractpayments/index'),
        'Go to Abstract Payments'
      );
  
      foreach($emails as $email){
        if (!send_email($mail, $email)) {
          $error = 'Failed to send email to '.$email.', please make sure your email is valid and try again. If the problem persists, please contact our customer service.';
        }
       }
    }else{
      $mail = set_mail(
        'Your Abstract Payment Status has Been Changed',
        "Hello! $title payment status has been changed. Let's check it!",
        base_url('/abstractpayments/index'),
        'Go to Abstract Payments'
      );
  
      foreach($emails as $email){
        if (!send_email($mail, $email)) {
          $error = 'Failed to send email to '.$email.', please make sure your email is valid and try again. If the problem persists, please contact our customer service.';
        }
       }
    }
    // redirect
    return redirect()->to('/abstractpayments/')->with('messages', ['success'=>'Abstract data has been saved successfully',
    'error'=>$error
  ]);
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
}
