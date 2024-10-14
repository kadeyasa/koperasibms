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

    function getsaldoawal(){
        $sql = "SELECT sum(debet) AS totalsaldoawal FROM `tb_mutasi_tabungan` WHERE uraian='Saldo Awal'";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    function gettotalmutasi($start,$end,$status){
        $sql = "SELECT sum(debet) AS totalmutasi FROM `tb_mutasi_tabungan` WHERE uraian<> 'Saldo Awal' AND created_at >='$start' AND created_at<='$end' AND status='$status' AND debet>0";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    function gettotalmutasikredit($start,$end,$status){
        $sql = "SELECT sum(kredit) AS totalmutasi FROM `tb_mutasi_tabungan` WHERE uraian<> 'Saldo Awal' AND created_at >='$start' AND created_at<='$end' AND status='$status' AND kredit>0";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }
}