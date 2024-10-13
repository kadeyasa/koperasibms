<?php

namespace App\Controllers;

use App\Libraries\Uploadkit;
use App\Models\Tabunganmodel;

class Tabungan extends BaseController
{
	public function __construct(){
        helper('form');
        date_default_timezone_set('Asia/Singapore');
    }

    function datatabungan(){
        $model = new Tabunganmodel();

        // Base query with aliases
        $model->select("s.saldo, n.*")
            ->from("tb_saldo_tabungan as s")  // Alias for tb_saldo_tabungan
            ->join('tbnasabah_tabungan as n', 'n.id = s.id_nasabah');  // Alias for tbnasabah_tabungan

        // Check if a keyword is set and not empty
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            // Apply 'like' condition for nasabah's name if keyword is present
            $model->where_like('n.nama', $keyword);  // Use alias 'n' for tbnasabah_tabungan
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