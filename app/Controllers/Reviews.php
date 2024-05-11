<?php

namespace App\Controllers;

use App\Models\Abstrac;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Review;
use App\Models\Status;

class Reviews extends BaseController
{
  protected $rule = [
    'store' => [
      'comment' => 'required|string',
      'file' => 'uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
      'status_id' => 'required|is_not_unique[statuses.id]',
    ],
    'update' => [
      'id' => 'required|is_not_unique[reviews.id]',
    ],
  ];

  protected $abstract;

  public function __construct()
  {
    parent::__construct();
    $this->isNeedLogin();

    // if the first segment is not 'abstracs', return 404. else, set the abstract_id from the second segment
    if (service('uri')->getSegment(1) != 'abstracs') throw new PageNotFoundException();
    $abstract_id = service('uri')->getSegment(2);
    $this->abstract = Abstrac::find($abstract_id);
    if (!$this->abstract) throw new PageNotFoundException();
  }

  public function index()
  {
    // main view
    return view('reviews/index', [
      'reviews' => $this->abstract->load('reviews')->reviews->sortByDesc('created_at'),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Reviews for "' . $this->abstract->title . '"',
      'deleted' => $this->abstract->reviews()->onlyTrashed()->get()->sortByDesc('created_at'),
      'abstract_id' => $this->abstract->id,
    ]);
  }

  public function create()
  {
    // create form
    return view('reviews/create', [
      'title' => 'New Review',
      'abstract' => $this->abstract,
      // status where stype.code is 1
      'statuses' => Status::whereHas('stype', function ($query) {
        $query->where('code', 1);
      })->get()
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
    if (!$validInput) return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    $files = $this->upload(['file']);
    if (!isset($files['file'])) {
      unset($validInput['file']);
    } else {
      $validInput['file'] = $files['file'];
    }

    $validInput['abstrac_id'] = $this->abstract->id;

    $this->abstract->status_id = $validInput['status_id'];
    $this->abstract->save();

    Review::create($validInput);

    // redirect
    return redirect()->to("/abstracs/" . $this->abstract->id . "/reviews/")->with('message', 'Review data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $review = Review::find($id);

    // throw error if the data is not found
    if ($id == null || !$review) throw new PageNotFoundException();

    // return view
    return view('reviews/edit', [
      'review' => $review,
      'title' => 'Edit Review'
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
    $review = Review::find($validInput['id']);
    $review->update($validInput);

    // redirect
    return redirect()->to("/abstracs/" . $this->abstract->id . "/reviews/")->with('message', 'Review data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $review = Review::find($id);

    // throw error if the data is not found
    if (!$review) throw new PageNotFoundException();

    // delete data
    $review->delete();

    // redirect
    return redirect()->to("/abstracs/" . $this->abstract->id . "/reviews/")->with('message', 'Review data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $review = Review::withTrashed()->find($id);

    // throw error if the review is not found
    if (!$review) throw new PageNotFoundException();

    // restore data
    $review->restore();

    // redirect
    return redirect()->to("/abstracs/" . $this->abstract->id . "/reviews/")->with('message', 'Review data has been restored successfully');
  }
}
