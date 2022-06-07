<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class User_Model extends Model{
    protected $table = 'tb_user';
    protected $allowedFields = ['nama','username','password'];
}