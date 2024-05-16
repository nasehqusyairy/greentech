<?php

namespace App\Controllers;

use App\Models\User;

class Profile extends BaseController
{
  protected $rule = [
    'store' => [],
    'update' => [
      'id' => 'required|is_not_unique[users.id]',
      'name' => 'required|alpha_numeric_punct',
      'phone' => 'required|numeric',
      'institution' => 'required|alpha_numeric_punct',
      'image' => 'permit_empty|max_size[image,3072]|is_image[image]',
      'gender' => 'required|in_list[0,1,2]',
      'callingcode' => 'required|alpha_numeric_punct',
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
    return view('profile/index', [
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Profile'
    ]);
  }

  public function update()
  {
    // check if the request is POST
    $this->isPostRequest();

    // country must be matched with the cca2 country list from https://restcountries.com/v3.1/all?fields=name,cca2,idd
    // $this->rule['update']['country'] = $this->getCountryRules();
    $this->rule['update']['country'] = 'required|alpha';

    // set validation rules
    $this->validator->setRules($this->rule['update']);

    // validated input
    $validInput = $this->validInput(['image']);

    // return response if the input is invalid
    if (!$validInput) return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    $files = $this->upload(['image'], function ($newName, $newLocation) {
      // crop image
      $this->cropImage(FCPATH . $newLocation . '/' . $newName, FCPATH . $newLocation . '/' . $newName);
    });

    $user = User::find($validInput['id']);
    // delete old image
    if (!isset($files['image'])) {
      unset($validInput['image']);
    } else {
      if ($user->image && str_contains($user->image, base_url())) {
        unlink(FCPATH . str_replace('/', '\\', str_replace(base_url(), '', $user->image)));
      }
      $validInput['image'] = $files['image'];
    }

    // set mail
    $mail = set_mail(
      'Your account has been updated',
      "Hello, <strong>$validInput[name]</strong>! Your account has been updated. If you did not make this change, please contact our customer service.",
      base_url('/profile/index'),
      'Go to Profile'
    );

    // send email
    if (!send_email($mail, $user->email)) {
      return redirect()->back()->withInput()->with('message', 'Failed to send email, please make sure your email is valid and try again. If the problem persists, please contact our customer service.');
    }

    $user->update($validInput);

    // redirect
    return redirect()->to('/profile/index')->with('message', 'User data has been updated successfully');
  }
}
