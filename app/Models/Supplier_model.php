<?php

namespace App\Models;

use CodeIgniter\Model;

class Supplier_model extends Model
{
    protected $table = 'tb_supplier';

    public function count_all_supplier()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_supplier')->countAllResults();
    }

    public function get_all_supplier($limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_supplier = $this->db->table('tb_supplier')->get($limit, $start)->getResult();

        return $tb_supplier;
    }

    public function search_supplier($query, $limit, $start)
    {
        $this->db = \Config\Database::connect();
        $tb_supplier = $this->db->table('tb_supplier')->like('name', $query)->orLike('description', $query)->get($limit, $start)->getResult();

        return $tb_supplier;
    }

    public function count_search($query)
    {
        $this->db = \Config\Database::connect();
        $count = $this->db->table('tb_supplier')->like('name', $query)->orLike('description', $query)->countAllResults();;

        return $count;
    }

    public function add_new_supplier(array $supplier)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('tb_supplier')->insert($supplier);

        return $this->db->insertID();
    }

    public function is_supplier_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('tb_supplier')->where('id_supplier', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function supplier_data($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->query("
            SELECT * FROM tb_supplier 
            WHERE tb_supplier.id_supplier = '$id'
        ")->getRow();

        return $data;
    }

    public function delete_supplier_image($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_supplier')->where('id_supplier', $id)->update(array('foto' => NULL));
    }

    public function is_supplier_have_image($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->supplier_data($id);
        $file = $data->foto;
        if ($file == NULL) {
            return FALSE;
        }
        return file_exists('./assets/uploads/supplier/' . $file) ? TRUE : FALSE;
    }

    public function edit_supplier($id, $supplier)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_supplier')->where('id_supplier', $id)->set($supplier)->update();
    }

    public function delete_supplier($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_supplier')->where('id_supplier', $id)->delete();
    }
    public function get_all_nama_supplier()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_supplier')->orderBy('nama_supplier', 'ASC')->get()->getResult();
    }
    public function count_ruangan_in_supplier($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('tb_ruangan r')->select('r.*, r.id_user as Penambah, g.nama_supplier')->join('tb_supplier g', 'g.id_supplier = r.id_supplier')->where('r.id_supplier', $id)->countAllResults();
    }
}
