<?php

namespace App\Controllers;
use App\Models\Titipanmodel;
use App\Models\Datapinjamanmodel;
use App\Models\Usermodel;
use App\Models\Akunmodel;
use App\Models\Jurnalmodel;
use App\Models\Tagihanmodel;

class Titipan extends BaseController
{
    function getdatatitipan(){
        $start = $_GET['start'];
        $end = $_GET['end'].' 23:59:59';
        if(isset($_GET['kolektor'])){
            $datakolektor = $_GET['kolektor'];
        }else{
            $datakolektor = '';
        }
        $model = NEW Titipanmodel();
        if($datakolektor){
            $results = $model->from('tbtitipan a')->join('tbanggota b','b.no_anggota=a.id_anggota','LEFT')->where('a.created_at >',$start)->where('a.created_at <',$end)->where('a.inputby',$datakolektor)->select("a.*,b.nama,b.alamat")->groupBy('a.id')->orderby('a.id','DESC')->findAll();
        }else{
            $results = $model->from('tbtitipan a')->join('tbanggota b','b.no_anggota=a.id_anggota','LEFT')->where('a.created_at >',$start)->where('a.created_at <',$end)->select("a.*,b.nama,b.alamat")->groupBy('a.id')->orderby('a.id','DESC')->findAll();
        }
        return $this->response->setJSON(['data' => $results]);
    }

    function datatitipan(){
        $model = NEW Akunmodel;
        $usermodel = NEW Usermodel;
        if(isset($_GET['start'])){
            $start = $_GET['start'];
            $end = $_GET['end'].' 23:59:59';
        }else{
            $start = date('Y-m-d');
            $end = date('Y-m-d 23:59:00');
        }
        
        if(isset($_GET['kolektor'])){
            $datakolektor = $_GET['kolektor'];
        }else{
            $datakolektor = '';
        }
        $result_kas_akun = $model->where('no_akun','01.01')->first();
        $data_akun_kas = $model->where('sub_account',$result_kas_akun['id'])->findAll();
        $data = array(
            'data_akun'=>$data_akun_kas,
            'kolektors'=>$usermodel->where("userlevel",2)->orwhere("userlevel",3)->findAll(),
            'datakolektor'=>$datakolektor
        );
        return view('main/datatitipan',$data);
    }

    public function savetitipan(){
        date_default_timezone_set('Asia/Singapore');
        $id_nasabah = $this->request->getVar('id_nasabah');
        $jumlah = $this->request->getVar('jumlah');
        $jenis = $this->request->getVar('jenis_kas');
        $jurnalmodel=new Jurnalmodel();
        $model = New Titipanmodel();
        if($id_nasabah){
            //check saldo titipan 
            $row = $model->where('id_anggota',$id_nasabah)->orderby('id','DESC')->first();
            if($row){
                $balance = $row['balance']+$jumlah;
            }else{
                $balance=$jumlah;
            }
            
            $data = array(
                'created_at'=>date("Y-m-d H:i:s"),
                'id_anggota'=>$id_nasabah,
                'debet'=>$jumlah,
                'balance'=>$balance,
                'status'=>0,
                'inputby'=>session('username'),
                'kode_akun'=>$jenis
            );
            if($model->insert($data)){
            	//save kunjungan
            	$modelkunjungan = NEW Tagihanmodel();
            	$data_insert = array(
            		'user_id'=>session('user_id'),
            		'id_anggota'=>$id_nasabah,
            		'tgl_followup'=>date('Y-m-d'),
            		'keterangan'=>'Titip '.$jumlah,
            		'janji_tgl'=>date('Y-m-d')
        		);
            	$modelkunjungan->insertkujungan($data_insert);
                //jurnal 
                $data_jurnal = array(
                    'kode_akun'=>$jenis,
                    'uraian'=>'Titipan '.$id_nasabah,
                    'jenis_transaksi'=>7,
                    'date'=>date('Y-m-d'),
                    'debet'=>$jumlah
                );
                $jurnalmodel->insert($data_jurnal);
                echo 'Data berhasil di simpan '.$jumlah;
            }
        }else{
            echo 'ID Nasabah harus di isi';
        }
    }

    public function getsaldouser(){
        if(isset($_GET['id_nasabah'])){
            $id_nasabah = $_GET['id_nasabah'];
            $model = New Titipanmodel();
            $row = $model->where('id_anggota',$id_nasabah)->where('status',0)->orderby('id','DESC')->first();
            if($row){
                echo $row['balance'];
            }else{
                echo '0';
            }
        }else{
            echo '0';
        }
    }

