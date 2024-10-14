<?php

namespace App\Models;
use CodeIgniter\Model;
$db = \Config\Database::connect();

class Mutasitabunganmodel extends Model
{
    protected $table      = 'tb_mutasi_tabungan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_nasabah', 'transaksi_id','kredit','uraian','photo_buku','status','debet','created_at','updated_at','deleted_at'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}