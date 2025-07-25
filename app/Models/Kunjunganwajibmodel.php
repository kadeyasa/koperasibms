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

    protected $allowedFields = ['created_at', 'id_nasabah', 'follwup_date','location','photo','keterangan','status','kolektor','statuskunjungan','tgl_janji'];

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
    
    function getRestData($kolektor,$start,$end){
        if($kolektor=='all'){
            $sql ="SELECT * FROM `tbkunjunganwajib` a JOIN tbanggota b ON a.id_nasabah=b.no_anggota WHERE a.follwup_date>='$start' AND a.follwup_date<='$end' ORDER BY tgl_janji DESC";
        }else{
            $sql ="SELECT * FROM `tbkunjunganwajib` a JOIN tbanggota b ON a.id_nasabah=b.no_anggota WHERE a.kolektor='$kolektor' AND a.follwup_date>='$start' AND a.follwup_date<='$end' ORDER BY tgl_janji DESC";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        $row = $query->getResult();
        return $row;
    }

    function getRestDataKolektor($kolektor,$start,$end){
        if($kolektor=='all'){
            $sql ="SELECT * FROM `tbkunjunganwajib` a JOIN tbanggota b ON a.id_nasabah=b.no_anggota WHERE a.statuskunjungan=0 ORDER BY tgl_janji DESC";
        }else{
            $sql ="SELECT * FROM `tbkunjunganwajib` a JOIN tbanggota b ON a.id_nasabah=b.no_anggota WHERE a.statuskunjungan=0 AND a.kolektor='$kolektor' ORDER BY tgl_janji DESC";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        $row = $query->getResult();
        return $row;
    }

    function getDataById($id){
        $sql ="SELECT a.*,b.nama,b.alamat FROM `tbkunjunganwajib` a JOIN tbanggota b ON a.id_nasabah=b.no_anggota WHERE a.id_nasabah='$id' ORDER BY a.id DESC";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    function updatekunjungan($id_nasabah){
        $keterangan = "Bayar tanggal ".date('Y-m-d');
        $sql="UPDATE tbkunjunganwajib SET statuskunjungan='1', keterangan='$keterangan' WHERE id_nasabah='$id_nasabah'";
        $query = $this->db->query($sql);
        return $query;
    }
}