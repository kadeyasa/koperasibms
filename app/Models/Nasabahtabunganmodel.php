<?php

namespace App\Models;
use CodeIgniter\Model;
$db = \Config\Database::connect();

class Nasabahtabunganmodel extends Model
{
    protected $table      = 'tbnasabah_tabungan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nama', 'alamat','no_hp','no_rekening','nik','created_at','updated_at','deleted_at'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}