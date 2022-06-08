<?php

namespace App\Controllers;

use App\Models\Gedung_model;
use App\Models\Ruangan_model;
use CodeIgniter\Validation\Rules;

class Ruangan extends BaseController
{
    public function __construct()
    {

        helper('html');
        $this->gedung = new Gedung_model();
        $this->ruangan = new Ruangan_model();
        $this->validation =  \Config\Services::validation();
        $this->session = session();
    }

    public function index()
    {
        $pager = \Config\Services::pager();

        $data = [
            'title' => 'Kelola Ruangan',
            'ruangan' => $this->ruangan->orderBy('nama_ruangan', 'ASC')->paginate(8, 'card'),
            'pager' => $this->ruangan->pager
        ];
        return view('ruangan/ruangan', $data);
    }


    public function tambah()
    {
        $gedung['title'] = 'Tambah Gedung Baru';

        $gedung['flash'] = $this->session->getFlashdata('add_new_product_flash');
        $gedung['gedungs'] = $this->gedung->get_all_nama_gedung();

        return view('ruangan/add_new_ruangan', $gedung);
    }

    public function add_ruangan()
    {
        $validate = $this->validate([
            'nama_ruangan' => [
                'label' => 'Nama Ruangan',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
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
        $nama_ruangan = $this->request->getPost('nama_ruangan');
        $id_gedung = $this->request->getPost('id_gedung');
        $id_user = $this->request->getPost('id_user');
        $img = $this->request->getFile('picture');
        if ($img->getName() != 'default.jpg') {
            $img->move('assets/uploads/ruangan');
        }

        $ruangan['nama_ruangan'] = $nama_ruangan;
        $ruangan['id_gedung'] = $id_gedung;
        $ruangan['id_user'] = $id_user;
        $ruangan['foto'] = $img->getName();
        $this->ruangan->add_new_ruangan($ruangan);
        $this->session->setFlashdata('add_new_product_flash', 'Produk baru berhasil ditambahkan!');

        return redirect()->to(base_url('ruangan/tambah'));
        // }
    }


    public function edit($id = 0)
    {
        if ($this->ruangan->is_ruangan_exist($id)) {
            $data = $this->ruangan->ruangan_data($id);

            $ruangan['title'] = 'Edit ' . $data->nama_ruangan;

            $ruangan['flash'] = $this->session->getflashdata('edit_product_flash');
            $ruangan['ruangan'] = $data;
            $ruangan['gedungs'] = $this->gedung->get_all_nama_gedung();

            return view('ruangan/edit_ruangan', $ruangan);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function edit_ruangan()
    {

        $validate = $this->validate([
            'nama_ruangan' => [
                'label' => 'Nama Gedung',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],
            'id_gedung' => [
                'label' => 'ID Gedung',
                'rules' => 'required|numeric'
            ],

        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $nama_ruangan = $this->request->getPost('nama_ruangan');
        $id_gedung = $this->request->getPost('id_gedung');
        $id = $this->request->getPost('id');
        $data = $this->ruangan->ruangan_data($id);
        $current_picture = $data->foto;
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

            $img->move('assets/uploads/ruangan');
            $new_file_name = $img->getName();

            if ($this->ruangan->is_ruangan_have_image($id)) {
                $file = './assets/uploads/ruangan/' . $current_picture;

                $file_name = $new_file_name;
                unlink($file);
            } else {
                $file_name = $new_file_name;
            }
        } else {
            $file_name = ($this->ruangan->is_ruangan_have_image($id)) ? $current_picture : NULL;
        }


        $ruangan['nama_ruangan'] = $nama_ruangan;
        $ruangan['id_gedung'] = $id_gedung;
        $ruangan['foto'] = $file_name;

        $this->ruangan->edit_ruangan($id, $ruangan);
        $this->session->setflashdata('edit_product_flash', 'Produk berhasil diperbarui!');

        return redirect()->to(base_url('ruangan/view/' . $id));
    }

    public function product_api()
    {
        $action = $this->request->getGet('action');

        switch ($action) {
            case 'delete_image':
                $id = $this->request->getPost('id');
                $data = $this->ruangan->ruangan_data($id);
                $picture_name = $data->foto;
                $file = './assets/uploads/ruangan/' . $picture_name;

                if (file_exists($file) && is_readable($file)) {
                    if ($data->foto != 'default.jpg') {
                        unlink($file);
                    }
                    $this->ruangan->delete_ruangan_image($id);
                    $response = array('code' => 204, 'message' => 'Gambar berhasil dihapus');
                } else {
                    $response = array('code' => 200, 'message' => 'Terjadi kesalahan sata menghapus gambar');
                }
                break;
            case 'delete_product':
                $id = $this->request->getPost('id');
                $data = $this->ruangan->ruangan_data($id);
                $picture = $data->foto;
                $file = './assets/uploads/ruangan/' . $picture;

                $this->ruangan->delete_ruangan($id);

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
        if ($this->ruangan->is_ruangan_exist($id)) {
            $data = $this->ruangan->ruangan_data($id);
            // dd($data);
            $ruangan['title'] = $data->nama_ruangan . ' | Data Ruangan ';

            $ruangan['ruangan'] = $data;
            $ruangan['totalBarang'] = $this->ruangan->count_barang_in_ruangan($id);
            // 
            $ruangan['flash'] = $this->session->getflashdata('product_flash');
            $ruangan['ruangans'] = $this->ruangan->rungan_in_gedung($id);

            return view('ruangan/view', $ruangan);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}