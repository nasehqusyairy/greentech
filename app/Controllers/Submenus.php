<?php

namespace App\Controllers;

use App\Models\Menu;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Submenu;

class Submenus extends BaseController
{
  protected $rule = [
    'store' => [
      'code' => 'required|alpha_numeric_punct|is_unique[submenus.code]',
      'menu_id' => 'required|alpha_numeric_punct|is_not_unique[menus.id]',
      'icon' => 'required|alpha_numeric_punct',
      'name' => 'required|alpha_numeric_punct',
      'url' => 'required|valid_url',
    ],
    'update' => [
      'id' => 'required|is_not_unique[submenus.id]',
      'code' => 'required|alpha_numeric_punct|is_unique[submenus.code,id,{id}]',
      'menu_id' => 'required|alpha_numeric_punct|is_not_unique[menus.id]',
      'icon' => 'required|alpha_numeric_punct',
      'name' => 'required|alpha_numeric_punct',
      'url' => 'required|valid_url',
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
    return view('submenus/index', [
      'submenus' => Submenu::with('menu')->orderBy('menu_id')->get(),
      'deleted' => Submenu::onlyTrashed()->orderBy('menu_id')->get(),
      'message' => $this->session->has('message') ? $this->session->get('message') : '',
      'title' => 'Submenus'
    ]);
  }

  public function create()
  {
    // create form
    /**@disregard */
    $menus = Menu::all();
    return view('submenus/create', [
      'title' => 'New Submenu',
      'menus' => $menus
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
    Submenu::create($validInput);

    // redirect
    return redirect()->to('/submenus/')->with('message', 'Submenu data has been saved successfully');
  }

  public function edit($id = null)
  {
    // find data
    $submenu = Submenu::find($id);

    // throw error if the data is not found
    if ($id == null || !$submenu) throw new PageNotFoundException();

    // return view
    /**@disregard */
    $menus = Menu::all();
    return view('submenus/edit', [
      'submenu' => $submenu,
      'menus' => $menus,
      'title' => 'Edit Submenu'
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
    $submenu = Submenu::find($validInput['id']);
    $submenu->update($validInput);

    // redirect
    return redirect()->to('/submenus/')->with('message', 'Submenu data has been updated successfully');
  }

  public function delete($id = null)
  {
    // find data
    $submenu = Submenu::find($id);

    // throw error if the data is not found
    if (!$submenu) throw new PageNotFoundException();

    // delete data
    $submenu->delete();

    // redirect
    return redirect()->to('/submenus/')->with('message', 'Submenu data has been deleted successfully');
  }
  public function restore($id = null)
  {
    $submenu = Submenu::withTrashed()->find($id);

    // throw error if the submenu is not found
    if (!$submenu) throw new PageNotFoundException();

    // restore data
    $submenu->restore();

    // redirect
    return redirect()->to('/submenus/')->with('message', 'Submenu data has been restored successfully');
  }
}
