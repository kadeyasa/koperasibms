<?php

namespace App\Models;

use CodeIgniter\Model;

class Simpananwajibmodel extends Model
{
    protected $table      = 'tbsimpananwajib';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_anggota', 'tgl_transaksi', 'debit','kredit','status','id_transaksi','status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
    public function getSimpananWajib(){
        $query = $this->db->table('tbsimpananwajib a')
                    ->select('a.*,b.nama,b.no_anggota')
                    ->join('tbanggota b','a.id_anggota=b.id')
                    ->orderby('a.id_anggota ASC');
        return $query->get();
    }

}