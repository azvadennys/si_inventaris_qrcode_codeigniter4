<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\Gedung_model;
use App\Models\Ruangan_model;
use CodeIgniter\Validation\Rules;

class Gedung extends BaseController
{
    public function __construct()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        helper('html');
        $this->dompdf = new Dompdf();
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
            'title' => 'Gedung',
            'datas' => $this->gedung->orderBy('nama_gedung', 'ASC')->get()->getResult(),
        ];
        $html = view('gedung/pdf', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream('Data Gedung.pdf', array(
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
        $search_query = $this->request->getGet('search_query');
        if ($search_query) {
            $gedung = $this->gedung->like('nama_gedung', $search_query);
        } else {
            $gedung = $this->gedung;
        }
        $data = [
            'title' => 'Kelola Gedung',
            'gedung' => $gedung->orderBy('nama_gedung', 'ASC')->paginate(8, 'card'),
            'pager' => $this->gedung->pager
        ];
        return view('gedung/gedung', $data);
    }


    public function tambah()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $gedung['title'] = 'Tambah Gedung Baru';

        $gedung['flash'] = $this->session->getFlashdata('add_new_product_flash');
        // $gedung['categories'] = $this->gedung->get_all_categories();

        return view('gedung/add_new_gedung', $gedung);
    }

    public function add_gedung()
    {
        $validate = $this->validate([
            'nama_gedung' => [
                'label' => 'Nama Gedung',
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
        $nama_gedung = $this->request->getPost('nama_gedung');
        $id_user = $this->request->getPost('id_user');
        $img = $this->request->getFile('picture');
        if ($img->getName() != 'default.jpg') {
            $img->move('assets/uploads/gedung');
        }
        $gedung['nama_gedung'] = $nama_gedung;
        $gedung['id_user'] = $id_user;
        $gedung['foto'] = $img->getName();
        $this->gedung->add_new_gedung($gedung);
        $this->session->setFlashdata('add_new_product_flash', 'Produk baru berhasil ditambahkan!');

        return redirect()->to(base_url('gedung/tambah'));
        // }
    }


    public function edit($id = 0)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        if ($this->gedung->is_gedung_exist($id)) {
            $data = $this->gedung->gedung_data($id);

            $gedung['title'] = 'Edit ' . $data->nama_gedung;

            $gedung['flash'] = $this->session->getflashdata('edit_product_flash');
            $gedung['gedung'] = $data;

            return view('gedung/edit_gedung', $gedung);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function edit_gedung()
    {

        $validate = $this->validate([
            'nama_gedung' => [
                'label' => 'Nama Gedung',
                'rules' => 'trim|required|min_length[4]|max_length[20]'
            ],

        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        // if ($this->validation->run() == FALSE) {
        //     $id = $this->request->getPost('id');
        //     $this->edit($id);
        // } else {
        $id = $this->request->getPost('id');
        $data = $this->gedung->gedung_data($id);
        $current_picture = $data->foto;

        $name = $this->request->getPost('nama_gedung');

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
            $img->move('assets/uploads/gedung');
            $new_file_name = $img->getName();

            if ($this->gedung->is_gedung_have_image($id)) {
                $file = './assets/uploads/gedung/' . $current_picture;

                $file_name = $new_file_name;
                unlink($file);
            } else {
                $file_name = $new_file_name;
            }
        } else {
            $file_name = ($this->gedung->is_gedung_have_image($id)) ? $current_picture : NULL;
        }



        $gedung['nama_gedung'] = $name;
        $gedung['foto'] = $file_name;

        $this->gedung->edit_gedung($id, $gedung);
        $this->session->setflashdata('edit_product_flash', 'Produk berhasil diperbarui!');

        return redirect()->to(base_url('gedung/view/' . $id));
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
                $data = $this->gedung->gedung_data($id);
                $picture_name = $data->foto;
                $file = './assets/uploads/gedung/' . $picture_name;

                if (file_exists($file) && is_readable($file)) {
                    if ($data->foto != 'default.jpg') {
                        unlink($file);
                    }
                    $this->gedung->delete_gedung_image($id);
                    $response = array('code' => 204, 'message' => 'Gambar berhasil dihapus');
                } else {
                    $response = array('code' => 200, 'message' => 'Terjadi kesalahan sata menghapus gambar');
                }
                break;
            case 'delete_product':
                $id = $this->request->getPost('id');
                $data = $this->gedung->gedung_data($id);
                $picture = $data->foto;
                $file = './assets/uploads/gedung/' . $picture;

                $this->gedung->delete_gedung($id);

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
        if ($this->gedung->is_gedung_exist($id)) {
            $data = $this->gedung->gedung_data($id);

            $gedung['title'] = $data->nama_gedung . ' | Data Gedung ';

            $gedung['gedung'] = $data;
            $gedung['totalRuangan'] = $this->ruangan->count_ruangan_in_gedung($id);
            $gedung['flash'] = $this->session->getflashdata('product_flash');
            $gedung['ruangans'] = $this->ruangan->rungan_in_gedung($id);

            return view('gedung/view', $gedung);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
