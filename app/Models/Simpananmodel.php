<?php

namespace App\Models;

use CodeIgniter\Model;

class Simpananmodel extends Model
{
    protected $table      = 'tbsimpananpokok';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_anggota', 'tgl_transaksi', 'debit','kredit','status','id_transaksi'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getSimpananPokok(){
        $query = $this->db->table('tbsimpananpokok a')
                    ->select('a.*,b.nama,b.no_anggota')
                    ->join('tbanggota b','a.id_anggota=b.id')
                    ->orderby('a.id_anggota ASC')
                    ->where('a.deleted_at',NULL);
        return $query->get();
    }

    public function getSimpananWajib(){
        $query = $this->db->table('tbsimpananwajib a')
                    ->select('a.*,b.nama,b.no_anggota')
                    ->join('tbanggota b','a.id_anggota=b.id')
                    ->orderby('a.id_anggota ASC');
        return $query->get();
    }

    public function getTotalSimpananPokok($id_anggota){
        $query = $this->db->table('tbdatasaldosimpananpokok')
                ->where('id_anggota',$id_anggota);
        return $query->get();
    }

    public function getTagihanWajib($start_date,$end_date){
        $query = $this->db->table('tbanggota a')
                ->select("a.*,(select id_transaksi from tbsimpananwajib b where b.id_anggota=a.id and b.tgl_transaksi>='$start_date' and b.tgl_transaksi<='$end_date' LIMIT 1) as id_transaksi,(select debit from tbsimpananwajib b where b.id_anggota=a.id and b.tgl_transaksi>='$start_date' and b.tgl_transaksi<='$end_date' LIMIT 1) as debet");
        return $query->get();
    }

    public function getSimpanananggota(){
        $query = $this->db->table('tbsimpanananggota a')
                    ->join('tbsetupsimpanan c','c.id=a.id_jenis_simpanan')
                    ->join('tbanggota b','b.id=a.id_anggota')
                    ->select("a.*,b.no_anggota,b.nama,c.nama_simpanan,c.jangka")
                    ->orderBy('tgl','DESC');
        return $query->get();
    }
}