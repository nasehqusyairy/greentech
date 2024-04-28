<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Menu;
use App\Models\Role;

class Menus extends BaseController
{
  protected $rule = [
    'store' => [
      'name' => 'required|alpha_numeric_punct|is_unique[menus.name]',
    ],
    'update' => [
      'id' => 'required|is_not_unique[menus.id]',
      'name' => 'required|alpha_numeric_punct|is_unique[menus.name,id,{id}]',
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
    /** @disregard */
    $menus = Menu::all();
    return view('menus/index', [
      'menus' => $menus,
      'deleted' => Menu::onlyTrashed()->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Menus'
    ]);
  }

  public function create()
  {
    // create form
    return view('menus/create', [
      'title' => 'New Menu'
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
    /** @disregard */
    Menu::create($validInput);

    // redirect
    return redirect()->to('/menus/')->with('message', 'Menu data has been saved successfully');
  }

  public function edit($id)
  {
    // find data
    /** @disregard */
    $menu = Menu::find($id);

    // throw error if the data is not found
    if ($id == null || !$menu) throw new PageNotFoundException();

    // return view
    return view('menus/edit', [
      'menu' => $menu,
      'title' => 'Edit Menu'
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
    /** @disregard */
    $menu = Menu::find($validInput['id']);
    $menu->update($validInput);

    // redirect
    return redirect()->to('/menus/')->with('message', 'Menu data has been updated successfully');
  }

  public function delete($id)
  {
    // find data
    /** @disregard */
    $menu = Menu::find($id);

    // throw error if the data is not found
    if (!$menu) throw new PageNotFoundException();

    // delete data
    $menu->delete();

    // redirect
    return redirect()->to('/menus/')->with('message', 'Menu data has been deleted successfully');
  }
  public function restore($id = null)
  {
    /** @disregard */
    $menu = Menu::withTrashed()->find($id);

    // throw error if the menu is not found
    if (!$menu) throw new PageNotFoundException();

    // restore data
    $menu->restore();

    // redirect
    return redirect()->to('/menus/')->with('message', 'Menu data has been restored successfully');
  }

  public function addRoles($id = null)
  {
    // find data
    /** @disregard */
    $menu = Menu::find($id);

    // throw error if the data is not found
    if (!$menu) throw new PageNotFoundException();

    if ($this->request->is('post')) {

      // validate input
      $this->validator->setRules([
        'role_id' => 'required|is_not_unique[roles.id]'
      ]);

      // validated input
      $validInput = $this->validInput();

      // add role
      $menu->roles()->attach($validInput['role_id']);

      // redirect
      return redirect()->to('/menus/addroles/' . $menu->id)->with('message', 'Role has been added successfully');
    }

    // return view
    return view('menus/addroles', [
      'menu' => $menu->load('roles'),
      'roles' => Role::all(),
      'title' => 'Add Roles to "' . $menu->name . '"'
    ]);
  }

  public function removeRole($menuId = null, $roleId)
  {
    // find data
    /** @disregard */
    $menu = Menu::find($menuId);

    // throw error if the data is not found
    if (!$menu) throw new PageNotFoundException();

    // remove role
    $menu->roles()->detach($roleId);

    // redirect
    return redirect()->to('/menus/addroles/' . $menuId)->with('message', 'Role has been removed successfully');
  }
}
