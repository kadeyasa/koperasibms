<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Anggotamodel extends Model
{
    protected $table      = 'tbanggota';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['no_anggota', 'nama', 'alamat','jenis_kelamin','no_telp','nik','jenis_anggota','photo_ktp','status','email','koordinat'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function addCalonAnggota($data){
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }
}