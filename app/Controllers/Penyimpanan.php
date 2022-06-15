<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\Penyimpanan_model;
use App\Models\Barang_model;
use App\Models\Ruangan_model;
use App\Models\Supplier_model;
use CodeIgniter\Validation\Rules;

class Penyimpanan extends BaseController
{
    public function __construct()
    {

        helper('html');
        $this->dompdf = new Dompdf();
        $this->penyimpanan = new Penyimpanan_model();
        $this->barang = new Barang_model();
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
            'title' => ' Data Penyimpanan',
            'datas' => $this->penyimpanan->select('id_simpan,tgl_simpan, b.nama_barang, tahun, merek, r.nama_ruangan')
                ->join('tb_barang b', 'b.id_barang = tb_menyimpan.id_barang')
                ->join('tb_ruangan r', 'b.id_ruangan = r.id_ruangan')->orderBy('tgl_simpan', 'DESC')->get()->getResult(),
        ];
        $html = view('menyimpan/pdf', $data);

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
        $pager = \Config\Services::pager();
        $currentPage = $this->request->getVar('page_table') ? $this->request->getVar('page_table') : 1;
        $search_query = $this->request->getGet('search_query');
        if ($search_query) {
            $penyimpanan = $this->penyimpanan->select('id_simpan,tgl_simpan, b.nama_barang, tahun, merek, r.nama_ruangan')
                ->join('tb_barang b', 'b.id_barang = tb_menyimpan.id_barang')
                ->join('tb_ruangan r', 'b.id_ruangan = r.id_ruangan')->like('nama_barang', $search_query)->orlike('tahun', $search_query);
        } else {
            $penyimpanan = $this->penyimpanan->select('id_simpan,tgl_simpan, b.nama_barang, b.jumlah, tahun, merek, r.nama_ruangan')
                ->join('tb_barang b', 'b.id_barang = tb_menyimpan.id_barang')
                ->join('tb_ruangan r', 'b.id_ruangan = r.id_ruangan');
        }
        $data = [
            'title' => 'Kelola Penyimpanan',
            // 'ruangans' => $this->ruangan->get_all_nama_ruangan(),
            // 'barangs' => $this->barang->get_all_nama_barang(),
            'penyimpanans' => $penyimpanan->orderBy('tgl_simpan', 'DESC')->paginate(10, 'table'),
            'flash' => $this->session->getFlashdata('flash'),
            'pager' => $this->penyimpanan->pager,
            'currentPage' => $currentPage
        ];
        return view('menyimpan/menyimpan', $data);
    }


    public function tambah()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $penyimpanan['title'] = 'Tambah Supplier Baru';
        $penyimpanan['ruangans'] = $this->ruangan->get_all_nama_ruangan();
        $penyimpanan['barangs'] = $this->barang->get_all_nama_barang();
        $penyimpanan['flash'] = $this->session->getFlashdata('add_new_product_flash');

        return view('menyimpan/tambah', $penyimpanan);
    }

    public function add_simpan()
    {
        $validate = $this->validate([
            'id_ruangan' => [
                'label' => 'ID Ruangan',
                'rules' => 'required|numeric'
            ],
            'id_barang' => [
                'label' => 'ID Barang',
                'rules' => 'required|numeric'
            ],
            'barang_bagus' => [
                'label' => 'Jumlah Barang Bagus',
                'rules' => 'required|numeric'
            ],
            'barang_rusak' => [
                'label' => 'Jumlah Barang Rusak',
                'rules' => 'required|numeric'
            ],
            'tgl_simpan' => [
                'label' => 'Tanggal Simpan',
                'rules' => 'required'
            ],
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }

        $id_ruangan = $this->request->getPost('id_ruangan');
        $id_barang = $this->request->getPost('id_barang');
        $tgl_simpan = $this->request->getPost('tgl_simpan');
        $barang_bagus = $this->request->getPost('barang_bagus');
        $barang_rusak = $this->request->getPost('barang_rusak');
        $simpan['id_ruangan'] = $id_ruangan;
        $simpan['id_barang'] = $id_barang;
        $simpan['tgl_simpan'] = $tgl_simpan;
        $simpan['barang_bagus'] = $barang_bagus;
        $simpan['barang_rusak'] = $barang_rusak;
        $this->penyimpanan->add_new_menyimpan($simpan);
        $this->session->setFlashdata('add_new_product_flash', 'Penyimpanan baru berhasil ditambahkan!');

        return redirect()->to(base_url('penyimpanan/tambah'));
        // }
    }


    public function edit($id = 0)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        if ($this->penyimpanan->is_menyimpan_exist($id)) {
            $data = $this->penyimpanan->select('id_simpan,barang_bagus,barang_rusak,tb_menyimpan.id_ruangan,tb_menyimpan.id_barang,tgl_simpan, b.nama_barang, tahun, merek, r.nama_ruangan')
                ->join('tb_barang b', 'b.id_barang = tb_menyimpan.id_barang')
                ->join('tb_ruangan r', 'b.id_ruangan = r.id_ruangan')->where('id_simpan', $id)->get()->getRow();
            // dd($data);
            $penyimpanan['title'] = 'Edit ' . $data->id_simpan;
            $penyimpanan['ruangans'] = $this->ruangan->get_all_nama_ruangan();
            $penyimpanan['barangs'] = $this->barang->get_all_nama_barang();
            $penyimpanan['flash'] = $this->session->getflashdata('edit_product_flash');
            $penyimpanan['penyimpanan'] = $data;

            return view('menyimpan/edit', $penyimpanan);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function edit_simpan()
    {

        $validate = $this->validate([
            'id_ruangan' => [
                'label' => 'ID Ruangan',
                'rules' => 'required|numeric'
            ],
            'id_barang' => [
                'label' => 'ID Barang',
                'rules' => 'required|numeric'
            ],
            'tgl_simpan' => [
                'label' => 'Tanggal Simpan',
                'rules' => 'required'
            ],
            'barang_bagus' => [
                'label' => 'Jumlah Barang Bagus',
                'rules' => 'required|numeric'
            ],
            'barang_rusak' => [
                'label' => 'Jumlah Barang Rusak',
                'rules' => 'required|numeric'
            ],

        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $id = $this->request->getPost('id');
        $id_ruangan = $this->request->getPost('id_ruangan');
        $id_barang = $this->request->getPost('id_barang');
        $tgl_simpan = $this->request->getPost('tgl_simpan');
        $barang_bagus = $this->request->getPost('barang_bagus');
        $barang_rusak = $this->request->getPost('barang_rusak');
        $simpan['id_ruangan'] = $id_ruangan;
        $simpan['id_barang'] = $id_barang;
        $simpan['tgl_simpan'] = $tgl_simpan;
        $simpan['barang_bagus'] = $barang_bagus;
        $simpan['barang_rusak'] = $barang_rusak;
        $this->penyimpanan->edit_menyimpan($id, $simpan);
        $this->session->setflashdata('flash', 'Penyimpanan berhasil diperbarui!');

        return redirect()->to(base_url('penyimpanan'));
    }
    public function hapus($id = 0)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        if ($this->penyimpanan->is_menyimpan_exist($id)) {
            $this->penyimpanan->delete_menyimpan($id);
            $this->session->setflashdata('flash', 'Penyimpanan berhasil dihapus!');
            return redirect()->to(base_url('penyimpanan'));
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
