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
        $sql ="SELECT a.*,b.nama_simpanan,(SELECT CONCAT(keterangan,', Janji Tgl : ',janji_tgl,' Followup tgl :',tgl_followup)  FROM tblaporankunjungan b WHERE b.id_anggota=a.id_anggota ORDER BY id DESC LIMIT 1) as followup FROM detailpinjaman_v a LEFT JOIN tbsetuppinjaman b ON b.id=a.jenis_pinjaman WHERE a.jenis_pinjaman IN(SELECT id FROM tbsetuppinjaman a WHERE jenis_pinjaman=3)  AND totaltunggakan>0 ORDER BY totaltunggakan DESC LIMIT $page,$totalrow ";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    public function getpinjamanmingguan($page=0,$totalrow=50){
        $sql ="SELECT a.*,b.nama_simpanan,(SELECT CONCAT(keterangan,', Janji Tgl : ',janji_tgl,' Followup tgl :',tgl_followup)  FROM tblaporankunjungan b WHERE b.id_anggota=a.id_anggota ORDER BY id DESC LIMIT 1) as followup FROM detailpinjaman_v a LEFT JOIN tbsetuppinjaman b ON b.id=a.jenis_pinjaman WHERE a.jenis_pinjaman IN(SELECT id FROM tbsetuppinjaman a WHERE jenis_pinjaman=2)  AND totaltunggakan>0 ORDER BY totaltunggakan DESC LIMIT $page,$totalrow ";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    public function getcount(){
        $sql="SELECT COUNT(*) total FROM tbdatapinjaman WHERE sisa_pinjaman<>0";
        $query = $this->db->query($sql);
        return $query->getRow();
    }

    public function insertkujungan($data){
        $sql ="INSERT INTO tblaporankunjungan(user_id,id_anggota,tgl_followup,keterangan,janji_tgl) VALUES('".$data['user_id']."','".$data['id_anggota']."','".$data['tgl_followup']."','".$data['keterangan']."','".$data['janji_tgl']."');";
        //echo json_encode($data);
        $query = $this->db->query($sql);
        return $query;
    }
}