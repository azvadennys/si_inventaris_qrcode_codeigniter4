<?php

namespace App\Models;

use CodeIgniter\Model;

class Barang_model extends Model
{
    protected $table = 'tb_barang';

    public function count_all_barang()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_barang')->countAllResults();
    }

    public function get_all_barang($limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_barang = $this->db->table('tb_barang')->get($limit, $start)->getResult();

        return $tb_barang;
    }

    public function search_barang($query, $limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_barang = $this->db->table('tb_barang')->like('name', $query)->orLike('description', $query)->get($limit, $start)->getResult();

        return $tb_barang;
    }

    public function count_search($query)
    {
        $this->db = \Config\Database::connect();
        $count = $this->db->table('tb_barang')->like('name', $query)->orLike('description', $query)->countAllResults();;

        return $count;
    }

    public function add_new_barang(array $barang)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('tb_barang')->insert($barang);

        return $this->db->insertID();
    }

    public function is_barang_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('tb_barang')->where('id_barang', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function barang_data($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->query("
            SELECT * FROM tb_barang 
            WHERE tb_barang.id_barang = '$id'
        ")->getRow();

        return $data;
    }

    public function delete_barang_image($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_barang')->where('id_barang', $id)->update(array('foto' => NULL));
    }

    public function is_barang_have_image($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->barang_data($id);
        $file = $data->foto;
        if ($file == NULL) {
            return FALSE;
        }
        return file_exists('./assets/uploads/barang/' . $file) ? TRUE : FALSE;
    }

    public function edit_barang($id, $barang)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_barang')->where('id_barang', $id)->set($barang)->update();
    }

    public function delete_barang($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_barang')->where('id_barang', $id)->delete();
    }
    public function get_all_nama_barang()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_barang')->orderBy('nama_barang', 'ASC')->get()->getResult();
    }
    public function count_ruangan_in_barang($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan r')->select('r.*, r.id_user as Penambah, g.nama_barang')->join('tb_barang g', 'g.id_barang = r.id_barang')->where('r.id_barang', $id)->countAllResults();
    }
}
