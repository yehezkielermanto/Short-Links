<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'email', 'password'];

    public function getUserByEmail($data)
    {
        $get_password = $this->where(['email' => $data['email']])->first();
        if(!empty($get_password)){
            $verify = password_verify($data['password'], $get_password['password']);
            return $verify;
        }else{
            return false;
        }
    }
}
