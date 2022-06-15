<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\Barang_model;
use App\Models\Supplier_model;
use App\Models\Masuk_model;
use CodeIgniter\Validation\Rules;

class BarangMasuk extends BaseController
{
    public function __construct()
    {

        helper('html');
        $this->dompdf = new Dompdf();
        $this->supplier = new Supplier_model();
        $this->barang = new Barang_model();
        $this->masuk = new Masuk_model();
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
            'title' => 'Barang Masuk',
            'datas' => $this->masuk->select('tb_pbarangmasuk.*,s.nama_supplier, b.nama_barang')
                ->join('tb_barang b', 'b.id_barang = tb_pbarangmasuk.id_barang')
                ->join('tb_supplier s', 'tb_pbarangmasuk.id_supplier = s.id_supplier')->orderBy('tgl_pembelian', 'DESC')->get()->getResult(),
        ];
        $html = view('barangmasuk/pdf', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream('Data Barang.pdf', array(
            "Attachment" => false
        ));
    }
    public function index()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $pager = \Config\Services::pager();
        $currentPage = $this->request->getVar('page_table') ? $this->request->getVar('page_table') : 1;
        $search_query = $this->request->getGet('search_query');
        if ($search_query) {
            $barang = $this->masuk->select('tb_pbarangmasuk.*,s.nama_supplier, b.nama_barang')
                ->join('tb_barang b', 'b.id_barang = tb_pbarangmasuk.id_barang')
                ->join('tb_supplier s', 'tb_pbarangmasuk.id_supplier = s.id_supplier')->like('nama_supplier', $search_query)->orlike('nama_barang', $search_query);
        } else {
            $barang = $this->masuk->select('tb_pbarangmasuk.*,s.nama_supplier, b.nama_barang')
                ->join('tb_barang b', 'b.id_barang = tb_pbarangmasuk.id_barang')
                ->join('tb_supplier s', 'tb_pbarangmasuk.id_supplier = s.id_supplier');
        }
        $data = [
            'title' => 'Kelola Barang Masuk',
            // 'ruangans' => $this->ruangan->get_all_nama_ruangan(),
            // 'barangs' => $this->barang->get_all_nama_barang(),
            'barangmasuks' => $barang->orderBy('tgl_pembelian', 'DESC')->paginate(10, 'table'),
            'flash' => $this->session->getFlashdata('flash'),
            'pager' => $this->masuk->pager,
            'currentPage' => $currentPage
        ];
        return view('barangmasuk/masuk', $data);
    }


    public function tambah()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $penyimpanan['title'] = 'Tambah Supplier Baru';
        $penyimpanan['suppliers'] = $this->supplier->get_all_nama_supplier();
        $penyimpanan['barangs'] = $this->barang->get_all_nama_barang();
        $penyimpanan['flash'] = $this->session->getFlashdata('add_new_product_flash');

        return view('barangmasuk/tambah', $penyimpanan);
    }

    public function add_simpan()
    {
        $validate = $this->validate([
            'id_supplier' => [
                'label' => 'ID Supplier',
                'rules' => 'required|numeric'
            ],
            'id_barang' => [
                'label' => 'ID Barang',
                'rules' => 'required|numeric'
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'required|numeric'
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required|numeric'
            ],
            'tgl_pembelian' => [
                'label' => 'Tanggal Pembelian',
                'rules' => 'required'
            ],
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }

        $id_supplier = $this->request->getPost('id_supplier');
        $id_barang = $this->request->getPost('id_barang');
        $harga = $this->request->getPost('harga');
        $jumlah = $this->request->getPost('jumlah');
        $tgl_pembelian = $this->request->getPost('tgl_pembelian');
        $simpan['id_supplier'] = $id_supplier;
        $simpan['id_barang'] = $id_barang;
        $simpan['harga'] = $harga;
        $simpan['jumlah'] = $jumlah;
        $simpan['tgl_pembelian'] = $tgl_pembelian;
        $this->masuk->add_new_masuk($simpan);
        $this->session->setFlashdata('add_new_product_flash', 'Penyimpanan baru berhasil ditambahkan!');

        return redirect()->to(base_url('barangmasuk/tambah'));
        // }
    }


    public function edit($id = 0)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        if ($this->masuk->is_masuk_exist($id)) {
            $data = $this->masuk->select('tb_pbarangmasuk.*,s.nama_supplier, b.nama_barang')
                ->join('tb_barang b', 'b.id_barang = tb_pbarangmasuk.id_barang')
                ->join('tb_supplier s', 'tb_pbarangmasuk.id_supplier = s.id_supplier')->where('id_pengadaan', $id)->get()->getRow();

            // dd($data);
            $masuk['title'] = 'Edit ' . $data->id_pengadaan;
            $masuk['suppliers'] = $this->supplier->get_all_nama_supplier();
            $masuk['barangs'] = $this->barang->get_all_nama_barang();
            $masuk['flash'] = $this->session->getflashdata('edit_product_flash');
            $masuk['masuk'] = $data;

            return view('barangmasuk/edit', $masuk);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function edit_simpan()
    {

        $validate = $this->validate([
            'id_supplier' => [
                'label' => 'ID Supplier',
                'rules' => 'required|numeric'
            ],
            'id_barang' => [
                'label' => 'ID Barang',
                'rules' => 'required|numeric'
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'required|numeric'
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required|numeric'
            ],
            'tgl_pembelian' => [
                'label' => 'Tanggal Pembelian',
                'rules' => 'required'
            ],

        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $id = $this->request->getPost('id');
        $id_supplier = $this->request->getPost('id_supplier');
        $id_barang = $this->request->getPost('id_barang');
        $harga = $this->request->getPost('harga');
        $jumlah = $this->request->getPost('jumlah');
        $tgl_pembelian = $this->request->getPost('tgl_pembelian');
        $simpan['id_supplier'] = $id_supplier;
        $simpan['id_barang'] = $id_barang;
        $simpan['harga'] = $harga;
        $simpan['jumlah'] = $jumlah;
        $simpan['tgl_pembelian'] = $tgl_pembelian;
        $this->masuk->edit_masuk($id, $simpan);
        $this->session->setflashdata('flash', 'Penyimpanan berhasil diperbarui!');

        return redirect()->to(base_url('barangmasuk'));
    }
    public function hapus($id = 0)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        if ($this->masuk->is_masuk_exist($id)) {
            $this->masuk->delete_masuk($id);
            $this->session->setflashdata('flash', 'Barang Masuk berhasil dihapus!');
            return redirect()->to(base_url('barangmasuk'));
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
