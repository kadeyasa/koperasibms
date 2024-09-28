<?php

namespace App\Models;

use CodeIgniter\Model;

class Biayapinjamanmodel extends Model
{
    protected $table      = 'tbbiayapinjaman';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nama_biaya','jenis_biaya','jumlah','status','id_pinjaman','kode_akun'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getData(){
        $query = $this->db->table('tbbiayapinjaman a')
                ->select("a.*,b.nama_simpanan")
                ->join('tbsetuppinjaman b','b.id=a.id_pinjaman')
                ->where('a.deleted_at',NULL);
        return $query->get();
    }
}