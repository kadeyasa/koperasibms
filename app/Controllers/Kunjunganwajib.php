<?php

namespace App\Controllers;
use App\Models\Titipanmodel;
use App\Models\Datapinjamanmodel;
use App\Models\Usermodel;
use App\Models\Akunmodel;
use App\Models\Jurnalmodel;
use App\Models\Tagihanmodel;
use App\Models\Kunjunganwajibmodel;

class Kunjunganwajib extends BaseController
{
	public function __construct(){
        //$this->load->model(array('usermodel'));
    	$this->usermodel=new Usermodel();
        helper('form');
        date_default_timezone_set('Asia/Singapore');
    }

    function index(){
    
    	$data = array(
        	'kolektors'=>$this->usermodel->where('userlevel',2)->findAll(),
        	
        );
    	if(session('userlevel')!=0){
            return view('main/kunjunganwajib',$data);
        }else{
            return view('member/profile',$data);
        }
    }
}