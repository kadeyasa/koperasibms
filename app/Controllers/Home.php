<?php

namespace App\Controllers;
use App\Models\Statusmodel;
use App\Models\Absensimodel;

class Home extends BaseController
{
    public function index()
    {
        return view('auth/sign-in');
    }

    public function dashboard(){
        if(session()->get('userlevel')==2){
            $absensi = new Absensimodel();
            $now = date("Y-m-d");
            //check status absensi hari ini 
            $row = $absensi->where('id_karyawan',session()->get('user_id'))->orderby('id','DESC')->first();
            if($row){
                if($row['created_at']>=date('Y-m-d')){
                    
                    $data = array(
                        'absen'=>$row
                    );
                }else{
                    $data = array(
                        'absen'=>0
                    );
                }
                
            }else{
                $data = array(
                    'absen'=>0
                );
            }
            return view('main/dashboard-kolektor',$data);
        }else{
            return view('main/dashboard');
        }
        
    }

    public function lock(){
        $model = New Statusmodel();
        $status = $model->first();
        $data = array(
            'status'=>0
        );

        if($model->update($status['id'],$data)){
            echo 'System Lock';
        }
        
    }

    public function unlock(){
        $model = New Statusmodel();
        $status = $model->first();
        $data = array(
            'status'=>1
        );

        if($model->update($status['id'],$data)){
           echo 'System Unlock';
        }
        
    }
}
