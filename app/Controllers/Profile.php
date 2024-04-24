<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
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
    $this->isNeedLogin();
    parent::__construct();
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

    // country must be matched with the cca2 country list from https://restcountries.com/v3.1/all?fields=name,cca2,idd using file_get_contents
    $res = file_get_contents('https://restcountries.com/v3.1/all?fields=name,cca2,idd');
    $countries = json_decode($res);
    $countryList = [];
    foreach ($countries as $country) {
      $countryList[] = $country->cca2;
    }
    $this->rule['update']['country'] = 'in_list' . str_replace('"', '', json_encode($countryList));

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

    $user->update($validInput);

    // redirect
    return redirect()->to('/profile/index')->with('message', 'User data has been updated successfully');
  }
}
