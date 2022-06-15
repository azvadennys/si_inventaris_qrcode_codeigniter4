<?php

namespace App\Controllers;


class Scan extends BaseController
{
    public function index()
    {
        helper('form');
        $data = [
            'title' => 'Scanner',

        ];
        return view('qrcode/qrcode_scan', $data);
    }
}
