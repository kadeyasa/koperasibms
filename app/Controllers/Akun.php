<?php

namespace App\Controllers;

use App\Models\Akunmodel;

class Akun extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->akunmodel=new Akunmodel();
        helper('form');
    }

    public function dataakun()
    {
        $data['results']=$this->akunmodel->orderBy('level_account','ASC')->findAll();
        if(session('userlevel')!=0){
            return view('main/akun',$data);
        }else{
            return view('member/akun',$data);
        }
    }

    public function simpanakun(){
        $rules = [
            'no_akun' => 'required',
            'saldo_normal'=> 'required',
            'level_account' => 'required',
            'account_name'=>'required'
        ];
        if($this->validate($rules)){
            $no_akun = $this->request->getVar('no_akun');
            $saldo_normal = $this->request->getVar('saldo_normal');
            $level_account = $this->request->getVar('level_account');
            $account_name = $this->request->getVar('account_name');
            $sub_account = $this->request->getVar('sub_account');
            $id = $this->request->getVar('id_data');
            $check = $this->akunmodel->where('no_akun',$no_akun)->first();
            if($check && !$id){
                $error=1;
                $message = 'No Akun sudah terdaftar';
            }else{
                $data = array(
                    'no_akun'=>$no_akun,
                    'saldo_normal'=>$saldo_normal,
                    'level_account'=>$level_account,
                    'account_name'=>$account_name,
                    'sub_account'=>$sub_account
                );
                if(!$id){
                    $save = $this->akunmodel->insert($data);
                }else{
                    $save = $this->akunmodel->update($id,$data);
                }
                if($save){
                    if($id){
                        session()->setFlashdata('success','Data Telah di update');
                    }else{
                        session()->setFlashdata('success','Data Telah di tambahkan');
                    }
                    
                    $error=0;
                    $message='Data berhasil disimpan';
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

    function deleteakun(){
        
        $rules = [
            'id' => 'required'
        ];
        if($this->validate($rules)){
            $no_anggota = $this->request->getVar('id');
            $hapus = $this->akunmodel->where('id',$no_anggota)->delete();
            if($hapus){
                $session = session(); 
                $session->setFlashdata('success','Akun Telah di hapus');
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

    public function getdataakun(){
        $id = $this->request->getVar('id');
        $data = $this->akunmodel->where('id',$id)->first();
        if($data){
            $error=0;
            $message = $data;
        }else{
            $error=1;
            $message='Invalid ID';
        }
        $d = array(
            'error'=>$error,
            'message'=>$message
        );
        echo json_encode($d);
    }

    public function printakun(){
        $results_0 = $this->akunmodel->where('level_account',0)->orderBy('saldo_normal','ASC')->findAll();
        $data['results_0']=$results_0;
        $data['akunmodel']=$this->akunmodel;
        return view('print/akun',$data);
    }
}