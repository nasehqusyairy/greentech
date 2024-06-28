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

    if ($user->role->code == 3) {
      $papers = $papers->whereHas('abstrac', function ($query) use ($user) {
        $query->where('creator_id', $user->id);
      });
    }

    // main view
    return view('papers/index', [
      'user' => $user,
      'papers' => $papers->get()->sortBy('created_at'),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Papers',
      'deleted' => Paper::onlyTrashed()->with('status', 'abstrac', 'publication')->get()->sortBy('created_at'),
    ]);

  }

  public function create()
  {
    $user = $this->getUser();
    // Deleted Abstrac wichh has been used in list
    $allAbstrac = Abstrac::all();
    $usedAbstrac = Paper::pluck('abstrac_id')->toArray();

    $abstrac = $allAbstrac->reject(function ($allAbstrac) use ($usedAbstrac) {
      return in_array($allAbstrac->id, $usedAbstrac);
    });

    // create form
    return view('papers/create', [
      'abstracs' => $abstrac->whereNotNull('ticket_user_id')->where('creator_id', $user->id),
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
    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    $validInput['status_id'] = 2;

    
    $files = $this->upload(['file'], null, 'fp_'.$validInput['abstrac_id']);
    $provement = $this->upload(['provement'], null, 'pymn_fp_'.$validInput['abstrac_id']);
    $validInput['file'] = $files['file'];
    $validInput['provement'] = $provement['provement'];
    
    // dd($files);
    $paper = Paper::create($validInput);
    $paper->file = $files['file'];
    $paper->provement = $provement['provement'];

    $paper->save();
    // send email to user
    $abstract = Abstrac::find($validInput['abstrac_id']);

    $emails = $abstract->emails;
    $emailArray = explode(',', $emails);
    $emails = array_map('trim', $emailArray);
    $title = $abstract->title;

    $mail = set_mail(
      'Your Paper Succecfully Submitted',
      "Hello! $title paper has been submited. If you did not make this change, please contact our customer service.",
      base_url('/papers/index'),
      'Go to Papers'
    );

    foreach ($emails as $email) {

      if (!send_email($mail, $email)) {
        $error = 'Failed to send email to ' . $email . ', please make sure your email is valid and try again. If the problem persists, please contact our customer service.';
      }
    }

    $response = [
      'success' => 'Payment data has been updated successfully',
    ];

    if (isset($error)) $response['error'] = $error;

    // redirect
    return redirect()->to('/papers/')->with('messages', $response);
  }

  public function edit($id = null)
  {
    // find data
    $paper = Paper::find($id);

    $user = $this->getUser();

    // option abstract
    $allAbstrac = Abstrac::all();
    $usedAbstrac = Paper::where('abstrac_id', '!=', $paper->abstrac_id)->pluck('abstrac_id')->toArray();

    $abstrac = $allAbstrac->reject(function ($allAbstrac) use ($usedAbstrac) {
      return in_array($allAbstrac->id, $usedAbstrac);
    });

    // throw error if the data is not found
    if ($id == null || !$paper)
      throw new PageNotFoundException();

    // disable edit if paper already paid
    if($paper->status_id == 4){
      $response = [
        'success' => 'This paper already confirmed',
      ];
  
      if (isset($error)) $response['error'] = $error;
  
      // redirect
      return redirect()->to('/papers/')->with('messages', $response);
    }

    // return view
    return view('papers/edit', [
      'user' => $user->role->code,
      'paper' => $paper,
      'abstracs' => $abstrac->whereNotNull('ticket_user_id')->where('creator_id', $user->id),
      'publications' => Publication::all(),
      'statuses' => Status::whereHas('stype', function ($query) {
        $query->where('code', '0');
      })->get(),
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
    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    $paper = Paper::find($validInput['id']);
    $files = $this->upload(['file'], null, 'fp_'.$paper->abstrac_id);
    $provement = $this->upload(['provement'], null, 'pymn_fp_'.$paper->abstrac_id);

    if (!isset($files['file'])) {
      unset($validInput['file']);
    } else {
      if ($paper->file && str_contains($paper->file, base_url())) {
        unlink(FCPATH . str_replace(base_url(), '', $paper->file));
      }
      $validInput['file'] = $files['file'];
    }

    if (!isset($provement['provement'])) {
      unset($validInput['provement']);
    } else {
      if ($paper->provement && str_contains($paper->provement, base_url())) {
        unlink(FCPATH . str_replace(base_url(), '', $paper->provement));
      }
      $validInput['provement'] = $provement['provement'];
    }

    $paper->update($validInput);


    // send email to user
    $emails = $paper->abstrac->emails;
    $emailArray = explode(',', $emails);
    $emails = array_map('trim', $emailArray);
    $title = $paper->abstrac->title;


    if (isset($validInput['status_id'])) {
      $mail = set_mail(
        'Your Paper Payment Status has Been Changed',
        "Hello! $title payment status has been changed. Let's check it!",
        base_url('/papers/index'),
        'Go to Paper Page'
      );

      foreach ($emails as $email) {
        if (!send_email($mail, $email)) {
          $error = 'Failed to send email to ' . $email . ', please make sure your email is valid and try again. If the problem persists, please contact our customer service.';
        }
      }
    } else {
      $mail = set_mail(
        'Your Paper has Been Updated',
        "Hello! Data paper $title has been updated. Let's check it!",
        base_url('/papers/index'),
        'Go to Paper Page'
      );

      foreach ($emails as $email) {
        if (!send_email($mail, $email)) {
          $error = 'Failed to send email to ' . $email . ', please make sure your email is valid and try again. If the problem persists, please contact our customer service.';
        }
      }
    }

    $response = [
      'success' => 'Paper data has been updated successfully',
    ];

    if (isset($error)) $response['error'] = $error;

    // redirect
    return redirect()->to('/papers/')->with('messages', $response);
  }

  public function delete($id = null)
  {
    // find data
    $paper = Paper::find($id);

    // throw error if the data is not found
    if (!$paper)
      throw new PageNotFoundException();

    // delete data
    $paper->delete();

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $paper = Paper::withTrashed()->find($id);

    // throw error if the paper is not found
    if (!$paper)
      throw new PageNotFoundException();

    // restore data
    $paper->restore();

    // redirect
    return redirect()->to('/papers/')->with('message', 'Paper data has been restored successfully');
  }
}
