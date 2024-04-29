<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Status;

class Statuses extends BaseController
{
    protected $rule = [
      'store'=> [],
      'update'=> [
        'id' => 'required|is_not_unique[statuss.id]',
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
      // return view('statuses/index',[
      //   'statuss' => Status::all(),
      //   'message' => $this->session->has('message') ? $this->session->get('message') : '',
      //   'title' => 'Statuss'
      // ]);
      dd(Status::all()->toArray());
    }

    public function create()
    {
      // create form
      return view('statuses/create',[
        'title' => 'New Status'
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
      Status::create($validInput);

      // redirect
      return redirect()->to('/statuses/')->with('message', 'Status data has been saved successfully');
    }

    public function edit($id)
    {
      // find data
      $status = Status::find($id);

      // throw error if the data is not found
      if ($id == null || !$status) throw new PageNotFoundException();

      // return view
      return view('statuses/edit',[
        'status'=>$status,
        'title' => 'Edit Status'
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
      $status = Status::find($validInput['id']);
      $status->update($validInput);

      // redirect
      return redirect()->to('/statuses/')->with('message', 'Status data has been updated successfully');
    }
    
    public function delete($id)
    {
        // find data
        $status = Status::find($id);

        // throw error if the data is not found
        if (!$status) throw new PageNotFoundException();

        // delete data
        $status->delete();

        // redirect
        return redirect()->to('/statuses/')->with('message', 'Status data has been deleted successfully');
    }
    public function restore($id = null)
    {
      $status = Status::withTrashed()->find($id);

      // throw error if the status is not found
      if (!$status) throw new PageNotFoundException();

      // restore data
      $status->restore();

      // redirect
      return redirect()->to('/statuses/')->with('message', 'Status data has been restored successfully');
    }
}
