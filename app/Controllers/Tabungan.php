<?php

namespace App\Controllers;

use App\Libraries\Uploadkit;
use App\Models\Tabunganmodel;
use App\Models\Nasabahtabunganmodel;
use App\Models\Mutasitabunganmodel;

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
            $model->like('n.nama', $keyword);  // Use alias 'n' for tbnasabah_tabungan
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

    function tambahnasabah(){
        $model = new Nasabahtabunganmodel();
        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'norek' => 'required',
            'nama' => 'required',
            'saldo' => 'required',
        ]);

        // Check validation
        if (!$this->validate($validation->getRules())) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $validation->getErrors()
            ]);
        }

        // Collect data
        $norek = $this->request->getPost('norek');
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $nik = $this->request->getPost('nik');
        $no_hp = $this->request->getPost('no_hp');
        $saldo = $this->request->getPost('saldo');

        $datanasabah = [
            'nama' => $nama,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'no_rekening'=>$norek
        ];

        if ($model->insert($datanasabah)) {
            //get insert id 
            $modelsaldo = NEW Tabunganmodel();

            $insertID = $model->insertID();
            $data_saldo = array(
                'id_nasabah'=>$insertID,
                'saldo'=>$saldo
            );
            if($modelsaldo->insert($data_saldo)){
                return redirect('data-tabungan');
            }
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add kunjungan'
            ]);
        }
    }

    function tambahtabungan(){
        $upload = NEW Uploadkit();
        $validation = \Config\Services::validation();
        $validation->setRules([
            'idnasabah' => 'required',
            'photo' => 'required',
            'uraian' => 'required',
            'debet' => 'required'
        ]);


        // Check validation
        if (!$this->validate($validation->getRules())) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $validation->getErrors()
            ]);
        }

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

        $idnasabah = $this->request->getPost('idnasabah');
        $uraian = $this->request->getPost('uraian');
        $debet = $this->request->getPost('debet');

        $transaksi_id = time();

        $model = NEW Mutasitabunganmodel();
        $datamutasi = [
            'id_nasabah' => $idnasabah,
            'uraian' => $alamat,
            'transaksi_id' => $transaksi_id,
            'debet'=>$debet,
            'photo_buku'=>$photo_bukti
        ];

        if($model->insert($datamutasi)){
            return redirect('data-tabungan');
        }
    }
}