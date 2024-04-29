<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Review;

class Reviews extends BaseController
{
    protected $rule = [
      'store'=> [],
      'update'=> [
        'id' => 'required|is_not_unique[reviews.id]',
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
      // return view('reviews/index',[
      //   'reviews' => Review::all(),
      //   'message' => $this->session->has('message') ? $this->session->get('message') : '',
      //   'title' => 'Reviews'
      // ]);
      dd(Review::all()->toArray());
    }

    public function create()
    {
      // create form
      return view('reviews/create',[
        'title' => 'New Review'
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
      Review::create($validInput);

      // redirect
      return redirect()->to('/reviews/')->with('message', 'Review data has been saved successfully');
    }

    public function edit($id)
    {
      // find data
      $review = Review::find($id);

      // throw error if the data is not found
      if ($id == null || !$review) throw new PageNotFoundException();

      // return view
      return view('reviews/edit',[
        'review'=>$review,
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
      return redirect()->to('/reviews/')->with('message', 'Review data has been updated successfully');
    }
    
    public function delete($id)
    {
        // find data
        $review = Review::find($id);

        // throw error if the data is not found
        if (!$review) throw new PageNotFoundException();

        // delete data
        $review->delete();

        // redirect
        return redirect()->to('/reviews/')->with('message', 'Review data has been deleted successfully');
    }
    public function restore($id = null)
    {
      $review = Review::withTrashed()->find($id);

      // throw error if the review is not found
      if (!$review) throw new PageNotFoundException();

      // restore data
      $review->restore();

      // redirect
      return redirect()->to('/reviews/')->with('message', 'Review data has been restored successfully');
    }
}
