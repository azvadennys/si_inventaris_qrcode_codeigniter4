<?php

namespace App\Controllers;

use App\Models\User_Model;

class Auth extends BaseController
{
    public function index()
    {
        helper('form');
        return view('auth/login');
    }
    public function auth()
    {
        $session = session();
        $model = new User_Model();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->first();
        if ($data) {
            $pass = $data['password'];
            // $verify_pass = password_verify($password, $pass);
            if ($pass == $password) {
                $ses_data = [
                    'id_user'       => $data['id_user'],
                    'username'     => $data['username'],
                    'nama'    => $data['nama'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to(base_url('home'));
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to(base_url('auth'));
            }
        } else {
            $session->setFlashdata('msg', 'Username Salah');
            return redirect()->to(base_url('auth'));
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('auth'));
    }
}
