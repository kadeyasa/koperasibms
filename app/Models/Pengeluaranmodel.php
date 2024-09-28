<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Pengeluaranmodel extends Model
{
    protected $table      = 'tbpengeluaran';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['akun', 'tgl', 'uraian','jumlah','id_transaksi'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}