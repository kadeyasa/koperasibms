<?php

namespace App\Controllers;

use App\Libraries\Uploadkit;
use App\Models\Tabunganmodel;

class Tabungan extends BaseController
{
	public function __construct(){
        //$this->load->model(array('usermodel'));
    	$this->usermodel=new Usermodel();
        helper('form');
        date_default_timezone_set('Asia/Singapore');
    }

    function datatabungan(){
        $model = new Tabunganmodel();
        
        // Base query
        $model->select("tb_saldo_tabungan.saldo, tbnasabah_tabungan.*")
              ->from("tb_saldo_tabungan")
              ->join('tbnasabah_tabungan', 'tbnasabah_tabungan.id = tb_saldo_tabungan.id_nasabah');
        
        // Check if a keyword is set and not empty
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            // Apply 'like' condition for nasabah's name if keyword is present
            $model->where_like('tbnasabah_tabungan.nama', $keyword);
        }
    
        // Retrieve all matching records
        $results = $model->findAll();
        $data = array(
            'results'=>$results	
        );
    	if(session('userlevel')!=0){
            return view('main/data-tabungan',$data);
        }else{
            return view('member/profile',$data);
        }
    }
}