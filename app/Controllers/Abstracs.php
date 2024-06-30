<?php

namespace App\Controllers;

use App\Models\Review;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Abstrac;
use App\Models\Topic;
use App\Models\User;
use App\Models\Setting;
use App\Models\Status;

class Abstracs extends BaseController
{

  protected $rule = [
    'store' => [
      'topic_id' => 'required|is_not_unique[topics.id]',
      'title' => 'required|string',
      'authors' => 'required|string',
      'emails' => 'required|valid_emails',
      'text' => 'required|string',
      'file' => 'uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
      'creator_id' => 'required|is_not_unique[users.id]',
    ],

  ];

  public function __construct()
  {
    parent::__construct();
    $this->isNeedLogin();
  }

  // public function tes()
  // {

  //   Review::updateOrCreate([
  //     'abstrac_id' => 1
  //   ], [
  //     'comment' => 'tes',
  //     'file' => 'tes',
  //     'status_id' => 1
  //   ]);
  //   dd(Abstrac::find(1)->load('review')->toArray());
  // }

  public function reviews($abstract_id)
  {
    $abstract = Abstrac::find($abstract_id);
    if (!$abstract)
      throw new PageNotFoundException();

    return view('reviews/index', [
      // 'abstract_id' => $abstract->id,
    ]);
  }

  public function index()
  {
    $abstract = Abstrac::with('creator', 'topic', 'reviewer');

    $user = $this->getUser();
    if ($user->role->code == 3) {
      $abstract = $abstract->where('creator_id', $user->id);
    } else if ($user->role->code == 2) {
      $abstract = $abstract->where('reviewer_id', $user->id);
    }

    // main view
    return view('abstracs/index', [
      'user' => $user,
      'abstracts' => $abstract->get()->sortBy('topic_id'),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Abstracts',
      'deleted' => Abstrac::onlyTrashed()->with('creator', 'topic', 'reviewer')->get()->sortBy('topic_id'),
    ]);
  }

  public function create()
  {
    $setting = Setting::where('code', '1')->first()->value;
    if ($setting != '1') {
      return redirect()->to('/abstracs/')->with('errors', ['Submission has been closed']);
    }
    // create form
    return view('abstracs/create', [
      'title' => 'New Abstract',
      'topics' => Topic::all()
    ]);
  }

  public function store()
  {
    // check if the request is POST
    $this->isPostRequest();

    // set validation rules
    $this->validator->setRules($this->rule['store']);

    // validated input
    $validInput = $this->validInput(['file']);

    // return response if the input is invalid
    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    $validInput['status_id'] = Status::where('code', '5')->first()->id;
    $abstract = Abstrac::create($validInput);
    $file = $this->upload(['file'], null, 'abs_' . $abstract->id);
    $abstract->file = $file['file'];
    $abstract->save();

    // send email to user
    $emails = $validInput['emails'];
    $emailArray = explode(',', $emails);
    $emails = array_map('trim', $emailArray);
    $title = $validInput['title'];

    $mail = set_mail(
      'Your Abstract Succecfully Submitted',
      "Hello! $title has been submited. If you did not make this change, please contact our service.",
      base_url('/abstracs/index'),
      'Go to Abstract'
    );

    foreach ($emails as $email) {
      if (!send_email($mail, $email)) {
        $error = 'Failed to send email to <b>' . $email . '</b>, please make sure your email is valid and try again. If the problem persists, please contact our customer service.';
      }
    }
    $response = [
      'success' => 'Abstract data has been saved successfully',
    ];

    if (isset($error))
      $response['error'] = $error;

    // redirect
    return redirect()->to('/abstracs/')->with('messages', $response);
  }

  public function edit($id = null)
  {
    // find data
    $abstrac = Abstrac::find($id);

    // throw error if the data is not found
    if ($id == null || !$abstrac)
      throw new PageNotFoundException();

    //cek accepted abstract
    $response = [
      'success' => "Can't edit accepted abstract",
    ];

    if ($abstrac->status->id == 8 || $abstrac->status->id == 4) {
      return redirect()->to('/abstracs/')->with('messages', $response);
    }

    // return view
    return view('abstracs/edit', [
      'abstract' => $abstrac,
      'user' => $this->getUser(),
      'topics' => Topic::all(),
      'reviewers' => User::with('role')->whereHas('role', function ($query) {
        $query->where('code', 2);
      })->get(),
      'title' => 'Edit Abstract'
    ]);
  }

  public function detail($id = null)
  {
    // find data
    $abstrac = Abstrac::find($id)->load('creator', 'topic', 'reviewer', 'ticketUser');

    // throw error if the data is not found
    if ($id == null || !$abstrac)
      throw new PageNotFoundException();

    // return view
    return view('abstracs/detail', [
      'abstract' => $abstrac,
      'title' => 'Abstract Details'
    ]);
  }

  public function update()
  {
    // check if the request is POST
    $this->isPostRequest();

    $user = $this->getUser();

    $this->rule['update'] = $user->role->code == '3' ? [
      'id' => 'required|is_not_unique[abstracs.id]',
      'topic_id' => 'required|is_not_unique[topics.id]',
      'title' => 'required|string',
      'authors' => 'required|string',
      'emails' => 'required|valid_emails',
      'text' => 'required|string',
      'file' => 'permit_empty|uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
    ] : [
      'reviewer_id' => 'permit_empty|is_not_unique[users.id]',
      'id' => 'required|is_not_unique[abstracs.id]',
    ];
    $this->validator->setRules($this->rule['update']);
    $validInput = $this->validInput($user->role->code == '3' ? ['file'] : null);

    // return response if the input is invalid
    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    $abstrac = Abstrac::find($validInput['id']);

    $unsignStatus = Status::where('code', '5')->first()->id;
    $reviewStatus = Status::where('code', '6')->first()->id;

    if ($user->role->code == '3') {
      $files = $this->upload(['file'], null, 'abs_' . $validInput['id']);
      // delete old file
      if (!isset($files['file'])) {
        unset($validInput['file']);
      } else {
        if ($abstrac->file && str_contains($abstrac->file, base_url())) {
          unlink(FCPATH . str_replace(base_url(), '', $abstrac->file));
        }
        $validInput['file'] = $files['file'];
      }
    }

    if (!isset($validInput['reviewer_id'])) {
      $validInput['status_id'] = $reviewStatus;
      if (!$abstrac->reviewer_id) {
        $validInput['status_id'] = $unsignStatus;
      }
    } else {
      $validInput['status_id'] = $reviewStatus;
    }

    $abstrac->update($validInput);

    // redirect
    return redirect()->to('/abstracs/')->with('message', 'Abstrac data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $abstrac = Abstrac::find($id);

    // throw error if the data is not found
    if (!$abstrac)
      throw new PageNotFoundException();

    // delete data
    $abstrac->delete();

    // redirect
    return redirect()->to('/abstracs/')->with('message', 'Abstrac data has been deleted successfully');
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
    return redirect()->to('/abstracs/')->with('message', 'Abstrac data has been restored successfully');
  }
}
