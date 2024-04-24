<?php

namespace App\Controllers;

use App\Exceptions\HTTPException;
use App\Models\Role;
use App\Models\User;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    protected $rule = [
        'store' => [
            'name' => 'required|alpha_numeric_punct',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]',
            'role_id' => 'required|is_not_unique[roles.id]',
        ],
        'update' => [
            'id' => 'required|is_not_unique[users.id]',
            'name' => 'required|alpha_numeric_punct',
            'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
            'role_id' => 'required|is_not_unique[roles.id]',
        ],
    ];

    public function __construct()
    {
        $this->isNeedLogin();
        parent::__construct();
    }

    public function index()
    {
        // dd($_SERVER);
        echo $this->session->has('message') ? $this->session->get('message') : '';
        echo '<a href="' . base_url('auth/logout') . '">Logout</a>';
        dd(User::all()->toArray());
    }

    public function create()
    {
        return view('user/create', [
            'roles' => Role::all(),
        ]);
    }

    public function edit($id = null)
    {
        $user = User::find($id);

        if ($id == null || !$user) throw new PageNotFoundException();

        return view('user/edit', [
            'user' => $user,
            'roles' => Role::all(),
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
        $user = User::find($validInput['id']);
        $user->update($validInput);

        // redirect
        return redirect()->to('/home/index')->with('message', 'The data has been updated successfully');
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
        $validInput['password'] = password_hash($validInput['password'], PASSWORD_DEFAULT);

        $user = new User();
        $user->create($validInput);

        // redirect
        return redirect()->to('/home/index')->with('message', 'The data has been saved successfully');
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) throw new PageNotFoundException();

        $user->delete();

        return redirect()->to('/home/index')->with('message', 'The data has been deleted successfully');
    }
}
