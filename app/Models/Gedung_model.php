<?php

namespace App\Models;

use CodeIgniter\Model;

class Gedung_model extends Model
{
    protected $table = 'tb_gedung';

    public function count_all_gedung()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_gedung')->countAllResults();
    }

    public function get_all_gedung($limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_gedung = $this->db->table('tb_gedung')->get($limit, $start)->getResult();

        return $tb_gedung;
    }

    public function search_gedung($query, $limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_gedung = $this->db->table('tb_gedung')->like('name', $query)->orLike('description', $query)->get($limit, $start)->getResult();

        return $tb_gedung;
    }

    public function count_search($query)
    {
        $this->db = \Config\Database::connect();
        $count = $this->db->table('tb_gedung')->like('name', $query)->orLike('description', $query)->countAllResults();;

        return $count;
    }

    public function add_new_gedung(array $gedung)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('tb_gedung')->insert($gedung);

        return $this->db->insertID();
    }

    public function is_gedung_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('tb_gedung')->where('id_gedung', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function gedung_data($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->query("
            SELECT * FROM tb_gedung 
            WHERE tb_gedung.id_gedung = '$id'
        ")->getRow();

        return $data;
    }

    public function delete_gedung_image($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_gedung')->where('id_gedung', $id)->update(array('foto' => NULL));
    }

    public function is_gedung_have_image($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->gedung_data($id);
        $file = $data->foto;
        if ($file == NULL) {
            return FALSE;
        }
        return file_exists('./assets/uploads/gedung/' . $file) ? TRUE : FALSE;
    }

    public function edit_gedung($id, $gedung)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_gedung')->where('id_gedung', $id)->update($gedung);
    }

    public function delete_gedung($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_gedung')->where('id_gedung', $id)->delete();
    }
}
