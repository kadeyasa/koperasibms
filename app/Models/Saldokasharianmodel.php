<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Saldokasharianmodel extends Model
{
    protected $table      = 'tbsaldokasharian';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['created_at', 'updated_at','deleted_at','kode_akun','debet','kredit','uraian'];

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

    public function getTagihanByAkun($username,$akun,$start,$end){
        $sql ="SELECT SUM(jumlah_pokok+jumlah_bunga) AS totaltagihan FROM tbdataangsuranpinjaman WHERE id_transaksi IN(SELECT DISTINCT a.id_transaksi FROM tbdataangsuranpinjaman a JOIN tbjurnal b ON a.id_transaksi = b.id_transaksi WHERE a.username = '$username' AND b.kode_akun = '$akun' AND tgl_bayar >= '$start' AND tgl_bayar <= '$end' GROUP BY a.id )";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    public function getTitipanByAkun($username,$akun,$start,$end,$kas){
        $end = $end.' 23:59:59';
        $sql="SELECT SUM($kas) AS $kas FROM tbtitipan WHERE kode_akun='$akun' AND inputby='$username' AND created_at>='$start' AND created_at<'$end'";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    public function getTotalTagihanBulan(){
        $start = date('Y-m-01');
        $end = date('Y-m-t');
        $sql ="SELECT SUM(jumlah_pokok+jumlah_bunga) AS totaltagihan FROM tbdataangsuranpinjaman  WHERE tgl_bayar >= '$start' AND tgl_bayar <= '$end' AND id_transaksi<>'PELUNASANOB' AND status='1'";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    public function getTotalTagihanHarian(){
        $start = date('Y-m-d');
        $end = date('Y-m-d 23:59:59');
        $sql ="SELECT SUM(jumlah_pokok+jumlah_bunga) AS totaltagihan FROM tbdataangsuranpinjaman  WHERE tgl_bayar >= '$start' AND tgl_bayar <= '$end' AND id_transaksi<>'PELUNASANOB' AND status='1'";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    public function getTotalPendapatan($start,$end){
        $sql ="SELECT SUM(jumlah) AS total FROM tbpendapatan WHERE tgl>='$start' AND tgl<='$end' AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    public function getTotalPenngeluaran($start,$end){
        $sql ="SELECT SUM(jumlah) AS total FROM tbpengeluaran WHERE tgl>='$start' AND tgl<='$end' AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    public function getTotalTagihanHarianPelunasan(){
        $start = date('Y-m-d');
        $end = date('Y-m-d 23:59:59');
        $sql ="SELECT SUM(jumlah_pokok+jumlah_bunga) AS totaltagihan FROM tbdataangsuranpinjaman  WHERE tgl_bayar >= '$start' AND tgl_bayar <= '$end' AND id_transaksi='PELUNASANOB' AND status='1'";
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    public function getPencairan($start,$end){
        $sql="SELECT * FROM tbdatapinjaman WHERE tgl >='$start' AND tgl<='$end' ORDER BY id ASC";
        $query = $this->db->query($sql);
        $results = $query->getResult();
        return $results;
    }

    public function insertDataAll($data){
        return $this->insertBatch($data);
    }
}   