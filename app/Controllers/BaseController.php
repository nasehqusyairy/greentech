<?php

namespace App\Controllers;

use App\Exceptions\HTTPException;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Submenu;
use App\Models\User;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\Exceptions\RedirectException;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['input', 'url', 'email', 'form', 'component', 'output'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    protected $rule = ['store' => [], 'update' => []];
    protected $validator;
    protected $session;

    public function __construct()
    {
        $this->session = Services::session();
        $this->validator = Services::validation();
    }

    private $isAllowed = false;

    private function authorize(): void
    {
        $uri = service('uri');
        // Ambil path dari URL saat ini
        $currentPath = $uri->getPath();

        // $currentPath tidak boleh diawali maupun diakhiri dengan '/'
        $currentPath = trim($currentPath, '/');

        // Ambil data user dari session
        $user = User::find(session('user'))->load(['role.permissions', 'role.menus.submenus']);

        if ($user->role->code != 0) {

            // jika $currentPath tidak ada di tabel submenus
            if (Submenu::whereRaw('? LIKE CONCAT("%", url, "%") AND url!="/"', [$currentPath])->exists()) {

                // cek apakah $currentPath ada di tabel submenu user
                $user->role->menus->each(function ($menu) use ($currentPath) {
                    $menu->submenus->each(function ($submenu) use ($currentPath) {
                        // submenu url mirip dengan currentPath
                        if (strpos($currentPath, $submenu->url) !== false && $submenu->url != '' && $submenu->url != '/') {
                            // dd($submenu->url, $currentPath);
                            $this->isAllowed = true;
                            return;
                        }
                    });
                });

                // jika $currentPath ada di tabel permissions dan role user memiliki permission tersebut
                $permission = Permission::where('path', $currentPath)->orWhere('path', $uri->getSegment(1));
                if ($permission->exists()) {
                    $this->isAllowed = false;
                    $permission = $permission->first();
                    if ($user->role->permissions->contains($permission)) {
                        // dd($user->role->permissions->contains($permission));
                        $this->isAllowed = true;
                        return;
                    }
                }

                if (count($uri->getSegments()) > 1) {
                    $permission = Permission::where('path', $uri->getSegment(1) . "/*");
                    if ($permission->exists()) {
                        $this->isAllowed = false;
                        $permission = $permission->first();
                        if ($user->role->permissions->contains($permission)) {
                            $this->isAllowed = true;
                            return;
                        }
                    }
                }

                if (!$this->isAllowed) throw new HTTPException('You are not authorized to access this page', 403);
            }
        }
    }

    protected function isNeedLogin(): void
    {
        if (!session()->has('user')) throw new RedirectException('/auth');
        $this->authorize();
    }

    // function to get validated input from POST request
    protected function validInput(array $files = null, bool $isClean = false): bool|array
    {
        // get input
        $input = $this->request->getPost();

        // clean input
        $cleanedInput = !$isClean ? clean_input($input) : $input;

        // get files
        if ($files) {
            foreach ($files as $file) {
                $cleanedInput[$file] = $this->request->getFile($file);
            }
        }

        // validate
        return $this->validator->run($cleanedInput) ? $cleanedInput : false;
    }

    // function to return response if the input is invalid
    protected function invalidInputResponse(array $errors): ResponseInterface
    {
        return redirect()->setStatusCode(422)->back()->withInput()->with('errors', $errors);
    }

    // funtion to throw error if the request is not POST
    protected function isPostRequest(): void
    {
        if (!$this->request->is('post')) {
            throw new HTTPException('This route only accepts POST requests', 405);
        }
    }

    protected function cropImage($sourcePath, $destinationPath, $size = 300)
    {
        Services::image()
            ->withFile($sourcePath)
            ->fit($size, $size, 'center')
            ->save($destinationPath);
    }

    protected function upload(array $files = null, callable $callback = null)
    {
        $fileUrls = [];
        foreach ($files as $file) {
            $key = $file;
            $file = $this->request->getFile($file);

            if ($file->isValid() && !$file->hasMoved()) {
                // Generate a new filename
                $newName = $file->getRandomName();

                $newLocation = 'uploads/' . $file->getExtension();

                // Move the file to uploads/{extenstion} folder under public folder path
                $file->move(FCPATH . $newLocation, $newName);

                if ($callback) {
                    $callback($newName, $newLocation, $file);
                }

                // Get the file URL
                $fileUrls[$key] = base_url($newLocation . '/' . $newName);
            }
        }
        return $fileUrls;
    }

    protected function getCountries()
    {
        return json_decode(file_get_contents('https://restcountries.com/v3.1/all?fields=name,cca2,idd'));
    }

    protected function getCountryRules(): string
    {
        $countryList = [];
        foreach ($this->getCountries() as $country) {
            $countryList[] = $country->cca2;
        }
        return 'in_list' . str_replace('"', '', json_encode($countryList));
    }
}
