<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'email', 'password', 'google_id', 'is_verified'];

    public function getUserByEmail($data)
    {
        $get_password = $this->where(['email' => $data['email'], 'is_verified' => 1])->first();

        if (!empty($get_password)) {
            $verify = password_verify($data['password'], $get_password['password']);
            return $verify;
        } else {
            return false;
        }
    }

    public function getUserData($data)
    {
        $get_user_id = $this->where(['email' => $data['email']])->first();
        if(!empty($get_user_id)){
            return $get_user_id['id'];
        }else{
            return false;
        }
    }

    public function is_already_registered($id)
    {
        $google_id = $this->where(['google_id' => $id])->first();
        if(!empty($google_id)){
            return true;
        }else{
            return false;
        }
    }

    // update data google login
    public function update_user_data($data, $id)
    {
        $this->where(['google_id' => $id])->set($data)->update();
    }
}
