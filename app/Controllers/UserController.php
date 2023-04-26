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
    protected $LinksModel;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->UsersModel = new UsersModel();
        $this->LinksModel = new LinksModel();
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
        $get_data = $this->UsersModel->getUserData($post_data);
        if($find_data == true)
        {
            // set session user
            session()->set(['email' => $post_data['email'], 'user_id' => $get_data]);
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

    // logout user
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    // user dashboard
    public function dashboard()
    {
        // get email session
        $session = session()->get('email');
        $id = session()->get('user_id');
        if(empty($session))
        {
            return redirect()->to('/');
        }
        else{
            return view('/user/dashboard', 
            [
                'email' => $session, 
                'links' => $this->LinksModel->getLinkByUser($id),
                'pager' => $this->LinksModel->pager()
            ]
        );
        }
    }

    // user generate random shorten url
    public function generate()
    {
        $long_url = $this->request->getVar('longUrl');
        $short_url = $this->RandomGenerator();
        $merge_url = base_url() . $short_url;
        $data = [
            'url_ori' => $long_url,
            'url_short' => $short_url,
            'user_id' => session()->get('user_id')
        ];

        $rules = $this->validation->setRules(
            [
            'url_short' => 'is_unique[tb_links.url_short]'
            ],
            [
                'url_short' => [
                    'is_unique' => 'Name already exists',
                ],
            ]
        );

        if($rules->run($data)){
            // save to database
            $this->LinksModel->insert($data);
            return json_encode(['merge_url' => $merge_url]);
        }        
    }

    public function getAllLinks($userId)
    {
        $get_links = $this->LinksModel->getLinkByUser($userId);
        return $get_links;
    }

    // change url
    public function changeUrl()
    {
        $session = session()->get('email');
        if(empty($session))
        {
            return redirect()->to('/');
        }else{
            $url_custom = $this->request->getVar('url_custom');
            $url_short = $this->request->getVar('url_short');

            $rules = $this->validation->setRules(
                [
                'url_short' => 'is_unique[tb_links.url_short]'
                ],
                [
                    'url_short' => [
                        'is_unique' => 'Name already exists',
                    ],
                ]);
        
            $data = [
                'url_short' => $url_custom
            ];
            if($rules->run($data)){
                return $this->LinksModel->where('url_short', $url_short)->set($data)->update();
                // return json_encode('Success');
            }else{
                $error = ['error' => ['custom_url' => 'Custom name already exists!']];
                return session()->setFlashdata($error);
                // return json_encode('Failed');
            }

        }
    }

    // delete url
    public function deleteUrl()
    {
        $url_short = $this->request->getVar('url_short');
        $this->LinksModel->where('url_short', $url_short)->delete();
        $success = ['success' => ['url_short' => 'URL deleted successfully!']];
        session()->setFlashdata($success);
        return json_encode('Success delete url');
    }
}