    public function savepelunasan(){
        date_default_timezone_set('Asia/Singapore');
        $id_nasabah = $this->request->getVar('id_nasabah');
        if($id_nasabah){
            $model = New Titipanmodel();
            $row = $model->where('id_anggota',$id_nasabah)->where('balance >',0)->where('status',0)->orderby('id','DESC')->first();
            $totalangsuran = $model->getJumlahAngsuran($id_nasabah);
            $jumlah_angsuran = $totalangsuran->jumlah_bunga+$totalangsuran->jumlah_pokok;
            if(!$row){
                session()->setFlashdata('error','Tidak ada data titipan');
                return redirect()->back();
            }
            if($jumlah_angsuran>$row['balance']){
                session()->setFlashdata('error','Jumlah angsuran lebih besar dari total titipan!!!'. $jumlah_angsuran);
                return redirect()->back();
            }else{
                //saldo cukup
                //cek denda 
                $titipans = $model->where('id_anggota',$id_nasabah)->where('status',0)->where('debet >',0)->findAll();
                if($titipans){
                    $totalrow = count($titipans);
                }else{
                    $totalrow=0;
                }
                
                //update data to 1
                $data_update = array(
                    'status'=>1
                );
                if($model->updateData($id_nasabah,$data_update)){
                    //update data success 
                    //cek denda
                    $valid = false;
                    if($totalrow>2){
                        //denda 5% dari jumlah angsuran 
                        $denda = 5/100*$jumlah_angsuran;
                        $balance = $row['balance']-$denda;
                        //insert denda 
                        $data = array(
                            'created_at'=>date("Y-m-d H:i:s"),
                            'id_anggota'=>$id_nasabah,
                            'kredit'=>$denda,
                            'balance'=>$balance,
                            'status'=>0,
                            'inputby'=>session('username'),
                            'kode_akun'=>'DENDA'
                        );
                        if($model->insert($data)){
                            $balance = $balance-$jumlah_angsuran;
                            $data_titipan = array(
                                'created_at'=>date("Y-m-d H:i:s"),
                                'id_anggota'=>$id_nasabah,
                                'kredit'=>$jumlah_angsuran,
                                'balance'=>$balance,
                                'status'=>0,
                                'inputby'=>session('username'),
                                'kode_akun'=>'PELUNASAN'
                            );
                            if($model->insert($data_titipan)){
                                $valid=true;
                            }
                        }
                    }else{
                        $denda =0;
                        //tanda denda
                        $balance = $row['balance']-$jumlah_angsuran;
                        $data = array(
                            'created_at'=>date("Y-m-d H:i:s"),
                            'id_anggota'=>$id_nasabah,
                            'kredit'=>$jumlah_angsuran,
                            'balance'=>$balance,
                            'status'=>0,
                            'inputby'=>session('username'),
                            'kode_akun'=>'PELUNASAN'
                        );
                        if($model->insert($data)){
                            $valid=true;
                        }
                    }
                    if($valid){
                        //update data angsuran
                        $data_angsuran = array(
                            'tgl_bayar'=>date("Y-m-d"),
                            'id_transaksi'=>'TITIPAN'.time(),
                            'bukti_pembayaran'=>'PELUNASANTITIPAN',
                            'username'=>session('username'),
                            'status'=>1
                        );
                        if($model->updateAngsuran($totalangsuran->id,$data_angsuran)){
                            $pinjamanmodel = NEW Datapinjamanmodel();
                            $valid = true;
                            //update data pinjaman 
                            $data_pinjaman = $pinjamanmodel->getdetailpinjaman('tbdatapinjaman',$totalangsuran->id_pinjaman);
                            if($data_pinjaman){
                                $sisa_pinjaman = $data_pinjaman->sisa_pinjaman - $totalangsuran->jumlah_pokok;
                                $_pinjaman_data = array(
                                    'sisa_pinjaman'=>$sisa_pinjaman
                                );
                                $pinjamanmodel->update($data_pinjaman->id,$_pinjaman_data);
                            }
                        }else{
                            $valid = false;
                        }
                    }
                    if($valid){
                        $_data = array(
                            'jumlah_angsuran'=>$jumlah_angsuran,
                            'saldo_titipan'=>$row['balance'],
                            'denda'=>$denda
                        );
                        return view('main/detailtitipan',$_data);
                    }
                }
            }
        }
    }
}