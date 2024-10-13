<?php

namespace App\Models;
use CodeIgniter\Model;
$db = \Config\Database::connect();

class Saldomodel extends Model
{
    protected $table      = 'tb_saldo_tabungan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_nasabah', 'saldo'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}