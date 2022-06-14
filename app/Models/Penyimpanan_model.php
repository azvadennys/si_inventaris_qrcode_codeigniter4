<?php

namespace App\Models;

use CodeIgniter\Model;

class Penyimpanan_model extends Model
{
    protected $table = 'tb_menyimpan';

    public function count_all_menyimpan()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_menyimpan')->countAllResults();
    }

    public function get_all_menyimpan($limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_menyimpan = $this->db->table('tb_menyimpan')->get($limit, $start)->getResult();

        return $tb_menyimpan;
    }

    public function search_menyimpan($query, $limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_menyimpan = $this->db->table('tb_menyimpan')->like('name', $query)->orLike('description', $query)->get($limit, $start)->getResult();

        return $tb_menyimpan;
    }

    public function count_search($query)
    {
        $this->db = \Config\Database::connect();
        $count = $this->db->table('tb_menyimpan')->like('name', $query)->orLike('description', $query)->countAllResults();;

        return $count;
    }

    public function add_new_menyimpan(array $menyimpan)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('tb_menyimpan')->insert($menyimpan);

        return $this->db->insertID();
    }

    public function is_menyimpan_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('tb_menyimpan')->where('id_simpan', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function menyimpan_data($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->query("
            SELECT * FROM tb_menyimpan 
            WHERE tb_menyimpan.id_simpan = '$id'
        ")->getRow();

        return $data;
    }

    public function delete_menyimpan_image($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_menyimpan')->where('id_simpan', $id)->update(array('foto' => NULL));
    }

    public function is_menyimpan_have_image($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->menyimpan_data($id);
        $file = $data->foto;
        if ($file == NULL) {
            return FALSE;
        }
        return file_exists('./assets/uploads/menyimpan/' . $file) ? TRUE : FALSE;
    }

    public function edit_menyimpan($id, $menyimpan)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_menyimpan')->where('id_simpan', $id)->set($menyimpan)->update();
    }

    public function delete_menyimpan($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_menyimpan')->where('id_simpan', $id)->delete();
    }
    public function get_all_nama_menyimpan()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_menyimpan')->orderBy('nama_menyimpan', 'ASC')->get()->getResult();
    }
    public function count_ruangan_in_menyimpan($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan r')->select('r.*, r.id_user as Penambah, g.nama_menyimpan')->join('tb_menyimpan g', 'g.id_simpan = r.id_simpan')->where('r.id_simpan', $id)->countAllResults();
    }
}
