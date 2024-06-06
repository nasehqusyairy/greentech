<?php

namespace App\Controllers;

use App\Models\Abstrac;
use App\Models\Publication;
use App\Models\Status;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Paper;

class Papers extends BaseController
{
  protected $rule = [
    'store' => [
      'file' => 'uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
      'provement' => 'uploaded[file]|ext_in[file,pdf,jpg,png]|max_size[file,5120]',
      'abstrac_id' => 'required|is_not_unique[abstracs.id]',
      'publication_id' => 'required|is_not_unique[publications.id]',
    ],
    'update' => [
      'id' => 'required|is_not_unique[papers.id]',
      'file' => 'permit_empty|uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
      'provement' => 'permit_empty|uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
      'status_id' => 'permit_empty|is_not_unique[statuses.id]',
      'abstrac_id' => 'permit_empty|is_not_unique[abstracs.id]',
      'publication_id' => 'permit_empty|is_not_unique[publications.id]',
    ],
  ];

  public function __construct()
  {
    parent::__construct();
    $this->isNeedLogin();
  }

  public function index()
  {
    $papers = Paper::with('status', 'abstrac', 'publication');

    $user = $this->getUser();

    if($user->role->code == 3){
      $papers = $papers->whereHas('abstrac', function($query) use ($user) {
        $query->where('creator_id', $user->id);
    });
    }

    // main view
    return view('papers/index',[
      'user' => $user,
      'papers' => $papers->get()->sortBy('created_at'),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Papers',
      'deleted' => Paper::onlyTrashed()->with('status', 'abstrac', 'publication')->get()->sortBy('created_at'),
    ]);

  }

  public function create()
  {
    // create form
    return view('papers/create', [
      'abstracs' => Abstrac::all(),
      'publications' => Publication::all(),
      'title' => 'New Paper'
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
    $files = $this->upload(['file']);
    if (!isset($files['file'])) {
      unset($validInput['file']);
    } else {
      $validInput['file'] = $files['file'];
    }

    $provement = $this->upload(['provement']);
    if (!isset($provement['provement'])) {
      unset($validInput['provement']);
    } else {
      $validInput['provement'] = $provement['provement'];
    }

    $validInput['status_id'] = 11;
    Paper::create($validInput);

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $paper = Paper::find($id);

    $user = $this->getUser();

    // throw error if the data is not found
    if ($id == null || !$paper) throw new PageNotFoundException();

    // return view
    return view('papers/edit', [
      'user' => $user->role->code,
      'paper' => $paper,
      'abstracs' => Abstrac::all(),
      'publications' => Publication::all(),
      'statuses' => Status::all(),
      'title' => 'Edit Paper'
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
    $paper = Paper::find($validInput['id']);
    $paper->update($validInput);

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $paper = Paper::find($id);

    // throw error if the data is not found
    if (!$paper) throw new PageNotFoundException();

    // delete data
    $paper->delete();

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $paper = Paper::withTrashed()->find($id);

    // throw error if the paper is not found
    if (!$paper) throw new PageNotFoundException();

    // restore data
    $paper->restore();

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been restored successfully');
  }
}
