<?php

namespace App\Models;
use App\Models\Statusmodel;
use CodeIgniter\Model;
$db = \Config\Database::connect();

class Statusmodel extends Model
{
    protected $table      = 'tbstatus';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function es_string($d){
        $this->builder = $this->db->table($table);
        return $this->builder->escape($d);
    }
}

