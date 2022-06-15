<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\Gedung_model;
use App\Models\Ruangan_model;
use CodeIgniter\Validation\Rules;

class Ruangan extends BaseController
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
            'title' => ' Data Ruangan',
            'datas' => $this->ruangan->orderBy('nama_ruangan', 'ASC')->get()->getResult(),
        ];
        $html = view('ruangan/pdf', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream('Data Ruangan.pdf', array(
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
            $ruangan = $this->ruangan->like('nama_ruangan', $search_query);
        } else {
            $ruangan = $this->ruangan;
        }
        $data = [
            'title' => 'Kelola Ruangan',
            'ruangan' => $ruangan->orderBy('nama_ruangan', 'ASC')->paginate(8, 'card'),
            'pager' => $this->ruangan->pager
        ];
        return view('ruangan/ruangan', $data);
    }


    public function tambah()
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        $gedung['title'] = 'Tambah Gedung Baru';
        $gedung['flash_error'] = $this->session->getflashdata('terisi_ruangan');
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
            ],
            'kapasitas_ruangan' => [
                'label' => 'Kapasitas Ruangan',
                'rules' => 'required|numeric'
            ],
            'terisi_ruangan' => [
                'label' => 'Terisi',
                'rules' => 'required|numeric'
            ],
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $nama_ruangan = $this->request->getPost('nama_ruangan');
        $id_gedung = $this->request->getPost('id_gedung');
        $id_user = $this->request->getPost('id_user');
        $kapasitas_ruangan = $this->request->getPost('kapasitas_ruangan');
        $terisi_ruangan = $this->request->getPost('terisi_ruangan');
        $img = $this->request->getFile('picture');
        if ($terisi_ruangan > $kapasitas_ruangan) {
            $this->session->setFlashdata('terisi_ruangan', 'Terisi tidak boleh melebihi kapasitas ruangan');
            return redirect()->back()->withInput();
        }
        if ($img->getName() != 'default.jpg') {
            $img->move('assets/uploads/ruangan');
        }

        $ruangan['nama_ruangan'] = $nama_ruangan;
        $ruangan['id_gedung'] = $id_gedung;
        $ruangan['id_user'] = $id_user;
        $ruangan['kapasitas_ruangan'] = $kapasitas_ruangan;
        $ruangan['terisi_ruangan'] = $terisi_ruangan;
        $ruangan['foto'] = $img->getName();
        $this->ruangan->add_new_ruangan($ruangan);
        $this->session->setFlashdata('add_new_product_flash', 'Produk baru berhasil ditambahkan!');

        return redirect()->to(base_url('ruangan/tambah'));
        // }
    }


    public function edit($id = 0)
    {
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return redirect()->to(base_url('auth'));
        }
        if ($this->ruangan->is_ruangan_exist($id)) {
            $data = $this->ruangan->ruangan_data($id);

            $ruangan['title'] = 'Edit ' . $data->nama_ruangan;

            $ruangan['flash'] = $this->session->getflashdata('edit_product_flash');
            $ruangan['flash_error'] = $this->session->getflashdata('terisi_ruangan');
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
            'kapasitas_ruangan' => [
                'label' => 'Kapasitas Ruangan',
                'rules' => 'required|numeric'
            ],
            'terisi_ruangan' => [
                'label' => 'Terisi',
                'rules' => 'required|numeric'
            ],
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $nama_ruangan = $this->request->getPost('nama_ruangan');
        $id_gedung = $this->request->getPost('id_gedung');
        $kapasitas_ruangan = $this->request->getPost('kapasitas_ruangan');
        $terisi_ruangan = $this->request->getPost('terisi_ruangan');
        $id = $this->request->getPost('id');
        $data = $this->ruangan->ruangan_data($id);
        $current_picture = $data->foto;

        if ($terisi_ruangan > $kapasitas_ruangan) {
            $this->session->setFlashdata('terisi_ruangan', 'Terisi tidak boleh melebihi kapasitas ruangan');
            return redirect()->back()->withInput();
        }

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
        $ruangan['kapasitas_ruangan'] = $kapasitas_ruangan;
        $ruangan['terisi_ruangan'] = $terisi_ruangan;

        $this->ruangan->edit_ruangan($id, $ruangan);
        $this->session->setflashdata('edit_product_flash', 'Produk berhasil diperbarui!');

        return redirect()->to(base_url('ruangan/view/' . $id));
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
