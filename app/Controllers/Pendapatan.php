<?php

namespace App\Controllers;
use App\Models\Jurnalmodel;
use App\Models\Neracamodel;
use App\Models\Pendapatanmodel;

class Pendapatan extends BaseController
{
    public function __construct(){
        
        $this->jurnalmodel=new Jurnalmodel();
        $this->neracamodel=new Neracamodel();
        $this->pendapatanmodel=new Pendapatanmodel();
        helper('form');
        
    }
    
    public function index(){
        date_default_timezone_set('Asia/Singapore');
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
        
        $results = $this->pendapatanmodel->orderby('tgl','asc')->where('tgl >=',$start_date)->where('tgl <=',$end_date)->findAll();
        $data = array(
            'results'=>$results,
            'start'=>$start_date,
            'end'=>$end_date
        );
        if(session('userlevel')!=0){
            return view('main/pendapatan',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function savependapatan(){
        $rules = [
            'jenis_pendapatan' => 'required',
            'uraian'=> 'required',
            'tgl' => 'required',
            'jumlah'=>'required'
        ];
        if($this->validate($rules)){
            $jenis_pendapatan = $this->request->getVar('jenis_pendapatan');
            $uraian = $this->request->getVar('uraian');
            $tgl = $this->request->getVar('tgl');
            $jumlah = $this->request->getVar('jumlah');
            $id_transaksi = date("YmdHis");
            $data = array(
                'akun'=>$jenis_pendapatan,
                'tgl'=>$tgl,
                'uraian'=>$uraian,
                'jumlah'=>$jumlah,
                'id_transaksi'=>$id_transaksi
            );
            //save pendapatan 
            $save = $this->pendapatanmodel->insert($data);
            if($save){
                //simpan jurnal
                $akun ='01.01.110-40';
                $akun_kredit=$jenis_pendapatan;

                $data_jurnal_debet = array(
                    'id_transaksi'=>$id_transaksi,
                    'date'=>$tgl,
                    'kode_akun'=>$akun,
                    'uraian'=>$uraian,
                    'debet'=>$jumlah,
                    'kredit'=>0,
                    'jenis_transaksi'=>7//pendapatan
                );
        
                $data_jurnal_kredit = array(
                    'id_transaksi'=>$id_transaksi,
                    'date'=>$tgl,
                    'kode_akun'=>$akun_kredit,
                    'uraian'=>$uraian,
                    'debet'=>0,
                    'kredit'=>$jumlah,
                    'jenis_transaksi'=>7//pendapatan
                );
                $this->jurnalmodel->insert($data_jurnal_debet);
                $this->jurnalmodel->insert($data_jurnal_kredit);
                $error=0;
                $message='Data berhasil disimpan';
            }else{
                $error=1;
                $message='Data gagal disimpan';
            }
        }else{
            $error=1;
            $message = strip_tags($this->validator->listErrors());
        }
        $d = array(
            'error'=>$error,
            'message'=>$message
        );
        echo json_encode($d);
    }

    public function deletependapatan(){
        $id = $this->request->getVar('id_transaksi');
        if($id){
            $delete = $this->pendapatanmodel->where('id_transaksi',$id)->delete();
            if($delete){
                //delete jurnal 
                $delete_jurnal = $this->jurnalmodel->where('id_transaksi',$id)->delete();
                $error=0;
                $message='Data telah terhapus';
            }else{
                $error=1;
                $message='Data gagal disimpan';
            }
        }else{
            $error=1;
            $message = 'Invalid ID';
        }
        $d = array(
            'error'=>$error,
            'message'=>$message
        );
        echo json_encode($d);
    }

    public function printpendapatan(){
        date_default_timezone_set('Asia/Singapore');
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
        
        $results = $this->pendapatanmodel->orderby('tgl','asc')->where('tgl >=',$start_date)->where('tgl <=',$end_date)->findAll();
        $data = array(
            'results'=>$results,
            'start'=>$start_date,
            'end'=>$end_date
        );
        if(session('userlevel')!=0){
            return view('print/pendapatan',$data);
        }else{
            return view('member/profile',$data);
        }
    }
}