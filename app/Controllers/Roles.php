<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Role;

class Roles extends BaseController
{
  protected $rule = [
    'store' => [
      'code' => 'required|is_unique[roles.code]',
      'name' => 'required|alpha_numeric_punct',
    ],
    'update' => [
      'id' => 'required|is_not_unique[roles.id]',
      'code' => 'required|is_unique[roles.code,roles.id,{id}]',
      'name' => 'required|alpha_numeric_punct',
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
    return view('roles/index', [
      'title' => 'Roles',
      'roles' => Role::where('code', '!=', '0')->get(),
      'deleted' => Role::onlyTrashed()->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : ''
    ]);
    // dd(Role::all()->toArray());
  }

  public function create()
  {
    // create form
    return view('roles/create', [
      'title' => 'New Role'
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
    $role = new Role();
    $role->create($validInput);

    // redirect
    return redirect()->to('/roles')->with('message', 'Role data has been saved successfully');
  }

  public function edit($id)
  {
    // edit form
    $role = Role::find($id);

    // throw error if the role is not found
    if ($id == null || !$role) throw new PageNotFoundException();

    // return view
    return view('roles/edit', [
      'role' => $role,
      'title' => 'Edit Role'
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

    // dd($validInput);

    // manipulate data here
    $role = Role::find($validInput['id']);
    $role->update($validInput);

    // redirect
    return redirect()->to('/roles/index')->with('message', 'Role data has been updated successfully');
  }

  public function delete($id)
  {
    // delete data
    $role = Role::find($id);

    // throw error if the role is not found
    if (!$role) throw new PageNotFoundException();

    // delete data
    $role->delete();

    // redirect
    return redirect()->to('/roles')->with('message', 'Role data has been deleted successfully');
  }

  public function restore($id)
  {
    $role = Role::withTrashed()->find($id);

    // throw error if the role is not found
    if (!$role) throw new PageNotFoundException();

    // restore data
    $role->restore();

    // redirect
    return redirect()->to('/roles')->with('message', 'Role data has been restored successfully');
  }
}
