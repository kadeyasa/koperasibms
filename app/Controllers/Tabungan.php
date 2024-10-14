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
        $model->groupBy('n.id');
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
                $model = NEW Mutasitabunganmodel();
                $transaksi_id = time();
                $datamutasi = [
                    'id_nasabah' => $insertID,
                    'uraian' => 'Saldo Awal',
                    'transaksi_id' => $transaksi_id,
                    'debet'=>$saldo,
                    'photo_buku'=>'',
                    'status'=>1
                ];

                if($model->insert($datamutasi)){
                    return redirect('data-tabungan');
                }
                //return redirect('data-tabungan');
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
            'uraian' => $uraian,
            'transaksi_id' => $transaksi_id,
            'debet'=>$debet,
            'photo_buku'=>$photo_bukti
        ];

        if($model->insert($datamutasi)){
            return redirect('data-tabungan');
        }
    }

    function tariktabungan(){
        $modelsaldo = NEW Tabunganmodel();

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

        $idnasabah = $this->request->getPost('idnasabah');
        $uraian = $this->request->getPost('uraian');
        $kredit = $this->request->getPost('kredit');
        //check saldo nasabah 
        $checksaldo = $modelsaldo->where('id_nasabah',$idnasabah)->first();
        if($checksaldo){
            if($checksaldo['saldo']<$kredit){
                session()->setFlashdata('error','Saldo Tabungan tidak cukup');
                return redirect('data-tabungan');
            }
        }else{
            session()->setFlashdata('error','Saldo Tabungan tidak cukup');
            return redirect('data-tabungan');
        }
        $transaksi_id = time();

        $model = NEW Mutasitabunganmodel();
        $datamutasi = [
            'id_nasabah' => $idnasabah,
            'uraian' => $uraian,
            'transaksi_id' => $transaksi_id,
            'kredit'=>$debet,
            'photo_buku'=>''
        ];
        
        if($model->insert($datamutasi)){
            return redirect('data-tabungan');
        }
    }

    function rekaptabungan(){
        $model = NEW Mutasitabunganmodel();
        $model->select("s.*, n.no_rekening,n.nama,n.alamat")
            ->from("tb_mutasi_tabungan as s")  // Alias for tb_saldo_tabungan
            ->join('tbnasabah_tabungan as n', 'n.id = s.id_nasabah','left');  // Alias for tbnasabah_tabungan

        // Check if a keyword is set and not empty
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            // Apply 'like' condition for nasabah's name if keyword is present
            $model->like('n.nama', $keyword);  // Use alias 'n' for tbnasabah_tabungan
        }

        if (isset($_GET['start']) && !empty($_GET['start'])) {
            $start = $_GET['start'].' 00:00:00';
            $end = $_GET['end'].' 23:59:59';
        }else{
            $start = date('Y-m-d').' 00:00:00';
            $end = date('Y-m-d').' 23:59:59';
        }

        if($model->gettotalmutasi($start,$end,0)){
            $totalmutasi_pending = $model->gettotalmutasi($start,$end,0)->totalmutasi;
        }else{
            $totalmutasi_pending = 0;
        }
        if($model->gettotalmutasi($start,$end,1)){
            $totalmutasi_sukses = $model->gettotalmutasi($start,$end,1)->totalmutasi;
        }else{
            $totalmutasi_sukses = 0;
        }

        $totalsaldoawal = $model->getsaldoawal()->totalsaldoawal;
        // Apply 'like' condition for nasabah's name if keyword is present
        $model->where('s.created_at >=', $start);  // Use alias 'n' for tbnasabah_tabungan
        $model->where('s.created_at <=', $end);

        $model->where('s.debet >', 0);

        $model->groupBy('s.id');
        $model->orderBy('s.created_at','DESC');
        // Retrieve all matching records
        $results = $model->findAll();
        $data = array(
            'results'=>$results,
            'totalsaldoawal'=>$totalsaldoawal,
            'totalmutasi_pending'=>$totalmutasi_pending,
            'totalmutasi_sukses'=>$totalmutasi_sukses	
        );

    	if(session('userlevel')!=0){
            return view('main/rekap-tabungan',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    function rekapwithdraw(){
        $model = NEW Mutasitabunganmodel();
        $model->select("s.*, n.no_rekening,n.nama,n.alamat")
            ->from("tb_mutasi_tabungan as s")  // Alias for tb_saldo_tabungan
            ->join('tbnasabah_tabungan as n', 'n.id = s.id_nasabah','left');  // Alias for tbnasabah_tabungan

        // Check if a keyword is set and not empty
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            // Apply 'like' condition for nasabah's name if keyword is present
            $model->like('n.nama', $keyword);  // Use alias 'n' for tbnasabah_tabungan
        }

        if (isset($_GET['start']) && !empty($_GET['start'])) {
            $start = $_GET['start'].' 00:00:00';
            $end = $_GET['end'].' 23:59:59';
        }else{
            $start = date('Y-m-d').' 00:00:00';
            $end = date('Y-m-d').' 23:59:59';
        }

        if($model->gettotalmutasi($start,$end,0)){
            $totalmutasi_pending = $model->gettotalmutasikredit($start,$end,0)->totalmutasi;
        }else{
            $totalmutasi_pending = 0;
        }
        if($model->gettotalmutasi($start,$end,1)){
            $totalmutasi_sukses = $model->gettotalmutasikredit($start,$end,1)->totalmutasi;
        }else{
            $totalmutasi_sukses = 0;
        }

        $totalsaldoawal = $model->getsaldoawal()->totalsaldoawal;
        // Apply 'like' condition for nasabah's name if keyword is present
        $model->where('s.created_at >=', $start);  // Use alias 'n' for tbnasabah_tabungan
        $model->where('s.created_at <=', $end);

        $model->where('s.kredit >', 0);

        $model->groupBy('s.id');
        $model->orderBy('s.created_at','DESC');
        // Retrieve all matching records
        $results = $model->findAll();
        $data = array(
            'results'=>$results,
            'totalsaldoawal'=>$totalsaldoawal,
            'totalmutasi_pending'=>$totalmutasi_pending,
            'totalmutasi_sukses'=>$totalmutasi_sukses	
        );
        
    	if(session('userlevel')!=0){
            return view('main/rekap-tabungan',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    function approvetabungan(){
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $model = NEW Mutasitabunganmodel();
            $id = $_GET['id'];
            $check = $model->where('id',$id)->first();
            if($check['status']==0){
                //check saldo
                $saldomodel = NEW Tabunganmodel();
                $check_saldo = $saldomodel->where('id_nasabah',$check['id_nasabah'])->first();
                $new_saldo = $check_saldo['saldo']+$check['debet'];
                $dataupdate = array(
                    'saldo'=>$new_saldo
                );
                if($saldomodel->update($check_saldo['id'],$dataupdate)){
                    //set status 
                    $datamutasi=array(
                        'status'=>1
                    );
                    $model->update($check['id'],$datamutasi);
                    return redirect('rekap-tabungan');
                }
            }else{
                
                session()->setFlashdata('error','Tabungan sudah di approve');
                return redirect()->back();
               
            }
        }else{
            
            session()->setFlashdata('error','Invalid ID');
            return redirect()->back();
            
        }
    }
}