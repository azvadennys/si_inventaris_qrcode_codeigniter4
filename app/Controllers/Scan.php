<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\Barang_model;

class Scan extends BaseController
{
    public function __construct()
    {

        helper('html');

        $this->dompdf = new Dompdf();
        $this->barang = new Barang_model();
        $this->session = session();
    }
    public function index()
    {
        helper('form');
        $data = [
            'title' => 'Scanner',

        ];
        return view('qrcode/qrcode_scan', $data);
    }
    public function pdf($id)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $pager = \Config\Services::pager();

        $data = [
            'title' => 'Cetak QRCode',
            'barang' => $this->barang->where('id_barang', $id)->get()->getRow(),
        ];
        return view('qrcode/pdf', $data);
        // $html = view('qrcode/pdf', $data);

        // $this->dompdf->loadHtml($html);
        // $this->dompdf->setPaper('A4', 'potrait');
        // $this->dompdf->render();
        // $this->dompdf->stream(); //Langsung download
        // $this->dompdf->stream('Data Barang.pdf', array(
        //     "Attachment" => false
        // ));
    }
}
