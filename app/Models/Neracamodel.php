<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Neracamodel extends Model
{
    protected $table      = 'tbneraca';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['bulan', 'tahun', 'balance','is_awal','saldo_normal','kode_akun','id_transaksi'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getDataAwal($tahun){
        $query = $this->db->table('tbneraca a')
                    ->select('a.*,b.account_name')
                    ->join('tbaccount b','a.kode_akun=b.no_akun')
                    ->orderby('a.kode_akun ASC')
                    ->where('a.deleted_at',NULL)
                    ->where('a.tahun',$tahun)
                    ->where('a.is_awal',1);
        return $query->get();
    }

    public function totalBalance($kode_akun,$tahun){
        $query = $this->db->table('tbneraca')->select('SUM(balance) AS jumlah')->where(array('kode_akun'=>$kode_akun,'deleted_at'=>NULL,'is_awal'=>1,'tahun'=>$tahun));
        return $query->get();
    }
}