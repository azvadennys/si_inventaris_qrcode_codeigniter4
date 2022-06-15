<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\Gedung_model;
use App\Models\Barang_model;
use App\Models\Ruangan_model;
use App\Models\Supplier_model;
use CodeIgniter\Validation\Rules;

class Supplier extends BaseController
{
    public function __construct()
    {

        helper('html');
        $this->dompdf = new Dompdf();
        $this->supplier = new Supplier_model();
        $this->barang = new Barang_model();
        $this->gedung = new Gedung_model();
        $this->ruangan = new Ruangan_model();
        $this->validation =  \Config\Services::validation();
        $this->session = session();
    }
    public function pdf()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $pager = \Config\Services::pager();

        $data = [
            'title' => ' Data Supplier',
            'datas' => $this->supplier->orderBy('nama_supplier', 'ASC')->get()->getResult(),
        ];
        $html = view('supplier/pdf', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream('Data Penyimpanan.pdf', array(
            "Attachment" => false
        ));
    }
    public function index()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $currentPage = $this->request->getVar('page_table') ? $this->request->getVar('page_table') : 1;
        $pager = \Config\Services::pager();
        $search_query = $this->request->getGet('search_query');
        if ($search_query) {
            $supplier = $this->supplier->like('nama_toko', $search_query)->orlike('nama_supplier', $search_query);
        } else {
            $supplier = $this->supplier;
        }
        $data = [
            'title' => 'Kelola Supplier',
            'suppliers' => $supplier->orderBy('nama_toko', 'ASC')->paginate(10, 'table'),
            'flash' => $this->session->getFlashdata('flash'),
            'pager' => $this->supplier->pager,
            'currentPage' => $currentPage
        ];
        return view('supplier/supplier', $data);
    }


    public function tambah()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $barang['title'] = 'Tambah Supplier Baru';

        $barang['flash'] = $this->session->getFlashdata('add_new_product_flash');

        return view('supplier/tambah', $barang);
    }

    public function add_supplier()
    {
        $validate = $this->validate([
            'nama_supplier' => [
                'label' => 'Nama Supplier',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],
            'kontak_supplier' => [
                'label' => 'Kontak Supplier',
                'rules' => 'required|numeric'
            ],
            'nama_toko' => [
                'label' => 'Nama Toko',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }

        $nama_supplier = $this->request->getPost('nama_supplier');
        $kontak_supplier = $this->request->getPost('kontak_supplier');
        $nama_toko = $this->request->getPost('nama_toko');
        $alamat = $this->request->getPost('alamat');
        $supplier['nama_supplier'] = $nama_supplier;
        $supplier['kontak_supplier'] = $kontak_supplier;
        $supplier['nama_toko'] = $nama_toko;
        $supplier['alamat'] = $alamat;
        $this->supplier->add_new_supplier($supplier);
        $this->session->setFlashdata('add_new_product_flash', 'Supplier baru berhasil ditambahkan!');

        return redirect()->to(base_url('supplier/tambah'));
        // }
    }


    public function edit($id = 0)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        if ($this->supplier->is_supplier_exist($id)) {
            $data = $this->supplier->supplier_data($id);

            $supplier['title'] = 'Edit ' . $data->nama_supplier;

            $supplier['flash'] = $this->session->getflashdata('edit_product_flash');
            $supplier['supplier'] = $data;

            return view('supplier/edit', $supplier);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function edit_supplier()
    {

        $validate = $this->validate([
            'nama_supplier' => [
                'label' => 'Nama Supplier',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],
            'kontak_supplier' => [
                'label' => 'Kontak Supplier',
                'rules' => 'required|numeric'
            ],
            'nama_toko' => [
                'label' => 'Nama Toko',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $id = $this->request->getPost('id');
        $nama_supplier = $this->request->getPost('nama_supplier');
        $kontak_supplier = $this->request->getPost('kontak_supplier');
        $nama_toko = $this->request->getPost('nama_toko');
        $alamat = $this->request->getPost('alamat');
        $supplier['nama_supplier'] = $nama_supplier;
        $supplier['kontak_supplier'] = $kontak_supplier;
        $supplier['nama_toko'] = $nama_toko;
        $supplier['alamat'] = $alamat;

        $this->supplier->edit_supplier($id, $supplier);
        $this->session->setflashdata('flash', 'Supplier berhasil diperbarui!');

        return redirect()->to(base_url('supplier'));
    }
    public function hapus($id = 0)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        if ($this->supplier->is_supplier_exist($id)) {
            $this->supplier->delete_supplier($id);
            $this->session->setflashdata('flash', 'Supplier berhasil dihapus!');
            return redirect()->to(base_url('supplier'));
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
