<?php

namespace App\Controllers;

use App\Models\Setuppinjamanmodel;
use App\Models\Biayapinjamanmodel;
use App\Models\Akunmodel;

class Setuppinjaman extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->setuppinjamanmodel=new Setuppinjamanmodel();
        $this->biayapinjamanmodel=new Biayapinjamanmodel();
        $this->akunmodel=new Akunmodel();
        helper('form');
    }

    public function index(){
        $result = $this->setuppinjamanmodel->orderBy('id','DESC')->findAll();
        $data['results']=$result;
        //$data['anggota']=$this->anggotamodel->findAll();
        if(session('userlevel')!=0){
            return view('main/setuppinjaman',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function savesetup(){
        $rules = [
            'nama_simpanan' => 'required',
            'jangka_waktu'=> 'required',
            'bunga_pinjaman' => 'required',
            'status'=>'required',
            'jenis_pinjaman'=>'required'
        ];
        if($this->validate($rules)){
            $nama_simpanan = $this->request->getVar('nama_simpanan');
            $jangka_waktu = $this->request->getVar('jangka_waktu');
            $bunga_pinjaman = $this->request->getVar('bunga_pinjaman');
            $status = $this->request->getVar('status');
            $jenis_pinjaman = $this->request->getVar('jenis_pinjaman');
            $id = $this->request->getVar('id');
            $data = array(
                'nama_simpanan'=>$nama_simpanan,
                'jangka'=>$jangka_waktu,
                'bunga'=>$bunga_pinjaman,
                'jenis_pinjaman'=>$jenis_pinjaman,
                'status'=>$status
            );
            if(!$id){
                $save = $this->setuppinjamanmodel->insert($data);
            }else{
                $save = $this->setuppinjamanmodel->update($id,$data);
            }
            $error=0;
            $message='Data Berhasil berhasil';
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

    public function getSetup(){
        //$id = $this->request->getVar('id');
        $id = $_GET['id'];
        $data = $this->setuppinjamanmodel->where('id',$id)->first();
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

    function deletesetup(){
        
        $rules = [
            'id' => 'required'
        ];
        if($this->validate($rules)){
            $id = $this->request->getVar('id');
            $hapus = $this->setuppinjamanmodel->where('id',$id)->delete();
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

    function settingbiaya(){
        $result = $this->biayapinjamanmodel->getData()->getResult();
        //echo json_encode($result);
        $data['results']=$result;
        $result2 = $this->setuppinjamanmodel->orderBy('id','DESC')->findAll();
        $data['results2']=$result2;
        $data['akuns']=$this->akunmodel->where('level_account',2)->findAll();
        if(session('userlevel')!=0){
            return view('main/biayapinjaman',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    function savebiayapinjaman(){
        $rules = [
            'nama_biaya' => 'required',
            'jenis_biaya'=> 'required',
            'jumlah' => 'required',
            'status'=>'required',
            'akun'=>'required'
        ];
        if($this->validate($rules)){
            $nama_biaya = $this->request->getVar('nama_biaya');
            $jenis_biaya = $this->request->getVar('jenis_biaya');
            $jumlah = $this->request->getVar('jumlah');
            $status = $this->request->getVar('status');
            $jenis_pinjaman = $this->request->getVar('jenis_pinjaman');
            $id = $this->request->getVar('id');
            $akun = $this->request->getVar('akun');
            $data = array(
                'nama_biaya'=>$nama_biaya,
                'jenis_biaya'=>$jenis_biaya,
                'jumlah'=>$jumlah,
                'id_pinjaman'=>$jenis_pinjaman,
                'status'=>$status,
                'kode_akun'=>$akun
            );
            if(!$id){
                $save = $this->biayapinjamanmodel->insert($data);
            }else{
                $save = $this->biayapinjamanmodel->update($id,$data);
            }
            $error=0;
            $message='Data Berhasil berhasil';
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

    public function deletebiaya(){
        $rules = [
            'id' => 'required'
        ];
        if($this->validate($rules)){
            $id = $this->request->getVar('id');
            $hapus = $this->biayapinjamanmodel->where('id',$id)->delete();
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

    public function getsetupbiayapinjaman(){
        $rules = [
            'id' => 'required'
        ];
        if($this->validate($rules)){
            $id = $this->request->getVar('id');
            $data = $this->biayapinjamanmodel->where('id',$id)->first();
            if($data){
                $error=0;
                $message = $data;
            }else{
                $error=1;
                $message='Invalid ID';
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
}
?>