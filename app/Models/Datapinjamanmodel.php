<?php

namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();

class Datapinjamanmodel extends Model
{
    public $db;
    public $builder;

    protected $table      = 'tbdatapinjaman';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_anggota', 'akun', 'rek_pinjaman','jenis_pinjaman','lama_pinjaman','jumlah_pokok','jumlah_bunga','tgl','jumlah','sisa_pinjaman','status','id_transaksi','debt_colector'];

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
        //$this->builder->join('tbusers','tbusers.id = '.$table.'.debt_colector');
        $this->builder->select($table.".*,tbanggota.no_anggota,tbanggota.nama,tbanggota.alamat,tbsetuppinjaman.nama_simpanan,tbsetuppinjaman.jangka,tbsetuppinjaman.bunga");
        //this->builder->where($table.".")
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
            //$this->builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            //$this->builder->orderBy(key($order), $order[key($order)]);
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

    public function cratemutasi($data){
        return $this->db->table('tbdatamutasipinjaman')
                    ->insert($data);
    }

    public function crateangsuran($data){
        return $this->db->table('tbdataangsuranpinjaman')
                    ->insert($data);
    }

    public function deleteanggsuran($id_pinjaman){
        return $this->db->table('tbdataangsuranpinjaman')
                            ->where('id_pinjaman',$id_pinjaman)
                            ->delete();
    }

    public function getangsuran($id_pinjaman){
        return $this->db->table('tbdataangsuranpinjaman')
                    ->where('id_pinjaman',$id_pinjaman)
                    ->orderby('tgl','ASC')
                    ->get()
                    ->getResult();
    }

    public function deletemutasi($id_pinjaman){
        return $this->db->table('tbdatamutasipinjaman')
                            ->where('id_pinjaman',$id_pinjaman)
                            ->delete();
    }

    public function getsaldo($akun){
        $r = $this->db->table('tbsaldoakun')
                ->where('kode_akun',$akun)
                ->get();
        return $r->getRow();
    }

    public function updatesaldoakun($akun,$data){
       return $this->db->table('tbsaldoakun')
                ->where('kode_akun',$akun)
                ->update($data);
    }

    public function getdetailpinjaman($table,$id){
        $this->builder = $this->db->table($table);
        //jika ingin join formatnya adalah sebagai berikut :
        $this->builder->join('tbsetuppinjaman','tbsetuppinjaman.id = '.$table.'.jenis_pinjaman');
        $this->builder->join('tbanggota','tbanggota.no_anggota = '.$table.'.id_anggota');
        $this->builder->select($table.".*,tbanggota.no_anggota,tbanggota.nama,tbanggota.alamat,tbanggota.no_telp,tbanggota.koordinat,tbanggota.nik,tbsetuppinjaman.nama_simpanan,tbsetuppinjaman.jangka,tbsetuppinjaman.bunga");
        $this->builder->where($table.'.id',$id);
        $query = $this->builder->get();
        return $query->getRow();
    }

    

    public function getdataangsurandetail($id){
        $this->builder = $this->db->table('tbdataangsuranpinjaman a');
        //$this->builder->join('tbdatapinjaman','tbdatapinjaman.id=a.id_pinjaman');
        //$this->builder->join('tbsetuppinjaman','tbsetuppinjaman.id = '.$table.'.jenis_pinjaman');
        //$this->builder->join('tbanggota','tbanggota.no_anggota = '.$table.'.id_anggota');
        //$this->builder->select('a.*',$table.".*,tbanggota.no_anggota,tbanggota.nama,tbanggota.alamat,tbanggota.no_telp,tbanggota.koordinat,tbsetuppinjaman.nama_simpanan,tbsetuppinjaman.jangka,tbsetuppinjaman.bunga");
        $this->builder->where('a.id',$id);
        $query = $this->builder->get();
        return $query;
    }

    public function getangsurantempo($id){
        $this->builder = $this->db->table('tbdataangsuranpinjaman a');
        $this->builder->select('count(*) as total');
        $this->builder->where('a.id_pinjaman',$id);
        $this->builder->where('a.tgl <=',date('Y-m-d'));
        $this->builder->where('a.status',0);
        $query = $this->builder->get();
        return $query->getRow();
    }

    public function updateangsuran($id,$data){
        return $this->db->table('tbdataangsuranpinjaman')
                 ->where('id',$id)
                 ->update($data);
    }

