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
      'abstrac_id' => 'required|is_not_unique[abstracs.id]',
      'comment' => 'required|string',
      'file' => 'uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
      'status_id' => 'required|is_not_unique[statuses.id]',
    ],
    'update' => [
      'id' => 'required|is_not_unique[reviews.id]',
      'comment' => 'required|string',
      'file' => 'permit_empty|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
      'status_id' => 'required|is_not_unique[statuses.id]',
    ],
  ];

  public function __construct()
  {
    parent::__construct();
    $this->isNeedLogin();

    // if the first segment is not 'abstracs', return 404. else, set the abstract_id from the second segment
    // if (service('uri')->getSegment(1) != 'abstracs') throw new PageNotFoundException();
    // $abstract_id = service('uri')->getSegment(2);
    // $abstract = Abstrac::find($abstract_id);
    // if (!$abstract) throw new PageNotFoundException();
  }

  private function getAbstract()
  {
    $request = service('request');

    // Mendapatkan nilai query string
    $abstract_id = $request->getGet('abstract_id');
    $abstract = Abstrac::find($abstract_id);
    if (!$abstract) throw new PageNotFoundException();
    return $abstract;
  }

  public function index()
  {

    $abstract = $this->getAbstract();

    // main view
    return view('reviews/index', [
      'reviews' => $abstract->load('reviews')->reviews->sortByDesc('created_at')->sortByDesc('updated_at'),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Reviews for "' . $abstract->title . '"',
      'deleted' => $abstract->reviews()->onlyTrashed()->get()->sortByDesc('created_at')->sortByDesc('updated_at'),
      'abstract_id' => $abstract->id,
    ]);
  }

  public function create()
  {

    $abstract = $this->getAbstract();

    // create form
    return view('reviews/create', [
      'title' => 'New Review',
      'abstract' => $abstract,
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

    $abstract = Abstrac::find($validInput['abstrac_id']);

    $abstract->status_id = $validInput['status_id'];
    $abstract->save();

    $review = Review::create($validInput);

    // redirect
    return redirect()->to("/reviews/?abstract_id=$review->abstrac_id")->with('message', 'Review data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $review = Review::find($id)->load('abstrac');

    // dd($review->toArray());

    // throw error if the data is not found
    if ($id == null || !$review) throw new PageNotFoundException();
    $abstract = $this->getAbstract();

    // return view
    return view('reviews/edit', [
      'abstract' => $abstract,
      'review' => $review,
      'title' => 'Edit Review',
      'statuses' => Status::whereHas('stype', function ($query) {
        $query->where('code', 1);
      })->get()
    ]);
  }

  public function update()
  {
    // check if the request is POST
    $this->isPostRequest();

    // set validation rules
    $this->validator->setRules($this->rule['update']);

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

    $review = Review::find($validInput['id'])->load('abstrac');
    $review->update($validInput);

    $review->abstrac->status_id = $validInput['status_id'];
    $review->abstrac->save();

    // redirect
    return redirect()->to("/reviews/?abstract_id=" . $review->abstrac->id)->with('message', 'Review data has been updated successfully');
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
    return redirect()->to("/reviews/?abstract_id=" . $review->abstrac_id)->with('message', 'Review data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $review = Review::withTrashed()->find($id);

    // throw error if the review is not found
    if (!$review) throw new PageNotFoundException();

    // restore data
    $review->restore();

    // redirect
    return redirect()->to("/reviews/?abstract_id=" . $review->abstrac_id)->with('message', 'Review data has been restored successfully');
  }
}
