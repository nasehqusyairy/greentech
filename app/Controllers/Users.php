<?php

namespace App\Controllers;

use App\Models\Role;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\User;

class Users extends BaseController
{
  protected $rule = [
    'store' => [
      'name' => 'required|alpha_numeric_punct',
      'email' => 'required|valid_email|is_unique[users.email]',
      'password' => 'required|min_length[8]|max_length[255]',
      'confirm_password' => 'matches[password]',
      'role_id' => 'required|is_not_unique[roles.id]',

      'phone' => 'required|numeric',
      'institution' => 'required|alpha_numeric_punct',
      'image' => 'permit_empty|max_size[image,3072]|is_image[image]',
      'gender' => 'required|in_list[0,1,2]',
      'callingcode' => 'required|alpha_numeric_punct',
    ],
    'update' => [
      'id' => 'required|is_not_unique[users.id]',
      'name' => 'required|alpha_numeric_punct',
      'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
      'password' => 'permit_empty|min_length[8]|max_length[255]',
      'confirm_password' => 'matches[password]',
      'role_id' => 'required|is_not_unique[roles.id]',

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
    $users = User::with('role');
    // main view
    return view('users/index', [
      'users' => $users->get(),
      'deleted' => $users->onlyTrashed()->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Users'
    ]);
  }

  public function create()
  {
    // create form
    return view('users/create', [
      'title' => 'New User',
      'roles' => Role::where('code', '!=', 0)->get()
    ]);
  }

  public function store()
  {
    // check if the request is POST
    $this->isPostRequest();

    // country must be matched with the cca2 country list from https://restcountries.com/v3.1/all?fields=name,cca2,idd
    // $this->rule['store']['country'] = $this->getCountryRules();
    $this->rule['store']['country'] = 'required|alpha';

    // set validation rules
    $this->validator->setRules($this->rule['store']);

    // validated input
    $validInput = $this->validInput(['image']);

    // return response if the input is invalid
    if (!$validInput) return $this->invalidInputResponse($this->validator->getErrors());

    // manipulate data here
    $files = $this->upload(['image'], function ($newName, $newLocation) {
      // crop image
      $this->cropImage(FCPATH . $newLocation . '/' . $newName, FCPATH . $newLocation . '/' . $newName);
    });

    if (!isset($files['image'])) {
      unset($validInput['image']);
    } else {
      $validInput['image'] = $files['image'];
    }

    // create activation code
    $validInput['activationCode'] = bin2hex(random_bytes(32));

    $role = Role::find($validInput['role_id'])->name;

    // send email
    $mail = set_mail(
      'Welcome to our community',
      "Hello, <strong>$validInput[name]</strong>! We're excited to have you as part of our community as <strong>$role</strong>. Here is your credentials:<table><tr><td>Email</td><td> : </td><td>$validInput[email]</td></tr><tr><td>Password</td><td> : </td><td>$validInput[password]</td></tr></table> To get started, please activate your account by clicking the button below.",
      base_url('/auth/activate/' . $validInput['activationCode']),
      'Activate Account'
    );

    if (!send_email($mail, $validInput['email'])) {
      return redirect()->back()->withInput()->with('message', 'Failed to send email, please make sure your email is valid and try again. If the problem persists, please contact our customer service.');
    }

    // hash password
    $validInput['password'] = password_hash($validInput['password'], PASSWORD_DEFAULT);

    User::create($validInput);

    // redirect
    return redirect()->to('/users/index')->with('message', 'User data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $user = User::find($id);

    // throw error if the data is not found
    if ($id == null || !$user) throw new PageNotFoundException();

    // return view
    return view('users/edit', [
      'user' => $user,
      'roles' => Role::where('code', '!=', 0)->get(),
      'title' => 'Edit User'
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

    // hash password if it's not empty
    if (!empty($validInput['password'])) {
      $validInput['password'] = password_hash($validInput['password'], PASSWORD_DEFAULT);
    } else {
      unset($validInput['password']);
    }

    $user->update($validInput);

    // set mail
    $mail = set_mail(
      'Your account has been updated',
      "Hello, <strong>$validInput[name]</strong>! Your account has been updated. If you did not make this change, please contact our customer service.",
      base_url('/profile/index'),
      'Go to Profile'
    );

    // send email
    if (!send_email($mail, $validInput['email'])) {
      return redirect()->back()->withInput()->with('message', 'Failed to send email, please make sure your email is valid and try again. If the problem persists, please contact our customer service.');
    }

    // redirect
    return redirect()->to('/users/index')->with('message', 'User data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $user = User::find($id)->load('role');

    // throw error if the data is not found
    if (!$user || $user->role->code == 0) throw new PageNotFoundException();

    // delete data
    $user->delete();

    // redirect
    return redirect()->to('/users/index')->with('message', 'User data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $user = User::withTrashed()->find($id);

    // throw error if the user is not found
    if (!$user) throw new PageNotFoundException();

    // restore data
    $user->restore();

    // redirect
    return redirect()->to('/users')->with('message', 'User data has been restored successfully');
  }

  public function export()
  {
    $users = User::with('role')->where('role_id', '!=', 0)->where('isActive', 1)->get();

    // set header to xls
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="users.xls"');

    return view('users/export', [
      'users' => $users,
    ]);
  }
}