    public function gettagihan($kolektor=0,$limit=100,$page=0){
        if($kolektor!=0){
        	$sql="SELECT 
    b.nama,
    b.alamat,
    b.no_telp,
    a.*,
    FLOOR(a.sisa_pinjaman / a.jumlah_pokok) AS totaltempo,
    c.username,
    (SELECT COUNT(*) 
     FROM tbdataangsuranpinjaman ap 
     WHERE ap.id_pinjaman = a.id AND ap.tgl < NOW() AND status=0
    ) AS total_tunggakan,
    (SELECT tgl 
     FROM tbdataangsuranpinjaman aj 
     WHERE aj.id_pinjaman = a.id ORDER BY id DESC LIMIT 1
    ) AS tgl_jatuh_tempo,
    d.nama_simpanan
    
FROM 
    tbdatapinjaman a 
JOIN 
    tbanggota b 
ON 
    a.id_anggota = b.no_anggota 
JOIN 
    tbusers c 
ON 
    c.id = a.debt_colector 
JOIN 
	tbsetuppinjaman d 
ON 
	d.id=a.jenis_pinjaman
WHERE 
    a.sisa_pinjaman > 0  AND a.debt_colector='$kolektor'
ORDER BY 
total_tunggakan DESC";
            $query = $this->db->query($sql);
        }else{
            $sql="SELECT 
    b.nama,
    b.alamat,
    b.no_telp,
    a.*,
    FLOOR(a.sisa_pinjaman / a.jumlah_pokok) AS totaltempo,
    c.username,
    (SELECT COUNT(*) 
     FROM tbdataangsuranpinjaman ap 
     WHERE ap.id_pinjaman = a.id AND ap.tgl < NOW() AND status=0
    ) AS total_tunggakan,
    (SELECT tgl 
     FROM tbdataangsuranpinjaman aj 
     WHERE aj.id_pinjaman = a.id ORDER BY id DESC LIMIT 1
    ) AS tgl_jatuh_tempo,
    d.nama_simpanan
FROM 
    tbdatapinjaman a 
JOIN 
    tbanggota b 
ON 
    a.id_anggota = b.no_anggota 
JOIN 
    tbusers c 
ON 
    c.id = a.debt_colector 
JOIN 
	tbsetuppinjaman d 
ON 
	d.id=a.jenis_pinjaman
WHERE 
    a.sisa_pinjaman > 0
ORDER BY 
total_tunggakan DESC";
            $query = $this->db->query($sql);
        }
        return $query->getResult();
    }

    public function getDataPembayaran($start_date,$end_date,$kolektor){
        if($kolektor!=''){
            $query = $this->db->table('tbdataangsuranpinjaman a')
                    ->join('tbdatapinjaman b','b.id=a.id_pinjaman')
                    ->join('tbanggota c','c.no_anggota=b.id_anggota')
                    ->where('a.username',$kolektor)
                    ->where('a.id_transaksi <>','PELUNASANOB')
                    ->where('tgl_bayar >=',$start_date)
                    ->where('tgl_bayar <=',$end_date)
                    ->orderby('a.username','ASC')
                    ->select("a.*,c.nama,c.alamat,c.no_anggota")
                    ->get();
        }else{
            $query = $this->db->table('tbdataangsuranpinjaman a')
                    ->join('tbdatapinjaman b','b.id=a.id_pinjaman')
                    ->join('tbanggota c','c.no_anggota=b.id_anggota')
                    ->where('a.id_transaksi <>','PELUNASANOB')
                    //->where('b.debt_colector',$kolektor)
                    ->where('tgl_bayar >=',$start_date)
                    ->where('tgl_bayar <=',$end_date)
                    ->select("a.*,c.nama,c.alamat,c.no_anggota")
                    ->get();
        }
        return $query->getResult();
    }

    public function getDataPembayaranLunas($start_date,$end_date,$kolektor){
        if($kolektor!=''){
            $query = $this->db->table('tbdataangsuranpinjaman a')
                    ->join('tbdatapinjaman b','b.id=a.id_pinjaman')
                    ->join('tbanggota c','c.no_anggota=b.id_anggota')
                    ->where('a.username',$kolektor)
                    ->where('a.id_transaksi','PELUNASANOB')
                    ->where('tgl_bayar >=',$start_date)
                    ->where('tgl_bayar <=',$end_date)
                    ->orderby('a.username','ASC')
                    ->select("a.*,c.nama,c.alamat,c.no_anggota")
                    ->get();
        }else{
            $query = $this->db->table('tbdataangsuranpinjaman a')
                    ->join('tbdatapinjaman b','b.id=a.id_pinjaman')
                    ->join('tbanggota c','c.no_anggota=b.id_anggota')
                    ->where('a.id_transaksi','PELUNASANOB')
                    //->where('b.debt_colector',$kolektor)
                    ->where('tgl_bayar >=',$start_date)
                    ->where('tgl_bayar <=',$end_date)
                    ->select("a.*,c.nama,c.alamat,c.no_anggota")
                    ->get();
        }
        return $query->getResult();
    }

