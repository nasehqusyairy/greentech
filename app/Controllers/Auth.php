<?php

namespace App\Controllers;

use App\Models\Role;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\User;

class Auth extends BaseController
{
  protected $rule = [
    'store' => [
      'email' => 'required|valid_email|is_unique[users.email]',
      'name' => 'required|alpha_numeric_punct',
      'country' => 'required|alpha',
      'callingcode' => 'required|alpha_numeric_punct',
      'phone' => 'required|numeric',
      'institution' => 'required|alpha_numeric_punct',
      'gender' => 'required|in_list[0,1,2]',
      'role_id' => 'required|is_not_unique[roles.id]',
    ],
    'login' => [
      'email' => 'required|valid_email',
      'password' => 'required'
    ],
  ];

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    if ($this->session->has('user'))
      return redirect()->to('/profile');
    // main view
    return view('auth/index1');
  }

  public function login()
  {
    $this->isPostRequest();

    $this->validator->setRules($this->rule['login']);

    $validInput = $this->validInput();

    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    // get user by email including deleted user
    $user = User::withTrashed()->where('email', $validInput['email'])->first();

    if (!$user) {
      return $this->invalidInputResponse(['email' => 'Email is not registered']);
    }

    if (!$user->isActive) {
      return $this->invalidInputResponse(['email' => 'Email is not activated, please check your email to activate your account']);
    }

    // if deleted
    if ($user->deleted_at) {
      return $this->invalidInputResponse(['email' => 'Your account has been deleted, please contact our customer service']);
    }

    if (!password_verify($validInput['password'], $user->password)) {
      return $this->invalidInputResponse(['password' => 'Password is incorrect']);
    }

    $this->session->set('user', $user->id);

    return redirect()->to('/profile')->with('message', 'Login success, please complete your profile');
  }

  public function google()
  {
    $client = new \Google_Client();
    $client->setClientId(getenv('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(getenv('GOOGLE_REDIRECT_URI'));
    $client->addScope('email');
    $client->addScope('profile');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');
    $client->setIncludeGrantedScopes(true);

    return redirect()->to($client->createAuthUrl());
  }

  public function callback()
  {
    $client = new \Google_Client();
    $client->setClientId(getenv('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(getenv('GOOGLE_REDIRECT_URI'));
    $client->addScope('email');
    $client->addScope('profile');
    $client->setAccessType('offline');
    $client->setIncludeGrantedScopes(true);

    if ($this->request->getVar('code')) {
      $token = $client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
      $client->setAccessToken($token);

      if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
      }

      $google_oauth = new \Google\Service\Oauth2($client);
      $google_account_info = $google_oauth->userinfo->get();

      $preparedData = [
        'name' => $google_account_info->name,
        'email' => $google_account_info->email,
        'password' => password_hash(random_bytes(10), PASSWORD_DEFAULT), // random password
        'img' => $google_account_info->picture,
        'gender' => $google_account_info->gender ?? 0,
        'country' => $google_account_info->locale,
        'role_id' => Role::where('code', 3)->first()->id,
        'isActive' => 1
      ];

      // Lakukan sesuatu dengan data akun Google yang diterima
      $user = User::where('email', $google_account_info->email)->first();

      if (!$user) {
        // $user = User::create($preparedData);

        // $this->session->set('user', $preparedData);
        $this->session->set('user', $preparedData);

        return redirect()->to('auth/register');
      }
      $this->session->set('user', $user->id);
      return redirect()->to('/profile')->with('message', 'Login success, please complete your profile');
    }
  }

  public function logout()
  {
    $this->session->remove('user');

    return redirect()->to('/auth')->with('message', 'You have been logged out');
  }

  public function register()
  {
    $user = $this->session->get('user');

    return view('auth/register', [
      'roles' => Role::where([
        ['code', '!=', 0],
        ['code', '!=', 1]
      ])->get(),
      'user' => $user,
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
    if (!$validInput)
      return $this->invalidInputResponse($this->validator->getErrors());

    // create activation code
    $validInput['activationCode'] = bin2hex(random_bytes(32));

    $validInput['password'] = random_bytes(8);

    $mail = set_mail(
      'Welcome to our community',
      "Hello, <strong>$validInput[name]</strong>! Thanks for joining us! We're excited to have you as part of our community. To get started, please activate your account by clicking the button below.",
      base_url('/auth/activate/' . $validInput['activationCode']),
      'Activate Account'
    );

    if (!send_email($mail, $validInput['email'])) {
      $error = 'Failed to send email to ' . $validInput['email'] . ', please make sure your email is valid and try again. If the problem persists, please contact our customer service.';
    }

    $response = [
      'success' => 'Registration success',
    ];

    if (isset($error))
      $response['error'] = $error;

    // manipulate data here
    if (!empty($validInput['password'])) {
      $validInput['password'] = password_hash($validInput['password'], PASSWORD_DEFAULT);
    }

    $validInput['isActive'] = 0;
    User::create($validInput);

    $user = User::where('email', $validInput['email'])->first();
    $this->session->set('user', $user->id);

    // redirect
    return redirect()->to('/profile')->with('messages', $response);
  }

  public function activate($activationCode)
  {
    $user = User::where('activationCode', $activationCode)->first();

    if (!$user)
      throw new PageNotFoundException();

    $user->update([
      'isActive' => 1,
      'activationCode' => null
    ]);

    return redirect()->to('/auth')->with('message', 'Account has been activated, please login to continue');
  }

  public function forgot()
  {
    return view('auth/forgot');
  }

  public function reset($resetPasswordCode = null)
  {
    if ($resetPasswordCode) {
      if ($this->request->is('post')) {
        $user = User::where('resetPasswordCode', $resetPasswordCode)->first();
        if (!$user)
          throw new PageNotFoundException();

        $this->validator->setRules([
          'password' => 'required|min_length[8]|max_length[255]',
          'confirm_password' => 'required|matches[password]',
        ]);

        $validInput = $this->validInput();

        if (!$validInput)
          return $this->invalidInputResponse($this->validator->getErrors());

        $user->update([
          'password' => password_hash($validInput['password'], PASSWORD_DEFAULT),
          'resetPasswordCode' => null
        ]);

        return redirect()->to('/auth')->with('message', 'Password has been reset, please login to continue');
      }
      $user = User::where('resetPasswordCode', $resetPasswordCode)->first();
      if (!$user)
        throw new PageNotFoundException();
      return view('auth/reset', ['resetPasswordCode' => $resetPasswordCode]);
    }
    ;
    $this->isPostRequest();

    $user = User::where('email', $this->request->getVar('email'))->first();

    if (!$user) {
      return redirect()->to('/auth/forgot')->withInput()->with('error', 'Email is not registered');
    }

    $resetPasswordCode = bin2hex(random_bytes(32));

    $mail = set_mail(
      'Reset Password',
      "Hello, <strong>$user->name</strong>! We received a request to reset your password. If you didn't make the request, just ignore this email. Otherwise, you can reset your password by clicking the button below.",
      base_url('/auth/reset/' . $resetPasswordCode),
      'Reset Password'
    );

    if (!send_email($mail, $user->email)) {
      return redirect()->to('/auth/forgot')->withInput()->with('error', 'Failed to send email, please make sure your email is valid and try again. If the problem persists, please contact our customer service.');
    }

    $user->update(['resetPasswordCode' => $resetPasswordCode]);

    return redirect()->to('/auth/forgot')->with('message', 'Email has been sent, please check your email to reset your password');
  }
}
