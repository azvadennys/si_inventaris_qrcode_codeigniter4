<?php

namespace App\Controllers;

use App\Models\Gedung_model;
use App\Models\Ruangan_model;
use App\Models\Penyimpanan_model;
use App\Models\Supplier_model;
use App\Models\Barang_model;
use App\Models\Masuk_model;

class Home extends BaseController
{
    public function __construct()
    {

        helper('html');
        $this->gedung = new Gedung_model();
        $this->masuk = new Masuk_model();
        $this->supplier = new Supplier_model();
        $this->penyimpanan = new Penyimpanan_model();
        $this->barang = new Barang_model();
        $this->ruangan = new Ruangan_model();
        $this->validation =  \Config\Services::validation();
        $this->session = session();
    }
    public function index()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $data = [
            'title' => 'Dashboard',
            'gedung' => $this->gedung->count_all_gedung(),
            'masuk' => $this->masuk->count_all_masuk(),
            'supplier' => $this->supplier->count_all_supplier(),
            'penyimpanan' => $this->penyimpanan->count_all_menyimpan(),
            'barang' => $this->barang->count_all_barang(),
            'ruangan' => $this->ruangan->count_all_ruangan(),
            'session' => session(),
        ];
        // dd($data);
        return view('overview', $data);
    }
}
