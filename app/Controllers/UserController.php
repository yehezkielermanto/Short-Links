<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LinksModel;
use App\Models\UsersModel;
use Config\UserAgents;

use function PHPUnit\Framework\matches;

class UserController extends BaseController
{
    protected $validation;
    protected $UsersModel;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->UsersModel = new UsersModel();
    }

    public function index()
    {
        return view('/user/index');
    }

    // register new admin
    public function register()
    {
        return view('/user/register');
    }

    // post register new admin
    public function register_store()
    {
        $data = [
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
            're_password' => $this->request->getVar('re_password'),
        ];

        // validation input 
        $rules = $this->validation->setRules(
            [
                'email' => 'required|is_unique[tb_user.email]|valid_email',
                're_password' => 'required|matches[password]',
                'password' => 'required'
            ],
            [
                'email' => [
                    'required' => 'Email is required',
                    'is_unique' => 'Email already exists',
                    'valid_email' => 'Email not valid'
                ],
                'password' => [
                    'required' => 'Password is required'
                ],
                're_password' => [
                    'required' => 'Retype-Password is required',
                    'matches' => 'Password must be the same',
                ],
            ],
        );

        if (!$rules->run($data)) {
            $error = ['error' => $rules->getErrors()];
            session()->setFlashdata($error);
            return redirect()->back()->withInput();
        } else {
            // save to database
            $data_store = [
                'email' => $data['email'],
                'password' => password_hash($data['re_password'], PASSWORD_BCRYPT)
            ];

            $this->UsersModel->insert($data_store);
            $flash_data_success = ['success' => 'Berhasil membuat user baru'];

            session()->setFlashdata($flash_data_success);
            return redirect()->back();
        }
    }

    // auth login user
    public function auth()
    {
        $post_data = [
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getvar('password')
        ];

        $find_data = $this->UsersModel->getUserByEmail($post_data);
        if($find_data == true)
        {
            // set session user
            session()->set(['email' => $post_data['email']]);
            // to dashboard
            return redirect()->to('/user/dashboard');
        }
        else
        {
            $error = ['error' => ['password' => 'Failed login, account not found!']];
            session()->setFlashdata($error);
            return redirect()->back()->withInput();
        }

    }

    // dashboard
    public function dashboard()
    {
        // get email session
        $session = session()->get('email');
        if(empty($session))
        {
            return redirect()->to('/');
        }
        else{
            return view('/user/dashboard');
        }
    }
}
