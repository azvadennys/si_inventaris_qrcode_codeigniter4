<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\Gedung_model;
use App\Models\Barang_model;
use App\Models\Ruangan_model;
use CodeIgniter\Validation\Rules;

class Barang extends BaseController
{
    public function __construct()
    {

        helper('html');
        $this->dompdf = new Dompdf();
        $this->barang = new Barang_model();
        $this->gedung = new Gedung_model();
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
        $pager = \Config\Services::pager();
        $search_query = $this->request->getGet('search_query');
        if ($search_query) {
            $barang = $this->barang->like('nama_barang', $search_query)->orlike('tahun', $search_query);
        } else {
            $barang = $this->barang;
        }
        $data = [
            'title' => 'Kelola Barang',
            'barang' => $barang->orderBy('nama_barang', 'ASC')->paginate(8, 'card'),
            'pager' => $this->barang->pager
        ];
        return view('barang/barang', $data);
    }
    public function pdf()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $pager = \Config\Services::pager();

        $data = [
            'title' => 'Barang',
            'datas' => $this->barang->orderBy('nama_barang', 'ASC')->get()->getResult(),
        ];
        $html = view('barang/pdf', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream('Data Barang.pdf', array(
            "Attachment" => false
        ));
    }

    public function tambah()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $barang['title'] = 'Tambah barang Baru';

        $barang['flash'] = $this->session->getFlashdata('add_new_product_flash');
        $barang['ruangans'] = $this->ruangan->get_all_nama_ruangan();
        $barang['gedungs'] = $this->gedung->get_all_nama_gedung();

