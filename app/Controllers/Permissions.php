<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Permission;
use App\Models\Role;

class Permissions extends BaseController
{
  protected $rule = [
    'store' => [
      'path' => 'required|is_unique[permissions.path]',
    ],
    'update' => [
      'id' => 'required|is_not_unique[permissions.id]',
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
    return view('permissions/index', [
      'permissions' => Permission::all(),
      'deleted' => Permission::onlyTrashed()->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Permissions'
    ]);
  }

  public function create()
  {
    // create form
    return view('permissions/create', [
      'title' => 'New Permission'
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
    Permission::create($validInput);

    // redirect
    return redirect()->to('/permissions/')->with('message', 'Permission data has been saved successfully');
  }

  public function edit($id)
  {
    // find data
    $permission = Permission::find($id);

    // throw error if the data is not found
    if ($id == null || !$permission) throw new PageNotFoundException();

    // return view
    return view('permissions/edit', [
      'permission' => $permission,
      'title' => 'Edit Permission'
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
    $permission = Permission::find($validInput['id']);
    $permission->update($validInput);

    // redirect
    return redirect()->to('/permissions/')->with('message', 'Permission data has been updated successfully');
  }

  public function delete($id)
  {
    // find data
    $permission = Permission::find($id);

    // throw error if the data is not found
    if (!$permission) throw new PageNotFoundException();

    // delete data
    $permission->delete();

    // redirect
    return redirect()->to('/permissions/')->with('message', 'Permission data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $permission = Permission::withTrashed()->find($id);

    // throw error if the permission is not found
    if (!$permission) throw new PageNotFoundException();

    // restore data
    $permission->restore();

    // redirect
    return redirect()->to('/permissions/')->with('message', 'Permission data has been restored successfully');
  }
  public function addRoles($id = null)
  {
    // find data
    /** @disregard */
    $permission = Permission::find($id);

    // throw error if the data is not found
    if (!$permission) throw new PageNotFoundException();

    if ($this->request->is('post')) {

      // validate input
      $this->validator->setRules([
        'role_id' => 'required|is_not_unique[roles.id]'
      ]);

      // validated input
      $validInput = $this->validInput();

      // return response if the input is invalid
      if (!$validInput) return $this->invalidInputResponse($this->validator->getErrors());

      // avoid duplicate data
      if ($permission->roles()->where('role_id', $validInput['role_id'])->count() > 0) {
        return redirect()->to('/permissions/addroles/' . $permission->id)->with('errors', ['role' => 'Role already exists']);
      }

      // add role
      $permission->roles()->attach($validInput['role_id']);

      // redirect
      return redirect()->to('/permissions/addroles/' . $permission->id)->with('message', 'Role has been added successfully');
    }

    // return view
    return view('permissions/addroles', [
      'permission' => $permission->load('roles'),
      'roles' => Role::all(),
      'title' => 'Add Roles to "/' . $permission->path . '"'
    ]);
  }

  public function removeRole($permissionId = null, $roleId)
  {
    // find data
    /** @disregard */
    $permission = Permission::find($permissionId);

    // throw error if the data is not found
    if (!$permission) throw new PageNotFoundException();

    // remove role
    $permission->roles()->detach($roleId);

    // redirect
    return redirect()->to('/permissions/addroles/' . $permissionId)->with('message', 'Role has been removed successfully');
  }
}
