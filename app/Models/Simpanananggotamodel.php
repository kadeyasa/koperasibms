<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();
class Simpanananggotamodel extends Model
{
    protected $table      = 'tbsimpanananggota';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_anggota', 'id_transaksi', 'id_jenis_simpanan','tgl','tgl_jatuh_tempo','jumlah','status'];

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

    public function addbungadeposito($data){
        return $this->db->table('tbbungatabungan')
        ->insert($data);
    }

    public function getdatasimpanananggota(){
        $sql='SELECT DISTINCT id_anggota,SUM(jumlah) as totaltabungan,(SELECT SUM(debet-kredit) FROM tbbungatabungan WHERE tbbungatabungan.id_anggota=tbsimpanananggota.id_anggota) AS totalbunga ,nama FROM tbsimpanananggota LEFT JOIN tbanggota ON tbanggota.id=tbsimpanananggota.id_anggota WHERE tbsimpanananggota.status=1 GROUP BY tbsimpanananggota.id_anggota;';
        $query = $this->db->query($sql)->getResult();
        return $query;
    }

    public function getsaldoanggota($id_anggota){
        $sql ="SELECT SUM(debet-kredit) AS total FROM tbbungatabungan WHERE id_anggota='$id_anggota'";
        $query = $this->db->query($sql)->getRow();
        return $query;
    }

    public function savehistorytabungan($data){
        return $this->db->table('tbhistorybungatabungan')->insert($data);
    }
}