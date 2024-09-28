<?php

namespace App\Controllers;

use App\Models\Neracamodel;
use App\Models\Akunmodel;
use App\Models\Jurnalmodel;

class Akuntansi extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->neracamodel=new Neracamodel();
        $this->akunmodel=new Akunmodel();
        $this->jurnalmodel=new Jurnalmodel();
        helper('form');
    }

    function neracaawal(){
        $tahun = $_GET['tahun'];
        if(!$tahun){
            $tahun =date('Y');
        }
        $data['results']=$this->neracamodel->getDataAwal($tahun)->getResult();
        $data['akun_debet'] = $this->akunmodel->orderBy('no_akun','ASC')->where('saldo_normal','D')->findAll();
        $data['akun_kredit'] = $this->akunmodel->orderBy('no_akun','ASC')->where('saldo_normal','K')->findAll();
        $data['tahun']=$tahun;
        if(session('userlevel')!=0){
            return view('main/neracaawal',$data);
        }else{
            return view('member/akun',$data);
        }
    }

    function saveneracaawal(){
        $rules = [
            'debet' => 'required',
            'jumlah_debet'=> 'required',
            'kredit' => 'required',
            'jumlah_kredit'=>'required'
        ];
        if($this->validate($rules)){
            $debet = $this->request->getVar('debet');
            $jumlah_debet = $this->request->getVar('jumlah_debet');
            $kredit = $this->request->getVar('kredit');
            $jumlah_kredit = $this->request->getVar('jumlah_kredit');
            $tahun = $this->request->getVar('tahun');
            $id_transaksi = date("YmdHis");
            if($jumlah_debet!=$jumlah_kredit){
                $error=1;
                $message = 'Jumlah aset tidak sama dengan jumlah kewajiban';
            }else{
                $data_jurnal = array(
                    'id_transaksi'=>$id_transaksi,
                    'date'=>'01-01-'.$tahun,
                    'kode_akun'=>$debet,
                    'uraian'=>'Junal Awal tahun '.$tahun,
                    'kredit'=>0,
                    'debet'=>$jumlah_debet
                );
        
                $data_jurnal2 = array(
                    'id_transaksi'=>$id_transaksi,
                    'date'=>'01-01-'.$tahun,
                    'kode_akun'=>$kredit,
                    'uraian'=>'Junal Awal tahun '.$tahun,
                    'kredit'=>$jumlah_kredit,
                    'debet'=>0
                );
                $this->jurnalmodel->insert($data_jurnal);
                $this->jurnalmodel->insert($data_jurnal2);
        
                $data = array(
                    'kode_akun'=>$debet,
                    'saldo_normal'=>'D',
                    'bulan'=>'01',
                    'tahun'=>$tahun,
                    'balance'=>$jumlah_debet,
                    'is_awal'=>1,
                    'id_transaksi'=>$id_transaksi
                );
                if($this->neracamodel->insert($data)){
                    $data2= array(
                        'kode_akun'=>$kredit,
                        'saldo_normal'=>'K',
                        'bulan'=>'01',
                        'tahun'=>$tahun,
                        'balance'=>$jumlah_kredit,
                        'is_awal'=>1,
                        'id_transaksi'=>$id_transaksi
                    );
                    if($this->neracamodel->insert($data2)){
                        $error=0;
                        $message = 'Data berhasil disimpan';
                    }
                }
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

    public function printneracaawal(){
        $results_0 = $this->akunmodel->where('level_account',0)->orderBy('saldo_normal','ASC')->findAll();
        $tahun = $this->request->getVar('tahun');
        $data['results_0']=$results_0;
        $data['akunmodel']=$this->akunmodel;
        $data['neracamodel']=$this->neracamodel;
        $data['tahun']=$tahun;
        return view('print/neracaawal',$data);
    }

    function deleteneracaawal(){
        
        $rules = [
            'id' => 'required'
        ];
        if($this->validate($rules)){
            $no_anggota = $this->request->getVar('id');
            $hapus = $this->neracamodel->where('id',$no_anggota)->delete();
            if($hapus){
                $session = session(); 
                $session->setFlashdata('success','Data Telah di hapus');
                $error=0;
                $message='Data berhasil dihapus';
            }else{
                $error=1;
                $message='Data tidak bisa dihapus';
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

    public function neraca(){
        $results_0 = $this->akunmodel->where('level_account',0)->orderBy('saldo_normal','ASC')->findAll();
        $data['results_0']=$results_0;
        $data['akunmodel']=$this->akunmodel;
        return view('print/akun',$data);
    }
}