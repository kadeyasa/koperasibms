<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class Pengajuanmodel extends Model
{
 
    public $db;
    public $builder;

    protected $table      = 'tbpengajuanpinjaman';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_anggota', 'jenis_pinjaman', 'tgl_pengajuan','jumlah','status','keterangan','jaminan','photo','bukti_pembayaran','user','detailstatus'];

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


    protected function _get_datatables_query($table, $column_order, $column_search, $order)
    {
        $this->builder = $this->db->table($table);
        //jika ingin join formatnya adalah sebagai berikut :
        $this->builder->join('tbsetuppinjaman','tbsetuppinjaman.id = '.$table.'.jenis_pinjaman');
        $this->builder->join('tbanggota','tbanggota.no_anggota = '.$table.'.id_anggota');
        $this->builder->select($table.".*,tbanggota.no_anggota,tbanggota.nama,tbanggota.no_telp,tbanggota.alamat,tbsetuppinjaman.nama_simpanan,tbsetuppinjaman.jangka,tbsetuppinjaman.bunga");
        //end Join
        $i = 0;

        foreach ($column_search as $item) {
            if(isset($_POST['search'])){
                if ($_POST['search']['value']) {

                    if ($i === 0) {
                        $this->builder->groupStart();
                        $this->builder->like($item, $_POST['search']['value']);
                    } else {
                        $this->builder->orLike($item, $_POST['search']['value']);
                    }

                    if (count($column_search) - 1 == $i)
                        $this->builder->groupEnd();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }

    }

    public function get_datatables($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if (isset($_POST['length']) && $_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);
        if ($data) {
            $this->builder->where($data);
        }

        $query = $this->builder->get();
        return $query->getResult();
    }

    public function count_filtered($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if ($data) {
            //$this->builder->where($data);
        }
        $this->builder->get();
        return $this->builder->countAll();
    }

    public function count_all($table, $data = '')
    {
        if ($data) {
            //$this->builder->where($data);
        }
        $this->builder->from($table);

        return $this->builder->countAll();
    }

    public function getdatapengajuandetail($id){
        $this->builder = $this->db->table('tbpengajuanpinjaman a');
        $this->builder
                      ->join('tbsetuppinjaman b','b.id=a.jenis_pinjaman')
                      ->join("tbanggota c",'c.no_anggota=a.id_anggota')
                      ->where('a.id',$id)
                      ->select('a.*,b.jangka,b.bunga,b.nama_simpanan,b.jenis_pinjaman as type,c.*');
        $query = $this->builder->get();
        return $query->getRow();
    }

    public function ceksaldoakun($kode_akun){
        $this->builder = $this->db->table('tbsaldoakun a')
                                        ->where('kode_akun',$kode_akun);
        $query = $this->builder->get();
        return $query->getRow();
        
    }

    public function getdatarek(){
        $sql ="SELECT MAX(id) as rek_pinjaman  FROM  tbdatapinjaman";
        $query = $this->db->query($sql);
        return $query->getRow();
    }

    public function updatedata($id,$data){
        return $this->db->table('tbpengajuanpinjaman')
                            ->where('id',$id)
                            ->update($data);
    }
    
}
