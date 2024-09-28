<?php

namespace App\Controllers;

use App\Models\Absensimodel;
use App\Libraries\Uploadkit;

class Absensi extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->akunmodel=new Absensimodel();
        helper('form');
    }

    public function save(){
        $upload = NEW Uploadkit();
        $model = NEW Absensimodel();
        date_default_timezone_set('Asia/Singapore');
        $photo = $this->request->getVar('photo');
        $lokasi = $this->request->getVar('lokasi');
        
        $uppath2 = WRITEPATH . 'uploads/'.$photo;
        $photo_bukti = $upload->uploaddata($uppath2,$photo,'absensi');
        unlink($uppath2);
        
        if($photo_bukti){
            //save absensi
            $data_absensi = array(
                'created_at'=>date('Y-m-d H:i:s'),
                'tgl'=>date('Y-m-d'),
                'id_karyawan'=>session()->get('user_id'),
                'photo'=>$photo_bukti,
                'jam'=>date("H:i:s"),
                'keterangan'=>'Hadir jam '.date('H:i:s'),
                'lokasi'=>$lokasi
            );
            if($model->insert($data_absensi)){
                return redirect()->back();
            }
        }else{
            echo 'Photo anda tidak tersimpan';
        }
        
    }

    public function dataabsensi(){
        //$model = NEW Absensimodel();
        //$results = $model->from('tbabsensi a')->join('tbusers b','b.id=a.id_karyawan')->select("a.*,b.username")->findAll();
        $data['results']=array();
        return view('main/dataabsensi',$data);
    }

    public function getdataabsensi(){
        if(isset($_GET['bulan'])){
            $bulan = $_GET['bulan'];
            $tahun = $_GET['tahun'];
        }else{
            $bulan = date("m");
            $tahun = date('Y');
        }
        $start_date = $tahun.'-'.$bulan.'-01';
        $end_date = $tahun.'-'.$bulan.'-'.date('t');
        $model = NEW Absensimodel();
        $results = $model->from('tbabsensi a')->join('tbusers b','b.id=a.id_karyawan')->groupby('a.id')->select("a.*,b.username")->where('a.tgl <',$end_date)->where('a.tgl >',$start_date)->findAll();
        return $this->response->setJSON(['data' => $results]);
    }
}