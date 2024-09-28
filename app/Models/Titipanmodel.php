<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Titipanmodel extends Model
{
    protected $table      = 'tbtitipan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['created_at', 'updated_at', 'deleted_at','id_anggota','debet','kredit','balance','status','inputby','kode_akun'];

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

    public function getJumlahAngsuran($id_nasabah){
        $sql="SELECT a.* FROM tbdataangsuranpinjaman a JOIN tbdatapinjaman b ON a.id_pinjaman=b.id WHERE b.id_anggota='$id_nasabah' AND b.sisa_pinjaman>0 AND a.status=0 ORDER BY a.id ASC LIMIT 1";
       
        $query = $this->db->query($sql);
        $row = $query->getRow();
        return $row;
    }

    public function updateData($id_nasabah,$data){
        return $this->db->table('tbtitipan')
        ->where('id_anggota',$id_nasabah)
        ->update($data);
    }

    public function updateAngsuran($id,$data){
        return $this->db->table('tbdataangsuranpinjaman')
        ->where('id',$id)
        ->update($data);
    }
}

