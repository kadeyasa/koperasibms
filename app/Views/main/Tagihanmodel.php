<?php

namespace App\Models;
use CodeIgniter\Model;
$db = \Config\Database::connect();

class Tagihanmodel extends Model
{
    protected $table      = 'datapinjaman_v';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_anggota', 'rek_pinjaman', 'id_transaksi','jenis_pinjaman','lama_pinjaman'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getpinjamanbulanan($page=0,$totalrow=50){
        $sql ="SELECT a.*,b.nama_simpanan FROM detailpinjaman_v a LEFT JOIN tbsetuppinjaman b ON b.id=a.jenis_pinjaman WHERE a.jenis_pinjaman IN(SELECT id FROM tbsetuppinjaman a WHERE jenis_pinjaman=3)  AND totaltunggakan>0 LIMIT $page,$totalrow ORDER BY totaltunggakan DESC";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    public function getcount(){
        $sql="SELECT COUNT(*) total FROM tbdatapinjaman WHERE sisa_pinjaman<>0";
        $query = $this->db->query($sql);
        return $query->getRow();
    }
}