    public function updatejurnal($data,$id_transaksi){
        $query = $this->db->table('tbjurnal')
                ->where('id_transaksi',$id_transaksi)
                ->update($data);
        return $query;
    }

    public function allangsuran(){
        $this->builder = $this->db->table('tbdataangsuranpinjaman');
        $query = $this->builder->get();
        return $query;
    }

    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}

    function getlastpinjaman($id_anggota){
        $this->builder = $this->db->table('tbdataangsuranpinjaman a');
        $this->builder->join('tbdatapinjaman b','b.id=a.id_pinjaman');
        $this->builder->where('b.id_anggota',$id_anggota);
        $this->builder->orderby('b.id','DESC');
        $this->builder->orderby('a.id','DESC');
        //$this->builder->limit(20);
        $this->builder->select("a.*");
        $this->builder->where('b.sisa_pinjaman >',0);
        $query = $this->builder->get();
        return $query->getResult();
    }

    function getangsuranwaiting($id_anggota){
        $sql="SELECT b.* FROM tbdatapinjaman a JOIN tbdataangsuranpinjaman b ON a.id=b.id_pinjaman WHERE a.id_anggota='$id_anggota' AND a.sisa_pinjaman>0 AND b.status=0";
        $query = $this->db->query($sql);
        $results = $query->getResult();
        return $results;
    }

    function getpembayaranlast($id_pinjaman){
        $this->builder = $this->db->table('tbdataangsuranpinjaman a');
        $this->builder->where('a.id_pinjaman',$id_pinjaman);
        $this->builder->where('a.status',1);
        $this->builder->orderby('id','DESC');
        $query = $this->builder->get();
        return $query->getRow();
    }

    function getdatapembayarandetails($id_pinjaman){
        $this->builder = $this->db->table('tbdataangsuranpinjaman a');
        $this->builder->select("created_at,tgl,tgl_bayar,jumlah_pokok,jumlah_bunga,username");
        $this->builder->where('a.id_pinjaman',$id_pinjaman);
        //$this->builder->where('a.status',1);
        $this->builder->orderby('tgl_bayar','DESC');
        $query = $this->builder->get();
        return $query->getResult();
    }

    function updatedataangsuran($id_pinjaman){
        $data = array(
            'approve_status'=>1
        );
        $query = $this->db->table('tbdataangsuranpinjaman')
                ->where('id_pinjaman',$id_pinjaman)
                ->update($data);
        return $query;
    }

    function updatedataangsuranstatus($id_pinjaman,$status){
        $data = array(
            'approve_status'=>$status
        );
        $query = $this->db->table('tbdataangsuranpinjaman')
                ->where('id_pinjaman',$id_pinjaman)
                ->update($data);
        return $query;
    }

    function _insertkartuhilang($data){
        $query = $this->db->table('tbkartuhilang')
                ->insert($data);
        return $query;
    }

    function _insertselisih($data){
        $query = $this->db->table('tbselisih')
                ->insert($data);
        return $query;
    }

    function _getselisih($id_pinjaman){
        $query = $this->db->table('tbselisih')
                ->where("id_pinjaman",$id_pinjaman)
                ->where('deleted_at',null)
                ->get();
        return $query->getResult();
    }

    function _hapusselisih($id){
        $data = array(
            'deleted_at'=>date("Y-m-d H:i:s")
        );
        $query = $this->db->table('tbselisih')
        ->where("id",$id)
        ->update($data);
        return $query;
    }

	function _getdatajanji(){
    	$sql="SELECT t1.id, t1.id_anggota, t1.keterangan,t1.janji_tgl FROM tblaporankunjungan t1 INNER JOIN ( SELECT id_anggota, MAX(id) AS max_id FROM tblaporankunjungan GROUP BY id_anggota ) t2 ON t1.id_anggota = t2.id_anggota AND t1.id = t2.max_id;";
    	$query = $this->db->query($sql);
    	$results = $query->getResult();
    	
    	foreach($results as $row){
        	$data[$row->id_anggota]=$row->keterangan.' '.$row->janji_tgl;
        }
    	return $data;
    }
	
	function _restjanji($data,$k){
    	foreach($data as $key=>$row){
        	$rs[]=$key;
        }
    	if(in_array($k,$rs)){
        	return $data[$k];
        }
    }
}