<?php

namespace App\Controllers;

use App\Models\Setupsimpananmodel;
use App\Models\Saldosimpananmodel;
use App\Models\Simpananwajibmodel;
use App\Models\Saldosimpananwajibmodel;
use App\Models\Anggotamodel;
use App\Models\Jurnalmodel;
use App\Models\Neracamodel;
use App\Models\Akunmodel;
use App\Models\Profilemodel;

class Setupsimpanan extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->setupsimpananmodel=new Setupsimpananmodel();
        helper('form');
    }

    public function index(){
        $result = $this->setupsimpananmodel->orderBy('id','DESC')->findAll();
        $data['results']=$result;
        //$data['anggota']=$this->anggotamodel->findAll();
        if(session('userlevel')!=0){
            return view('main/setupsimpanan',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function savesetupsimpanan(){
        $rules = [
            'nama_simpanan' => 'required',
            'jangka_waktu'=> 'required',
            'bunga_pinjaman' => 'required',
            'status'=>'required'
        ];
        if($this->validate($rules)){
            $nama_simpanan = $this->request->getVar('nama_simpanan');
            $jangka_waktu = $this->request->getVar('jangka_waktu');
            $bunga_pinjaman = $this->request->getVar('bunga_pinjaman');
            $status = $this->request->getVar('status');
            $id = $this->request->getVar('id');
            $data = array(
                'nama_simpanan'=>$nama_simpanan,
                'jangka'=>$jangka_waktu,
                'bunga'=>$bunga_pinjaman,
                'status'=>$status
            );
            if(!$id){
                $save = $this->setupsimpananmodel->insert($data);
            }else{
                $save = $this->setupsimpananmodel->update($id,$data);
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

    public function getSetupSimpanan(){
        //$id = $this->request->getVar('id');
        $id = $_GET['id'];
        $data = $this->setupsimpananmodel->where('id',$id)->first();
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

    function deletesetupsimpanan(){
        
        $rules = [
            'id' => 'required'
        ];
        if($this->validate($rules)){
            $id = $this->request->getVar('id');
            $hapus = $this->setupsimpananmodel->where('id',$id)->delete();
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
}
?>