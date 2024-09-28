<?php

namespace App\Controllers;
use App\Models\Tagihanmodel;
use App\Models\Usermodel;

class Tagihan extends BaseController
{
    public function bulanan(){
        helper('form');
        $model = NEW Tagihanmodel();
        $kolektormodel = NEW Usermodel();

        $pager = service('pager');

        $page    = (int) ($this->request->getGet('page') ?? 0);
        $perPage = 50;
        $total   = $model->getcount()->total;
        $_p = $page*$perPage;

        if(session('userlevel')==5 || session('userlevel')==3){
            $_user=0;
        }else{
            $_user = session('user_id');
        }
        if(isset($_GET['kolektor'])){
            $_user=$_GET['kolektor'];
        }

        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $results = $model->getpinjamanbulanan($_p,$perPage);
        $data = array(
            'results'=>$results,
            'pager_links'=>$pager_links,
            'kolektors'=>$kolektormodel->where('userlevel',2)->findAll(),
            'user'=>$_user,
            'pager_links'=>$pager_links
        );
        return view('main/tagihan',$data);
    }

    public function printbulanan(){
        $model = NEW Tagihanmodel();
        $total   = $model->getcount()->total;
        $results = $model->getpinjamanbulanan(0,$total);
        $data = array(
            'results'=>$results
        );
        return view('print/printtagihanbulanan',$data);
    }

    public function submitreport(){
        date_default_timezone_set("Asia/Singapore");
        $data = array();
        return view('main/tambahreport',$data);
    }

    public function savekunjungan(){
        $user_id = session('user_id');
        $model = NEW Tagihanmodel();
        $kode_anggota = $this->request->getVar('kode_anggota');
        $tgl_followup = $this->request->getVar('tgl_followup');
        $keterangan = $this->request->getVar('keterangan');
        $tgl_janji = $this->request->getVar('tgl_janji');
        $data_insert = array(
            'user_id'=>$user_id,
            'id_anggota'=>$kode_anggota,
            'tgl_followup'=>$tgl_followup,
            'keterangan'=>$keterangan,
            'janji_tgl'=>$tgl_janji
        );
        //echo json_encode($data_insert);
        $session = session(); 
        if($model->insertkujungan($data_insert)){
            $session->setFlashdata('success','Data Telah di update');
            return redirect('submitreport');
        }
    }


    public function mingguan(){
        helper('form');
        $model = NEW Tagihanmodel();
        $kolektormodel = NEW Usermodel();

        $pager = service('pager');

        $page    = (int) ($this->request->getGet('page') ?? 0);
        $perPage = 50;
        $total   = $model->getcount()->total;
        $_p = $page*$perPage;

        if(session('userlevel')==5 || session('userlevel')==3){
            $_user=0;
        }else{
            $_user = session('user_id');
        }
        if(isset($_GET['kolektor'])){
            $_user=$_GET['kolektor'];
        }

        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $results = $model->getpinjamanmingguan($_p,$perPage);
        $data = array(
            'results'=>$results,
            'pager_links'=>$pager_links,
            'kolektors'=>$kolektormodel->where('userlevel',2)->findAll(),
            'user'=>$_user,
            'pager_links'=>$pager_links
        );
        return view('main/tagihanmingguan',$data);
    }

    public function printmingguan(){
        $model = NEW Tagihanmodel();
        $total   = $model->getcount()->total;
        $results = $model->getpinjamanmingguan(0,$total);
        $data = array(
            'results'=>$results
        );
        return view('print/printtagihanbulanan',$data);
    }
}