<?php

namespace App\Controllers;

use App\Models\Anggotamodel;

class Anggota extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->anggotamodel=new Anggotamodel();
        helper('form');
    }

    public function index()
    {
        $result = $this->anggotamodel->findAll();
        $num_rows = $this->anggotamodel->countAll();
        $data['results']=$result;
        $urutan = $num_rows+1;
        $data['total_anggota']='BMS'.sprintf("%05s", $urutan);
        if(session('userlevel')!=0){
            return view('main/anggota',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function addAnggota(){
        $rules = [
            'nama' => 'required',
            'email'=> 'required|valid_email',
            'nik' => 'required',
            'no_telp'=>'required',
            'alamat'=>'required',
            'no_anggota' => 'required',
        ];
        if($this->validate($rules)){
            $nama = $this->request->getVar('nama');
            $email = $this->request->getVar('email');
            $nik = $this->request->getVar('nik');
            $no_telp = $this->request->getVar('no_telp');
            $alamat = $this->request->getVar('alamat');
            $no_anggota = $this->request->getVar('no_anggota');
            $jenis_kelamin=$this->request->getVar('jenis_kelamin');
            $jenis_anggota=$this->request->getVar('jenis_anggota');
            $photo=$this->request->getVar('photo');
            $koordinat=$this->request->getVar('koordinat');
            $id = $this->request->getVar('id');
            if(!$id){
                $checknik = $this->anggotamodel->where('nik',$nik)->first();
            }else{
                $checknik=0;
            }
            
            if($checknik){
                $error=1;
                $message='Gagal,NIK telah terdaftar';
            }else{
                $data = array(
                    'nama'=>$nama,
                    'email'=>$email,
                    'nik'=>$nik,
                    'no_telp'=>$no_telp,
                    'alamat'=>$alamat,
                    'no_anggota'=>$no_anggota,
                    'jenis_kelamin'=>$jenis_kelamin,
                    'jenis_anggota'=>$jenis_anggota,
                    'photo_ktp'=>$photo,
                    'koordinat'=>$koordinat
                );
                if($id){
                    $save = $this->anggotamodel->update($id,$data);
                }else{
                    $save = $this->anggotamodel->insert($data);
                }
                
                if($save){
                    $session = session(); 
                    if($id){
                        $session->setFlashdata('success','Anggota Telah di update');
                    }else{
                        $session->setFlashdata('success','Anggota Telah di tambahkan');
                    }
                    
                    $error=0;
                    $message='Pendaftaran berhasil';
                }else{
                    $error=1;
                    $message='Gagal melakukan pendaftaran';
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

    function deleteanggota(){
        
        $rules = [
            'no_anggota' => 'required'
        ];
        if($this->validate($rules)){
            $no_anggota = $this->request->getVar('no_anggota');
            $hapus = $this->anggotamodel->where('no_anggota',$no_anggota)->delete();
            if($hapus){
                $session = session(); 
                $session->setFlashdata('success','Anggota Telah di hapus');
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

    public function getdataanggota(){
        //$request = \Config\Services::request();
        //$id = $request->getVar('id');
        $id = $_GET['id'];
        $data = $this->anggotamodel->where('id',$id)->first();
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

    public function getdataanggotabykode(){
        //$no_anggota = $this->request->getVar('id');
        $no_anggota = $_GET['id'];
        $data = $this->anggotamodel->where('no_anggota',$no_anggota)->first();
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
    
}