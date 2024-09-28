<?php

namespace App\Controllers;

use App\Models\Setupsimpananmodel;
use App\Models\Setuppinjamanmodel;
use App\Models\Biayapinjamanmodel;
use App\Models\Serversidemodel;
use App\Models\Akunmodel;
use App\Models\Anggotamodel;
use App\Models\Simpanananggotamodel;
use App\Models\Mutasianggotamodel;
use App\Models\Jurnalmodel;
use App\Models\Neracamodel;
use App\Models\Simpananmodel;
use App\Models\Datapinjamanmodel;
use App\Models\Pengajuanmodel;
use App\Models\Profilemodel;
use App\Models\Usermodel;
use App\Models\Saldokasharianmodel;

class Laporan extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->setupsimpananmodel=new Setupsimpananmodel();
        $this->biayapinjamanmodel=new Biayapinjamanmodel();
        $this->serversidemodel=new Serversidemodel();
        $this->akunmodel=new Akunmodel();
        $this->anggotamodel=new Anggotamodel();
        $this->simpanananggotamodel=new Simpanananggotamodel();
        $this->mutasianggotamodel=new Mutasianggotamodel();
        $this->jurnalmodel=new Jurnalmodel();
        $this->neracamodel=new Neracamodel();
        $this->simpananmodel=new Simpananmodel();
        $this->datapinjamanmodel=new Datapinjamanmodel();
        $this->pengajuannmodel=new Pengajuanmodel();
        $this->profilemodel=new Profilemodel();
        $this->setuppinjamanmodel=new Setuppinjamanmodel();
        $this->usermodel=new Usermodel();
        helper('form');
        date_default_timezone_set('Asia/Singapore');
    }

    public function laporantagihan(){
        if(isset($_GET['dari_tgl'])){
            $dari_tgl = $_GET['dari_tgl'];
            $sampai_tgl = $_GET['sampai_tgl'];
        }else{
            $dari_tgl='';
            $sampai_tgl='';
        }
    
        $_user = session('user_id');
    
        if(isset($_GET['kolektor'])){
            $_user=$_GET['kolektor'];
        }
        $data = array(
            'results'=>$this->datapinjamanmodel->gettagihan($_user),
            'kolektors'=>$this->usermodel->where('userlevel',2)->findAll(),
            'user'=>$_user,
        	'm'=>$this->datapinjamanmodel
        );
        if(session('userlevel')!=0){
            return view('main/listtagihan',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function printtagihan(){
        if(isset($_GET['dari_tgl'])){
            $dari_tgl = $_GET['dari_tgl'];
            $sampai_tgl = $_GET['sampai_tgl'];
        }else{
            $dari_tgl='';
            $sampai_tgl='';
        }
        if(session('userlevel')==5 || session('userlevel')==3){
            $_user=0;
        }else{
            $_user = session('user_id');
        }
        if(isset($_GET['kolektor'])){
            $_user=$_GET['kolektor'];
        }
        $data = array(
            'results'=>$this->datapinjamanmodel->gettagihan($_user),
        	'm'=>$this->datapinjamanmodel
        );
        if(session('userlevel')!=0){
            return view('print/printtagihan',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function lappembayaran(){
        if(isset($_GET['start'])){
            $start_date = $_GET['start'];
        }else{
            $start_date = date('Y-m-d');
        }
        if(isset($_GET['end'])){
            $end_date = $_GET['end'];
        }else{
            $end_date = date('Y-m-d');
        }
        if(isset($_GET['kolektor'])){
            $kolektor = $_GET['kolektor'];
        }else{
            $kolektor='';
        }
        $results = $this->datapinjamanmodel->getDataPembayaran($start_date,$end_date,$kolektor);
        $results_pelunasan = $this->datapinjamanmodel->getDataPembayaranLunas($start_date,$end_date,$kolektor);
        $data = array(
            'results'=>$results,
            'kolektors'=>$this->usermodel->where("userlevel",2)->orwhere("userlevel",3)->findAll(),
            'start'=>$start_date,
            'end'=>$end_date,
            'kolektor'=>$kolektor,
            'results_pelunasan'=>$results_pelunasan
        );
        if(session('userlevel')!=0){
            return view('main/lappembayaran',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function printlappembayaran(){
        if(isset($_GET['start'])){
            $start_date = $_GET['start'];
        }else{
            $start_date = date('Y-m-d');
        }
        if(isset($_GET['end'])){
            $end_date = $_GET['end'];
        }else{
            $end_date = date('Y-m-d');
        }
        if(isset($_GET['kolektor'])){
            $kolektor = $_GET['kolektor'];
        }else{
            $kolektor='';
        }
        $results = $this->datapinjamanmodel->getDataPembayaran($start_date,$end_date,$kolektor);
        $data = array(
            'results'=>$results,
            'kolektors'=>$this->usermodel->where('userlevel',2)->findAll(),
            'start'=>$start_date,
            'end'=>$end_date,
            'kolektor'=>$kolektor
        );
        if(session('userlevel')!=0){
            return view('print/printlappembayaran',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function jurnalumum(){
        if(isset($_GET['start'])){
            $start_date = $_GET['start'];
        }else{
            $start_date = date('Y-m-d');
        }
        if(isset($_GET['end'])){
            $end_date = $_GET['end'];
        }else{
            $end_date = date('Y-m-d');
        }
        if(isset($_GET['account'])){
            $a = $_GET['account'];
            if($a){
                $d = $this->akunmodel->where('id',$a)->first();
                $account = $d['no_akun'];
            }else{
                $account='';
            }
            
        }else{
            $account='';
            $a='';
        }
        $results = $this->jurnalmodel->getJurnalUmum($account,$start_date,$end_date);
        $akun = $this->akunmodel->orderby('level_account','ASC')->where('level_account',2)->findAll();
        $data = array(
            'start'=>$start_date,
            'end'=>$end_date,
            'results'=>$results,
            'data_akun'=>$akun,
            'account'=>$a
        );
        if(session('userlevel')!=0){
            return view('main/jurnalumum',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function printjurnal(){
        if(isset($_GET['start'])){
            $start_date = $_GET['start'];
        }else{
            $start_date = date('Y-m-d');
        }
        if(isset($_GET['end'])){
            $end_date = $_GET['end'];
        }else{
            $end_date = date('Y-m-d');
        }
        if(isset($_GET['account'])){
            $a = $_GET['account'];
            $d = $this->akunmodel->where('id',$a)->first();
            $account = $d['no_akun'];
        }else{
            $account='';
        }
        $results = $this->jurnalmodel->getJurnalUmum($account,$start_date,$end_date);
        $data = array(
            'start'=>$start_date,
            'end'=>$end_date,
            'results'=>$results
        );
        if(session('userlevel')!=0){
            return view('print/jurnalumum',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function updatejurnalpinjaman(){
        $results = $this->datapinjamanmodel->allangsuran()->getResult();
        echo json_encode($results);
        //$results = $this->simpanananggotamodel->findAll();
        foreach($results as $row){
            $data =array(
                'date'=>$row->tgl_bayar,
                'jenis_transaksi'=>5,
                'uraian'=>'Pembayaran Angsuran '.$row->id_transaksi
            );
            $this->datapinjamanmodel->updatejurnal($data,$row->id_transaksi);
        }
    }

    public function report_simpanan(){
        if(isset($_GET['nama_anggota'])){
            $nama_anggota = $_GET['nama_anggota'];
            $anggota = $this->anggotamodel->like('nama',$nama_anggota)->first();
            $this->simpanananggotamodel->where('tbsimpanananggota.id_anggota',$anggota['id']);
        }else{
            $nama_anggota='';
        }
        if(isset($_GET['start'])){
            $start_date = $_GET['start'];
            $this->simpanananggotamodel->where('tbsimpanananggota.tgl>=',$start_date);
        }else{
            $start_date = date('Y-m-d');
        }
        if(isset($_GET['end'])){
            $end_date = $_GET['end'];
            $this->simpanananggotamodel->where('tbsimpanananggota.tgl<=',$end_date);
        }else{
            $end_date = date('Y-m-d');
        }
        $results = $this->simpanananggotamodel
                    ->join('tbanggota','tbanggota.id=tbsimpanananggota.id_anggota')
                    ->select("tbanggota.nama,tbanggota.no_anggota,tbanggota.alamat,tbsimpanananggota.*")
                    ->orderby('tgl','ASC')
                    ->findAll();
        $data = array(
            'start'=>$start_date,
            'end'=>$end_date,
            'nama_anggota'=>$nama_anggota,
            'results'=>$results
        );
        //echo json_encode($results);
        if(session('userlevel')!=0){
            return view('main/laporansimpanan',$data);
        }else{
            return view('main/laporansimpanan',$data);
        }
    }

    function neraca(){
        $results_0 = $this->akunmodel->where('level_account',0)->orderBy('saldo_normal','ASC')->findAll();
        $data['results_0']=$results_0;
        $data['akunmodel']=$this->akunmodel;
        return view('print/neraca',$data);
    }

    function laporankas(){
        $result_kas_akun = $this->akunmodel->where('no_akun','01.01')->first();
        $data_akun_kas = $this->akunmodel->where('sub_account',$result_kas_akun['id'])->findAll();
        $model = New Saldokasharianmodel();
        $checksaldo_akhir = $model->where('created_at >=',date('Y-m-d'))
                            ->where('created_at <=',date('Y-m-d 23:59:59'))
                            ->first();
        //echo 'test';
        $data = array(
            'data_akun'=>$data_akun_kas,
            'model'=>$model,
            'kolektors'=>$this->usermodel->where("userlevel",2)->orwhere("userlevel",3)->findAll(),
            'saldo_akhir'=>$checksaldo_akhir
        );
        return view('main/laporan-kas',$data);
    }

    function printlaporankas(){
        $result_kas_akun = $this->akunmodel->where('no_akun','01.01')->first();
        $data_akun_kas = $this->akunmodel->where('sub_account',$result_kas_akun['id'])->findAll();
        $model = New Saldokasharianmodel();
        $data = array(
            'data_akun'=>$data_akun_kas,
            'model'=>$model,
            'kolektors'=>$this->usermodel->where("userlevel",2)->orwhere("userlevel",3)->findAll()
        );
        return view('print/print-kas',$data);
    }

    function simpankasharian(){
        $akuns = $this->request->getVar('akun');
        $balance = $this->request->getVar('balance');
        
        $model = New Saldokasharianmodel();
        if($akuns){
            $i=0;
            foreach($akuns as $row){
                //check akun di setiap hari
                $check = $model->where('kode_akun',$row)->where('created_at >=',date('Y-m-d'))->where('created_at <=',date('Y-m-d 23:59:59'))->first();
                //echo $balance[$i];
                if(!$check){
                    $_data[]=array(
                        'created_at'=>date('Y-m-d H:i:s'),
                        'kode_akun'=>$row,
                        'debet'=>$balance[$i],
                        'uraian'=>'Saldo Akhir'
                    );
                }
                $i++;
                
            }
            if(isset($_data)){
                
                if($model->insertDataAll($_data)){
                    echo 'save';
                }
            }
        }
    }
}
?>