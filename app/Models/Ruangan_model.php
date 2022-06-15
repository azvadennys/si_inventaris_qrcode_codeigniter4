<?php

namespace App\Models;

use CodeIgniter\Model;

class Ruangan_model extends Model
{
    protected $table = 'tb_ruangan';
    public function rungan_in_gedung($id)
    {
        $this->db = \Config\Database::connect();
        $orders = $this->db->query("
            SELECT r.*, r.id_user as Penambah, g.nama_gedung,u.nama
            FROM tb_ruangan r
            JOIN tb_gedung g
	            ON g.id_gedung = r.id_gedung
         JOIN tb_user u
	            ON u.id_user = r.id_user
            WHERE r.id_gedung = '$id'
            ORDER BY `r`.`nama_ruangan` ASC ");

        return $orders->getResult();
    }
    public function count_all_ruangan()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan')->countAllResults();
    }
    public function count_ruangan_in_gedung($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan r')->select('r.*, r.id_user as Penambah, g.nama_gedung')->join('tb_gedung g', 'g.id_gedung = r.id_gedung')->where('r.id_gedung', $id)->countAllResults();
    }
    public function count_barang_in_ruangan($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan r')->select('r.*, r.id_user as Penambah')->join('tb_barang b', 'b.id_ruangan = r.id_ruangan')->where('r.id_ruangan', $id)->countAllResults();
    }

    public function get_all_ruangan()
    {
        $this->db = \Config\Database::connect();
        $tb_ruangan = $this->db->table('tb_ruangan')->get()->getResult();

        return $tb_ruangan;
    }

    public function search_ruangan($query, $limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_ruangan = $this->db->table('tb_ruangan')->like('name', $query)->orLike('description', $query)->get($limit, $start)->getResult();

        return $tb_ruangan;
    }

    public function count_search($query)
    {
        $this->db = \Config\Database::connect();
        $count = $this->db->table('tb_ruangan')->like('name', $query)->orLike('description', $query)->countAllResults();;

        return $count;
    }

    public function add_new_ruangan(array $ruangan)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('tb_ruangan')->insert($ruangan);

        return $this->db->insertID();
    }

    public function is_ruangan_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('tb_ruangan')->where('id_ruangan', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function ruangan_data($id)
    {
        // $this->db = \Config\Database::connect();
        // $data = $this->db->query("
        //     SELECT * FROM tb_ruangan 
        //     WHERE tb_ruangan.id_ruangan = '$id'
        // ")->getRow();

        // return $data;
        $this->db = \Config\Database::connect();
        $orders = $this->db->query("
            SELECT r.*, r.id_user as Penambah, g.nama_gedung,u.nama
            FROM tb_ruangan r
            JOIN tb_gedung g
	            ON g.id_gedung = r.id_gedung
         JOIN tb_user u
	            ON u.id_user = r.id_user
            WHERE r.id_ruangan = '$id'");

        return $orders->getRow();
    }

    public function delete_ruangan_image($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan')->where('id_ruangan', $id)->update(array('foto' => NULL));
    }

    public function is_ruangan_have_image($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->ruangan_data($id);
        $file = $data->foto;
        if ($file == NULL) {
            return FALSE;
        }
        return file_exists('./assets/uploads/ruangan/' . $file) ? TRUE : FALSE;
    }

    public function edit_ruangan($id, $ruangan)
    {
        $this->db = \Config\Database::connect();

        return $this->db->table('tb_ruangan')->where('id_ruangan', $id)->set($ruangan)->update();
    }

    public function delete_ruangan($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan')->where('id_ruangan', $id)->delete();
    }
    public function get_all_nama_ruangan()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan')->orderBy('nama_ruangan', 'ASC')->get()->getResult();
    }
}
