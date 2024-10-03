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
use App\Libraries\Uploadkit;

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
        $kolektor = $this->request->getGet('kolektor');
        if (isset($kolektor) && !empty($kolektor)) {
            //$kolektor = $this->request->getGet('kolektor');
            $results = $model->getRestData($kolektor,$start,$end);
        }else{
           $results = $model->getRestData('all',$start,$end);
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

    public function addkunjungan()
    {
        $model = new Kunjunganwajibmodel();

        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nonasabah' => 'required',
            'kolektordata' => 'required',
            'followupdate' => 'required'
        ]);

        // Check validation
        if (!$this->validate($validation->getRules())) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $validation->getErrors()
            ]);
        }

        // Collect data
        $nonasabah = $this->request->getPost('nonasabah');
        $kolektor = $this->request->getPost('kolektordata');
        $date = $this->request->getPost('followupdate');

        $datakunjungan = [
            'id_nasabah' => $nonasabah,
            'kolektor' => $kolektor,
            'follwup_date' => $date
        ];

        if ($model->insert($datakunjungan)) {
            return redirect('kunjunganwajib');
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add kunjungan'
            ]);
        }
    }

    function tangani(){
        $model = new Kunjunganwajibmodel();
        $id = $this->request->getGet('id');
        $row = $model->getDataById($id);
        
        if($row){
            //check data pinjaman
            $pinjamanmodel = new Datapinjamanmodel();
            $rowpinjaman = $pinjamanmodel->where('id_anggota',$row->id_nasabah)->orderby('id','DESC')->first();
            $data = array(
                'row'=>$row,
                'rowpinjaman'=>$rowpinjaman
            );
            return view('main/tambah-kunjungan',$data);
        }
    }

    function savetangani(){
        $model = new Kunjunganwajibmodel();
        $upload = NEW Uploadkit();
        $bukti = $this->request->getPost('photo');

        if(!$bukti){
            session()->setFlashdata('error','Photo Bukti Belum terisi');
            return redirect()->back();
        }

        if($bukti==''){
            $photo_bukti='';
        }else{
            $uppath2 = WRITEPATH . 'uploads/'.$bukti;
            $photo_bukti = $upload->uploaddata($uppath2,$bukti,'buktipembayaran');
            unlink($uppath2);
        }
        $validation = \Config\Services::validation();
        $validation->setRules([
            'keterangan' => 'required',
            'lokasi' => 'required'
        ]);

        // Check validation
        if (!$this->validate($validation->getRules())) {
            session()->setFlashdata('error',json_encode($validation->getErrors()));
            return redirect()->back();
        }
        //data 
        $keterangan = $this->request->getPost('keterangan');
        $lokasi = $this->request->getPost('lokasi');
        $id = $this->request->getPost('id');
        $tgljanji = $this->request->getPost('start');
        $janji = $this->request->getPost('janji');
        if(isset($janji)){
            $data = array(
                'keterangan'=>$keterangan,
                'location'=>$lokasi,
                'photo'=>$photo_bukti,
                'statuskunjungan'=>0,
                'tgl_janji'=>$tgljanji
            );
        }else{
            $data = array(
                'keterangan'=>$keterangan,
                'location'=>$lokasi,
                'photo'=>$photo_bukti,
                'statuskunjungan'=>1
            );
        }
       // Update the record
        $update = $model->update($id, $data);

        if ($update) {
            session()->setFlashdata('success', 'Data updated successfully');
        } else {
            session()->setFlashdata('error', 'Failed to update data');
        }
        return redirect()->back();
    }
}