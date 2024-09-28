<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Jurnalmodel extends Model
{
    protected $table      = 'tbjurnal';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_transaksi', 'date', 'kode_akun','uraian	','debet','kredit','uraian','jenis_transaksi'];

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

    public function getJurnalUmum($account,$start_date,$end_date){
        if($account==''){
            $query = $this->db->table('tbjurnal a')
                    ->join('tbaccount b','b.no_akun=a.kode_akun')
                    ->select("a.date,b.account_name,a.id_transaksi,a.uraian,a.debet,a.kredit,a.kode_akun")
                    ->orderBy('a.date','ASC')
                    ->where('a.date >=',$start_date)
                    ->where('a.date <=',$end_date)
                    ->get();
        }else{
            $query = $this->db->table('tbjurnal a')
                    ->join('tbaccount b','b.no_akun=a.kode_akun')
                    ->select("a.date,b.account_name,a.id_transaksi,a.uraian,a.debet,a.kredit,a.kode_akun")
                    ->orderBy('a.date','ASC')
                    ->where('a.kode_akun',$account)
                    ->where('a.date >=',$start_date)
                    ->where('a.date <=',$end_date)
                    ->get();
        }
        return $query->getResult();
    }

}