        return view('barang/add_new_barang', $barang);
    }

    public function add_barang()
    {
        $validate = $this->validate([
            'nama_barang' => [
                'label' => 'Nama barang',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],
            'id_ruangan' => [
                'label' => 'ID Ruangan',
                'rules' => 'trim|required|numeric'
            ],
            'tahun' => [
                'label' => 'Tahun',
                'rules' => 'trim|required|min_length[4]|max_length[100]'
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'trim|required|numeric'
            ],
            'merek' => [
                'label' => 'Merek',
                'rules' => 'trim|required|min_length[4]|max_length[100]'
            ],
            'jenis' => [
                'label' => 'Jenis',
                'rules' => 'trim|required|min_length[4]|max_length[100]'
            ],

            'picture' => [
                'rules' => 'uploaded[picture]'
                    . '|is_image[picture]'
                    . '|mime_in[picture,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[picture,2048]',
            ]
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $id_ruangan = $this->request->getPost('id_ruangan');
        // $data = $this->ruangan->where('id_ruangan', $id_ruangan)->first();

        // $id_gedung = (int)$data['id_gedung'];
        $nama_barang = $this->request->getPost('nama_barang');
        $tahun = $this->request->getPost('tahun');
        $jumlah = $this->request->getPost('jumlah');
        $merek = $this->request->getPost('merek');
        $jenis = $this->request->getPost('jenis');
        $id_user = session()->get('id_user');
        $img = $this->request->getFile('picture');
        if ($img->getName() != 'default.jpg') {
            $img->move('assets/uploads/barang');
        }

        // $barang['id_gedung'] = $id_gedung;
        $barang['id_ruangan'] = $id_ruangan;
        $barang['nama_barang'] = $nama_barang;
        $barang['tahun'] = $tahun;
        $barang['jumlah'] = $jumlah;
        $barang['merek'] = $merek;
        $barang['jenis'] = $jenis;
        $barang['id_user'] = $id_user;
        $barang['foto'] = $img->getName();
        // dd($barang);
        $this->barang->add_new_barang($barang);
        $this->session->setFlashdata('add_new_product_flash', 'Produk baru berhasil ditambahkan!');

        return redirect()->to(base_url('barang/tambah'));
        // }
    }


    public function edit($id = 0)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        if ($this->barang->is_barang_exist($id)) {
            $data = $this->barang->barang_data($id);

            $barang['title'] = 'Edit ' . $data->nama_barang;

            $barang['flash'] = $this->session->getflashdata('edit_product_flash');
            $barang['barang'] = $data;
            $barang['ruangans'] = $this->ruangan->get_all_nama_ruangan();

            return view('barang/edit_barang', $barang);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function edit_barang()
    {

        $validate = $this->validate([
            'nama_barang' => [
                'label' => 'Nama barang',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],
            'id_ruangan' => [
                'label' => 'ID Ruangan',
                'rules' => 'trim|required|numeric'
            ],
            'tahun' => [
                'label' => 'Tahun',
                'rules' => 'trim|required|min_length[4]|max_length[100]'
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'trim|required|numeric'
            ],
            'merek' => [
                'label' => 'Merek',
                'rules' => 'trim|required|min_length[4]|max_length[100]'
            ],
            'jenis' => [
                'label' => 'Jenis',
                'rules' => 'trim|required|min_length[4]|max_length[100]'
            ],

        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        // if ($this->validation->run() == FALSE) {
        //     $id = $this->request->getPost('id');
        //     $this->edit($id);
        // } else {
        $id_ruangan = $this->request->getPost('id_ruangan');
        // $data = $this->ruangan->where('id_ruangan', $id_ruangan)->first();

        // $id_gedung = (int)$data['id_gedung'];
        $nama_barang = $this->request->getPost('nama_barang');
        $tahun = $this->request->getPost('tahun');
        $jumlah = $this->request->getPost('jumlah');
        $merek = $this->request->getPost('merek');
        $jenis = $this->request->getPost('jenis');
        $id_user = session()->get('id_user');
        $id = $this->request->getPost('id');
        $data = $this->barang->barang_data($id);
        $current_picture = $data->foto;

        $name = $this->request->getPost('nama_barang');

        if (isset($_FILES['picture']) && @$_FILES['picture']['error'] == '0') {
            $validate = $this->validate([
                'picture' => [
                    'rules' => 'uploaded[picture]'
                        . '|is_image[picture]'
                        . '|mime_in[picture,image/jpg,image/jpeg,image/png,image/webp]'
                        . '|max_size[picture,2048]',
                ]
            ]);
            if (!$validate) {
                return redirect()->back()->withInput();
            }
            $img = $this->request->getFile('picture');
            $img->move('assets/uploads/barang');
            $new_file_name = $img->getName();

            if ($this->barang->is_barang_have_image($id)) {
                $file = './assets/uploads/barang/' . $current_picture;

                $file_name = $new_file_name;
                unlink($file);
            } else {
                $file_name = $new_file_name;
            }
        } else {
            $file_name = ($this->barang->is_barang_have_image($id)) ? $current_picture : NULL;
        }


        $barang['id_ruangan'] = $id_ruangan;
        $barang['nama_barang'] = $nama_barang;
        $barang['tahun'] = $tahun;
        $barang['jumlah'] = $jumlah;
        $barang['merek'] = $merek;
        $barang['jenis'] = $jenis;
        $barang['id_user'] = $id_user;
        $barang['foto'] = $file_name;

        $this->barang->edit_barang($id, $barang);
        $this->session->setflashdata('edit_product_flash', 'Produk berhasil diperbarui!');

        return redirect()->to(base_url('barang/view/' . $id));
    }

    public function product_api()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $action = $this->request->getGet('action');

        switch ($action) {
            case 'delete_image':
                $id = $this->request->getPost('id');
                $data = $this->barang->barang_data($id);
                $picture_name = $data->foto;
                $file = './assets/uploads/barang/' . $picture_name;

                if (file_exists($file) && is_readable($file)) {
                    if ($data->foto != 'default.jpg') {
                        unlink($file);
                    }
                    $this->barang->delete_barang_image($id);
                    $response = array('code' => 204, 'message' => 'Gambar berhasil dihapus');
                } else {
                    $response = array('code' => 200, 'message' => 'Terjadi kesalahan sata menghapus gambar');
                }
                break;
            case 'delete_product':
                $id = $this->request->getPost('id');
                $data = $this->barang->barang_data($id);
                $picture = $data->foto;
                $file = './assets/uploads/barang/' . $picture;

                $this->barang->delete_barang($id);

                if (file_exists($file) && is_readable($file)) {
                    if ($data->foto != 'default.jpg') {
                        unlink($file);
                    }
                }

                $response = array('code' => 204);
                break;
        }

        return $this->response->setJSON($response);
    }

    public function view($id = 0)
    {
        if ($this->barang->is_barang_exist($id)) {
            $data = $this->barang->barang_data($id);

            $barang['title'] = $data->nama_barang . ' | Data barang ';

            $barang['barang'] = $data;
            $barang['flash'] = $this->session->getflashdata('product_flash');
            // $barang['ruangans'] = $this->ruangan->rungan_in_barang($id);

            return view('barang/view', $barang);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    public function qrcode($id = 0)
    {
        if ($this->barang->is_barang_exist($id)) {
            $data = $this->barang->barang_data($id);

            $barang['title'] = $data->nama_barang . ' | Data barang ';

            $barang['barang'] = $data;
            $barang['flash'] = $this->session->getflashdata('product_flash');
            // $barang['ruangans'] = $this->ruangan->rungan_in_barang($id);

            return view('barang/qrcode', $barang);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
