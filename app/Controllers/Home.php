<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $data = [
            'title' => 'Dashboard',
            'session' => session(),
        ];
        return view('overview', $data);
    }
}
