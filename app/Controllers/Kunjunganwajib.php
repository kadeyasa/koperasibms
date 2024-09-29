<?php

namespace App\Controllers;
use App\Models\Titipanmodel;
use App\Models\Datapinjamanmodel;
use App\Models\Usermodel;
use App\Models\Akunmodel;
use App\Models\Jurnalmodel;
use App\Models\Tagihanmodel;
use App\Models\Kunjunganwajibmodel;
use App\Models\Anggotamodel;

class Kunjunganwajib extends BaseController
{
	public function __construct(){
        //$this->load->model(array('usermodel'));
    	$this->usermodel=new Usermodel();
        helper('form');
        date_default_timezone_set('Asia/Singapore');
    }

    function index(){
        $model = new Kunjunganwajibmodel();
        if(isset($_GET['start'])){
            $start = $_GET['start'];
        }else{
            $start = date('Y-m-d 00:00:00');
        }
        if(isset($_GET['end'])){
            $end = $_GET['end'];
        }else{
            $end = date('Y-m-d 23:59:59');
        }
        if(isset($_GET['kolektor'])){
            $kolektor = $_GET['kolektor'];
            $results = $model->from('tbkunjunganwajib a')
                        ->join('tbanggota b','b.id=a.id_nasabah')
                        ->where('a.kolektor',$kolektor)->where('a.created_at >=',$start)->where('a.created_at <=',$start)->findAll();
        }else{
            $results = $model->from('tbkunjunganwajib a')
                        ->join('tbanggota b','b.id=a.id_nasabah')
                        ->where('a.created_at >=',$start)
                        ->where('a.created_at <=',$start)->findAll();
        }
    	$data = array(
        	'kolektors'=>$this->usermodel->where('userlevel',2)->findAll(),
            'results'=>$results	
        );
    	if(session('userlevel')!=0){
            return view('main/kunjunganwajib',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    function carianggota(){
        $model = new Anggotamodel();
        $keyword = $this->request->getGet('search');

        if (isset($keyword) && !empty($keyword)) {
            $result = $model->where('no_anggota', $keyword)->first();
            return $this->response->setJSON($result);
        }
        return $this->response->setJSON([]);
    }
}