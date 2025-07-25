<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Profilemodel extends Model
{
    protected $table      = 'tbprofilekoperasi';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nama', 'alamat', 'no_telp','no_akta','logo','iuran_pokok','iuran_wajib'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}