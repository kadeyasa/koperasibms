<?php

namespace App\Controllers;

use App\Models\Simpananmodel;
use App\Models\Saldosimpananmodel;
use App\Models\Simpananwajibmodel;
use App\Models\Saldosimpananwajibmodel;
use App\Models\Anggotamodel;
use App\Models\Jurnalmodel;
use App\Models\Neracamodel;
use App\Models\Akunmodel;
use App\Models\Profilemodel;

class Simpanan extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->simpananmodel=new Simpananmodel();
        $this->saldosimpananmodel=new Saldosimpananmodel();
        $this->simpananwajibmodel=new Simpananwajibmodel();
        $this->saldosimpananwajibmodel=new Saldosimpananwajibmodel();
        $this->anggotamodel=new Anggotamodel();
        $this->jurnalmodel=new Jurnalmodel();
        $this->neracamodel=new Neracamodel();
        $this->akunmodel=new Akunmodel();
        $this->profilemodel=new Profilemodel();
        helper('form');
    }
    
    public function simpananpokok(){
        $result = $this->simpananmodel->getSimpananPokok()->getResult();
        $data['results']=$result;
        $data['anggota']=$this->anggotamodel->findAll();
        if(session('userlevel')!=0){
            return view('main/simpananpokok',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function simpananwajib(){
        $result = $this->simpananmodel->getSimpananWajib()->getResult();
        $data['results']=$result;
        $data['anggota']=$this->anggotamodel->findAll();
        if(session('userlevel')!=0){
            return view('main/simpananwajib',$data);
        }else{
            return view('member/profile',$data);
        }
    }
    
    public function savesimpananwajib(){
        $rules = [
            'id_anggota' => 'required',
            'tgl_transaksi'=> 'required',
            'debet' => 'required'
        ];
        if($this->validate($rules)){
            $id_transaksi = date("YmdHis");
            $id_anggota = $this->request->getVar('id_anggota');
            $tgl_transaksi = $this->request->getVar('tgl_transaksi');
            $debet = $this->request->getVar('debet');
            $id = $this->request->getVar('id');
            $check = $this->saldosimpananwajibmodel->where('id_anggota',$id_anggota)->first();
            $data = array(
                'id_transaksi'=>$id_transaksi,
                'id_anggota'=>$id_anggota,
                'tgl_transaksi'=>$tgl_transaksi,
                'debit'=>$debet,
                'status'=>1
            );

            $data_jurnal = array(
                'id_transaksi'=>$id_transaksi,
                'date'=>$tgl_transaksi,
                'kode_akun'=>'02.03.310-15',
                'uraian'=>'Simpanan Wajib '.$id_anggota,
                'kredit'=>$debet,
                'debet'=>0
            );

            $data_jurnal2 = array(
                'id_transaksi'=>$id_transaksi,
                'date'=>$tgl_transaksi,
                'kode_akun'=>'01.01.110-40',
                'uraian'=>'Simpanan Wajib'.$id_anggota,
                'kredit'=>0,
                'debet'=>$debet
            );

            $t_transaksi = explode("-",$tgl_transaksi);
            $bulan = $t_transaksi[1];
            $tahun = $t_transaksi[0];

            $data_neraca = array(
                'id_transaksi'=>$id_transaksi,
                'kode_akun'=>'01.01.110-40',
                'saldo_normal'=>'D',
                'bulan'=>$bulan,
                'tahun'=>$tahun,
                'balance'=>$debet,
                'is_awal'=>0
            );

            $data_neraca2 = array(
                'id_transaksi'=>$id_transaksi,
                'kode_akun'=>'02.03.310-15',
                'saldo_normal'=>'K',
                'bulan'=>$bulan,
                'tahun'=>$tahun,
                'balance'=>$debet,
                'is_awal'=>0
            );
            if($id){
                $save = $this->simpananwajibmodel->update($id,$data);
            }else{
                //save jurnal
                $this->jurnalmodel->insert($data_jurnal);
                $this->jurnalmodel->insert($data_jurnal2);

                //save neraca
                $this->neracamodel->insert($data_neraca);
                $this->neracamodel->insert($data_neraca2);
                $save = $this->simpananwajibmodel->insert($data);
            }
            
            if($save){
                if(!$check){
                    $data_simpanan = array(
                        'total_saldo'=>$debet,
                        'id_anggota'=>$id_anggota
                    );
                    $this->saldosimpananwajibmodel->insert($data_simpanan);
                }else{
                    $totalsaldo = $check['total_saldo']+$debet;
                    $data_simpanan = array(
                        'total_saldo'=>$totalsaldo
                    );
                    $this->saldosimpananwajibmodel->update($check['id'],$data_simpanan);
                }
                $session = session(); 
                if($id){
                    $session->setFlashdata('success','Data Telah di update');
                }else{
                    $session->setFlashdata('success','Data Telah di tambahkan');
                }
                
                $error=0;
                $message='Data Berhasil berhasil';
            }else{
                $error=1;
                $message='Gagal melakukan diupdate';
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

    public function savesimpananpokok(){
        $rules = [
            'id_anggota' => 'required',
            'tgl_transaksi'=> 'required',
            'debet' => 'required'
        ];
        if($this->validate($rules)){
            $id_transaksi = date("YmdHis");
            $id_anggota = $this->request->getVar('id_anggota');
            $tgl_transaksi = $this->request->getVar('tgl_transaksi');
            $debet = $this->request->getVar('debet');
            $id = $this->request->getVar('id');
            $check = $this->saldosimpananmodel->where('id_anggota',$id_anggota)->first();
            $data = array(
                'id_transaksi'=>$id_transaksi,
                'id_anggota'=>$id_anggota,
                'tgl_transaksi'=>$tgl_transaksi,
                'debit'=>$debet,
                'status'=>1
            );

            $data_jurnal = array(
                'id_transaksi'=>$id_transaksi,
                'date'=>$tgl_transaksi,
                'kode_akun'=>'02.03.310-10',
                'uraian'=>'Simpanan Pokok '.$id_anggota,
                'kredit'=>$debet,
                'debet'=>0
            );

            $data_jurnal2 = array(
                'id_transaksi'=>$id_transaksi,
                'date'=>$tgl_transaksi,
                'kode_akun'=>'01.01.110-40',
                'uraian'=>'Simpanan Pokok '.$id_anggota,
                'kredit'=>0,
                'debet'=>$debet
            );

            $t_transaksi = explode("-",$tgl_transaksi);
            $bulan = $t_transaksi[1];
            $tahun = $t_transaksi[0];

            $data_neraca = array(
                'id_transaksi'=>$id_transaksi,
                'kode_akun'=>'01.01.110-40',
                'saldo_normal'=>'D',
                'bulan'=>$bulan,
                'tahun'=>$tahun,
                'balance'=>$debet,
                'is_awal'=>0
            );

            $data_neraca2 = array(
                'id_transaksi'=>$id_transaksi,
                'kode_akun'=>'02.03.310-10',
                'saldo_normal'=>'K',
                'bulan'=>$bulan,
                'tahun'=>$tahun,
                'balance'=>$debet,
                'is_awal'=>0
            );
            if($id){
                $save = $this->simpananmodel->update($id,$data);
            }else{
                //save jurnal
                $this->jurnalmodel->insert($data_jurnal);
                $this->jurnalmodel->insert($data_jurnal2);

                //save neraca
                $this->neracamodel->insert($data_neraca);
                $this->neracamodel->insert($data_neraca2);
                $save = $this->simpananmodel->insert($data);
            }
            
            if($save){
                if(!$check){
                    $data_simpanan = array(
                        'total_saldo'=>$debet,
                        'id_anggota'=>$id_anggota
                    );
                    $this->saldosimpananmodel->insert($data_simpanan);
                }else{
                    $totalsaldo = $check['total_saldo']+$debet;
                    $data_simpanan = array(
                        'total_saldo'=>$totalsaldo
                    );
                    $this->saldosimpananmodel->update($check['id'],$data_simpanan);
                }
                $session = session(); 
                if($id){
                    $session->setFlashdata('success','Data Telah di update');
                }else{
                    $session->setFlashdata('success','Data Telah di tambahkan');
                }
                
                $error=0;
                $message='Data Berhasil berhasil';
            }else{
                $error=1;
                $message='Gagal melakukan diupdate';
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

    public function tagihansimpananwajib(){
        $tahun = $this->request->getVar('tahun');
        $bulan = $this->request->getVar('bulan');
        if(!$tahun){
            $tahun=date('Y');
        }
        if(!$bulan){
            $bulan =date('m');
        }
        $start_date =$tahun.'-'.$bulan.'-01';
        $date = strtotime($start_date);
        $end_date =date("Y-m-t", $date);
        $results = $this->simpananmodel->getTagihanWajib($start_date,$end_date)->getResult();
        
        $data['results']=$results;
        $data['akunmodel']=$this->akunmodel;
        $data['neracamodel']=$this->neracamodel;
        $data['tahun']=$tahun;
        $data['bulan']=$bulan;
        if(session('userlevel')!=0){
            return view('main/tagihansimpananwajib',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function deletesimpananpokok(){
        $rules = [
            'id_transaksi' => 'required'
        ];
        if($this->validate($rules)){
            $id_transaksi = $this->request->getVar('id_transaksi');
            //cek simpanan 
            $transaksi = $this->simpananmodel->where('id_transaksi',$id_transaksi)->first();
            if($transaksi){
                $saldosimpanan = $this->saldosimpananmodel->where('id_anggota',$transaksi['id_anggota'])->first();
                if($saldosimpanan){
                    $total_saldo = $saldosimpanan['total_saldo']-$transaksi['debit'];
                    //update 
                    $datasaldo=array(
                        'total_saldo'=>$total_saldo
                    );
                    $update_saldo = $this->saldosimpananmodel->update($saldosimpanan['id'],$datasaldo);
                    $hapus_simpanan = $this->simpananmodel->where('id_transaksi',$id_transaksi)->delete();
                    $hapus_jurnal = $this->jurnalmodel->where('id_transaksi',$id_transaksi)->delete();
                    $hapus_neraca = $this->neracamodel->where('id_transaksi',$id_transaksi)->delete();
                }
            }
            $error=0;
            $message = 'Sukses';
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

    public function printtagihanwajib(){
        helper(['bulan']);
        $tahun = $this->request->getVar('tahun');
        $bulan = $this->request->getVar('bulan');
        if(!$tahun){
            $tahun=date('Y');
        }
        if(!$bulan){
            $bulan =date('m');
        }
        $start_date =$tahun.'-'.$bulan.'-01';
        $end_date =$tahun.'-'.$bulan.'-31';
        $results = $this->simpananmodel->getTagihanWajib($start_date,$end_date)->getResult();
        $info = $this->profilemodel->first();
        $data['results']=$results;
        $data['akunmodel']=$this->akunmodel;
        $data['neracamodel']=$this->neracamodel;
        $data['info'] = $info;
        $data['tahun']=$tahun;
        $data['bulan']=$bulan;
        if(session('userlevel')!=0){
            return view('print/tagihansimpananwajib',$data);
        }else{
            return view('member/profile',$data);
        }
    }
}