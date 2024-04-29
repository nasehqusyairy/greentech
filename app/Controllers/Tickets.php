<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Ticket;

class Tickets extends BaseController
{
    protected $rule = [
      'store'=> [],
      'update'=> [
        'id' => 'required|is_not_unique[tickets.id]',
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
      // return view('tickets/index',[
      //   'tickets' => Ticket::all(),
      //   'message' => $this->session->has('message') ? $this->session->get('message') : '',
      //   'title' => 'Tickets'
      // ]);
      dd(Ticket::all()->toArray());
    }

    public function create()
    {
      // create form
      return view('tickets/create',[
        'title' => 'New Ticket'
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
      return view('tickets/edit',[
        'ticket'=>$ticket,
        'title' => 'Edit Ticket'
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
