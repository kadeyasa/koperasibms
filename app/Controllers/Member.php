<?php

namespace App\Controllers;
use App\Models\Akunmodel;
use App\Models\Absensimodel;
use App\Models\Pengajuanmodel;
use App\Models\Modulemodel;
use App\Models\Usermodulemodel;
use App\Models\Usermodel;
use App\Models\Kunjunganwajibmodel;
class Member extends BaseController
{
    public function index()
    {
        date_default_timezone_set('Asia/Singapore');
        $model = new Akunmodel();
        
        if(session('userlevel')==2 || session('userlevel')==7){
            $absensi = new Absensimodel();
            $pengajuan = new Pengajuanmodel();
            $model = new Kunjunganwajibmodel();
            $now = date("Y-m-d");
            //check status absensi hari ini 
            $row = $absensi->where('id_karyawan',session()->get('user_id'))->orderby('id','DESC')->first();
            $datapengajuan = $pengajuan->where('user',session('username'))->where('status',0)->orderby('id','DESC')->findAll();
            $_date = date('Y-m-d');
            $pengajuan_results = $model->getRestData(session('username'),$_date,$_date);
            if($row){
                if($row['created_at']>=date('Y-m-d')){
                    
                    $data = array(
                        'absen'=>$row,
                        'datapengajuan'=>$datapengajuan,
                        'absensimodel'=>$absensi,
                        'pengajuan_results'=>$pengajuan_results
                    );
                }else{
                    $data = array(
                        'absen'=>0,
                        'datapengajuan'=>$datapengajuan,
                        'absensimodel'=>$absensi,
                        'pengajuan_results'=>$pengajuan_results
                    );
                }
                
            }else{
                $data = array(
                    'absen'=>0,
                    'datapengajuan'=>$datapengajuan,
                    'absensimodel'=>$absensi,
                    'pengajuan_results'=>$pengajuan_results
                );
            }
            return view('main/dashboard-kolektor',$data);
        }else{
            $data = array(
                'results'=>$model->getSubAccounts('KAS & BANK')
            );
            return view('main/dashboard',$data);
        }
    }

    public function modules(){
        if(session('userlevel')!=6){
            return redirect('dashboard');
        }
        $model = NEW Modulemodel();
        $results = $model->where('parent',0)->findAll();
        $data['results']=$results;
        $data['model']=$model;
        return view('main/modules',$data);
    }

    function tambahmodule(){
        if(session('userlevel')!=6){
            return redirect('dashboard');
        }
        $model = NEW Modulemodel();
        $name = $this->request->getVar('name');
        $parent = $this->request->getVar('parent');
        $link = $this->request->getVar('link');
        if($name!=''){
            $data = array(
                'created_at'=>date('Y-m-d H:i:s'),
                'parent'=>$parent,
                'name'=>$name,
                'link'=>$link,
                'status'=>1
            );
            if($model->insert($data)){
                echo 'Data berhasil disimpan';
            }else{
                echo 'Gagal !!!';
            }
        }else{
            echo 'Gagal !!!!';
        }
    }

    function usermodules(){
        if(session('userlevel')!=6){
            return redirect('dashboard');
        }
        $modules = NEW Modulemodel();
        $model = NEW Usermodulemodel();
        $usermodel = NEW Usermodel();
        $results = $model->findAll();
        $data['results']=$results;
        $data['modules']=$modules->orderby('parent')->where('parent',0)->findAll();
        $data['users']= $usermodel->where('userlevel <>',6)->findAll();
        $data['model']=$model;
        $data['modulemodel']=$modules;
        return view('main/user-modules',$data);
    }

    function saveusermodules(){
        if(session('userlevel')!=6){
            return redirect('dashboard');
        }
        $model = NEW Usermodulemodel();
        $modules = $this->request->getVar('modules');
        $user_id = $this->request->getVar('user_id');
        if($modules && $user_id){
            $_mod = implode(",",$modules);
            $data = array(
                'modules'=>$_mod,
                'user_id'=>$user_id
            );
            if($model->insert($data)){
                session()->setFlashdata('success','Data has been saved');
            }else{
                session()->setFlashdata('error','Data gagal disimpan');
            }
            return redirect()->back();
        }
    }

    function deleteusermodule(){
        if(session('userlevel')!=6){
            return redirect('dashboard');
        }
        $id = $this->request->getVar('id');
        $model = NEW Usermodulemodel();
        if($id){
            if($model->delete($id)){
                echo 'Data berhasil dihapus';
            }else{
                echo 'Data gagal di hapus';
            }
        }
    }

    function datauser(){
        if(session('userlevel')!=6){
            return redirect('dashboard');
        }
        $model = NEW Usermodel();
        $results = $model->findAll();
        $data['results']=$results;
        return view('main/datauser',$data);
    }

    function tambahuser(){
        if(session('userlevel')!=6){
            return redirect('dashboard');
        }
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $userlevel = $this->request->getVar('userlevel');
        $password = password_hash($password,PASSWORD_DEFAULT);
        $model = NEW Usermodel();
        //check username 
        if($username!='' && $password!='' && $userlevel!=''){
            $data_save = array(
                'username'=>$username,
                'password'=>$password,
                'userlevel'=>$userlevel,
                'status'=>1
            );
            if($model->insert($data_save)){
                echo 'Data berhasil disimpan';
            }else{
                echo 'Data gagal disimpan';
            }
        }else{
            echo 'Data harus semua diisi';
        }
       
    }

    function deleteuser(){
        if(session('userlevel')!=6){
            return redirect('dashboard');
        }
        $id = $this->request->getVar('id');
        $model = NEW Usermodel();
        if($id){
            if($model->delete($id)){
                echo 'Data berhasil dihapus';
            }else{
                echo 'Data gagal di hapus';
            }
        }
    }
}