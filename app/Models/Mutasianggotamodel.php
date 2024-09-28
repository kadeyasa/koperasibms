<?php

namespace App\Models;

use CodeIgniter\Model;

class Mutasianggotamodel extends Model
{
    protected $table      = 'tbmutasianggota';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_anggota', 'id_transaksi', 'kode_transaksi','tgl_transaksi','debet','kredit','balance','status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}