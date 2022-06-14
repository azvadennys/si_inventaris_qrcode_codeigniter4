<?php

namespace App\Models;

use CodeIgniter\Model;

class Masuk_model extends Model
{
    protected $table = 'tb_pbarangmasuk';

    public function count_all_masuk()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_pbarangmasuk')->countAllResults();
    }

    public function get_all_masuk($limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_pbarangmasuk = $this->db->table('tb_pbarangmasuk')->get($limit, $start)->getResult();

        return $tb_pbarangmasuk;
    }

    public function search_masuk($query, $limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_pbarangmasuk = $this->db->table('tb_pbarangmasuk')->like('name', $query)->orLike('description', $query)->get($limit, $start)->getResult();

        return $tb_pbarangmasuk;
    }

    public function count_search($query)
    {
        $this->db = \Config\Database::connect();
        $count = $this->db->table('tb_pbarangmasuk')->like('name', $query)->orLike('description', $query)->countAllResults();;

        return $count;
    }

    public function add_new_masuk(array $masuk)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('tb_pbarangmasuk')->insert($masuk);

        return $this->db->insertID();
    }

    public function is_masuk_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('tb_pbarangmasuk')->where('id_pengadaan', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function masuk_data($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->query("
            SELECT * FROM tb_pbarangmasuk 
            WHERE tb_pbarangmasuk.id_pengadaan = '$id'
        ")->getRow();

        return $data;
    }

    public function delete_masuk_image($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_pbarangmasuk')->where('id_pengadaan', $id)->update(array('foto' => NULL));
    }

    public function is_masuk_have_image($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->masuk_data($id);
        $file = $data->foto;
        if ($file == NULL) {
            return FALSE;
        }
        return file_exists('./assets/uploads/masuk/' . $file) ? TRUE : FALSE;
    }

    public function edit_masuk($id, $masuk)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_pbarangmasuk')->where('id_pengadaan', $id)->set($masuk)->update();
    }

    public function delete_masuk($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_pbarangmasuk')->where('id_pengadaan', $id)->delete();
    }
    public function get_all_nama_masuk()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_pbarangmasuk')->orderBy('nama_masuk', 'ASC')->get()->getResult();
    }
    public function count_ruangan_in_masuk($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan r')->select('r.*, r.id_user as Penambah, g.nama_masuk')->join('tb_pbarangmasuk g', 'g.id_pengadaan = r.id_pengadaan')->where('r.id_pengadaan', $id)->countAllResults();
    }
}
