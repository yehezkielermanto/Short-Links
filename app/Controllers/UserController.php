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
    protected $email;
    protected $google;
   
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->UsersModel = new UsersModel();
        $this->LinksModel = new LinksModel();
        $this->email = \Config\Services::email();
        $this->google = new \Google\Client();
    }

    public function index()
    {
        $login_button = '';
        $this->google->addScope(\Google\Service\Drive::DRIVE);
        $this->google->setClientId(getenv("CLIENT_ID"));
        $this->google->setClientSecret(getenv("CLIENT_SECRET"));
        $this->google->setRedirectUri('http://localhost:8080');

        $this->google->addScope('email');
        $this->google->addScope('profile');
        
        if(isset($_GET["code"])){
            $token = $this->google->fetchAccessTokenWithAuthCode($_GET["code"]);
            
            if(!isset($token['error']))
            {
                $this->google->setAccessToken($token['access_token']);

                session()->set('access_token', $token['access_token']);

                $google_service = new \Google\Service\Oauth2($this->google);

                $data = $google_service->userinfo->get();

                // $current_datetime = date('Y-m-d H:i:s');

                $condition = false;
                if($this->UsersModel->is_already_registered($data['id'])){
                   
                    $post_data = [
                        'email' => $data['email'],
                    ];
                    $get_data = $this->UsersModel->getUserData($post_data);
                    session()->set(['email' => $data['email'], 'user_id' => $get_data]);
                    return redirect()->to('/user/dashboard');
                }else{
                    //insert data
                    $user_data = array(
                        'google_id' => $data['id'],
                        'email'  => $data['email'],
                        'is_verified' => 1
                    );
                    
                    $this->UsersModel->insert($user_data);
                    $get_data = $this->UsersModel->getUserData($user_data);
                    session()->set(['email' => $data['email'], 'user_id' => $get_data]);
                    
                    return redirect()->to('/user/dashboard');
                }

            }
        }
        if(!session()->get('access_token')){
            $login_button = $this->google->createAuthUrl();
        }
        return view('/user/index', ["login_button" => $login_button]);
    }

    // register new admin
    public function register()
    {
        return view('/user/register');
    }

    //------------------------------------------------- post register new user
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

            // send email
            try {
                // $this->email->setFrom('yehezkiel.ermanto28@gmail.com', 'yehezkiel ermanto');
                // $this->email->setTo($data_store['email']);
                // $this->email->setSubject('Short Links Email Verification');
               $temp = view('/user/email_view', ['email' => $data_store['email']]);
                // $this->email->setMessage($temp);
                // $this->email->send();
            } catch (\Throwable $th) {
                dd($th);
            }

            $this->UsersModel->insert($data_store);
            // $flash_data_success = ['success' => 'Berhasil membuat user baru'];

            // session()->setFlashdata($flash_data_success);
            return view('/user/email_send', ["temp" => $temp]);
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
        session()->remove('access_token');
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

    // verif email
    public function verifEmail($data)
    {
        try {
            // find email in database
            $email = $this->UsersModel->where('email', $data)->first();
            $status = "";
            if(!empty($email)){
                // set is_verified = 1
                $this->UsersModel->where('email', $data)->set(['is_verified' =>  1])->update();
                $status = 'Email verification successfully';
                return view('/user/email_verif', ['state' => $status , 'alert' => 'bg-green-300']);
            }else{
                $status = 'Email verification failed';
                return view('/user/email_verif', ['state' => $status, 'alert' => 'bg-red-300']);
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    // public service and policy
    public function userPolicy()
    {
        return view('/public/public_policy');
    }
    public function userService()
    {
        return view('/public/public_service');
    }
}
