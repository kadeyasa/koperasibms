<?php
namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Pinjamanviewmodel extends Model
{
    public $db;
    public $builder;

    protected $table      = 'datapinjaman_v';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    //protected $allowedFields = ['id_anggota', 'akun', 'rek_pinjaman','jenis_pinjaman','lama_pinjaman','jumlah_pokok','jumlah_bunga','tgl','jumlah','sisa_pinjaman','status','id_transaksi','debt_colector'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}