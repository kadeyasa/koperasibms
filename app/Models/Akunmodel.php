<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Akunmodel extends Model
{
    protected $table      = 'tbaccount';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['no_akun', 'saldo_normal', 'level_account','account_name','sub_account'];

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

    function getSaldo($tahun,$sub){
        $tahun = $tahun.'-01';
        $sql="SELECT a.*,(SELECT SUM(b.debet-b.kredit) FROM tbjurnal b WHERE b.kode_akun=a.no_akun AND b.deleted_at IS NULL and b.date <='$tahun') AS balance FROM tbaccount a WHERE a.sub_account='$sub'";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    function getSubAccounts($account_name){
        $sql="SELECT a.*,b.account_name FROM tbsaldoakun a JOIN tbaccount b ON b.no_akun=a.kode_akun WHERE a.kode_akun IN(SELECT no_akun FROM tbaccount WHERE sub_account IN(SELECT id FROM tbaccount WHERE account_name='KAS & BANK'));";
        $query = $this->db->query($sql);
        return $query->getResult();
    }
}