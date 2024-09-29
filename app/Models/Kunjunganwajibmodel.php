<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Kunjunganwajibmodel extends Model
{
    protected $table      = 'tbkunjunganwajib';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['created_at', 'id_nasabah', 'follwup_date','location','photo','keterangan','status','kolektor'];

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