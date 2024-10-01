<?php

namespace App\Controllers;

use App\Models\Setupsimpananmodel;
use App\Models\Setuppinjamanmodel;
use App\Models\Biayapinjamanmodel;
use App\Models\Serversidemodel;
use App\Models\Akunmodel;
use App\Models\Anggotamodel;
use App\Models\Simpanananggotamodel;
use App\Models\Mutasianggotamodel;
use App\Models\Jurnalmodel;
use App\Models\Neracamodel;
use App\Models\Simpananmodel;
use App\Models\Datapinjamanmodel;
use App\Models\Pengajuanmodel;
use App\Models\Profilemodel;
use App\Models\Usermodel;
use App\Models\Pendapatanmodel;
use App\Models\Pinjamanviewmodel;
use App\Models\Statusmodel;
use App\Libraries\Uploadkit;
use App\Models\Kunjunganwajibmodel;
class Datapinjaman extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->setupsimpananmodel=new Setupsimpananmodel();
        $this->biayapinjamanmodel=new Biayapinjamanmodel();
        $this->serversidemodel=new Serversidemodel();
        $this->akunmodel=new Akunmodel();
        $this->anggotamodel=new Anggotamodel();
        $this->simpanananggotamodel=new Simpanananggotamodel();
        $this->mutasianggotamodel=new Mutasianggotamodel();
        $this->jurnalmodel=new Jurnalmodel();
        $this->neracamodel=new Neracamodel();
        $this->simpananmodel=new Simpananmodel();
        $this->datapinjamanmodel=new Datapinjamanmodel();
        $this->pengajuannmodel=new Pengajuanmodel();
        $this->profilemodel=new Profilemodel();
        $this->setuppinjamanmodel=new Setuppinjamanmodel();
        $this->usermodel=new Usermodel();
        $this->pendapatanmodel=new Pendapatanmodel();
        $this->pinjamanviewmodel=new Pinjamanviewmodel();
        $model = new Statusmodel();
        $status = $model->first();
        //echo json_encode($status);
        if($model->where('status',0)->first()){
            return redirect()->to('dashboard'); 
        }
        helper('form');
        date_default_timezone_set('Asia/Singapore');
    }
    
    public function simpanpinjaman(){
        $id = $this->request->getVar('id');
        $detail = $this->pengajuannmodel->getdatapengajuandetail($id);
        //echo json_encode($detail);
        
        
        if($detail){
            if($detail->status==0){
                $jenis_kas = $this->request->getVar('jenis_kas');
                $tgl = $this->request->getVar('tgl');
                if($jenis_kas){
                    //cek saldo kas 
                    $cek_kas = $this->pengajuannmodel->ceksaldoakun($jenis_kas);
                    if($cek_kas){
                        if($cek_kas->balance>=$detail->jumlah){
                            $id_transaksi = date("YmdHis");
                            if($detail->type=='1'){
                                //harian
                                $jatuh_tempo    = date('Y-m-d', strtotime('+'.$detail->jangka.' days', strtotime($tgl)));
                                //$uraian='Pinjaman Harian';
                            }
                            if($detail->type=='2'){
                                $jangka_waktu = $detail->jangka*7;
                                //mingguan
                                $jatuh_tempo    = date('Y-m-d', strtotime('+'.$jangka_waktu.' days', strtotime($tgl)));
                            }
                            if($detail->type=='3'){
                                //bulanan
                                $jangka_waktu = $detail->jangka*30;
                                $jatuh_tempo    = date('Y-m-d', strtotime('+'.$jangka_waktu.' days', strtotime($tgl)));
                            }
                            if($detail->type=='4'){
                                //kondisional
                                $jangka_waktu = $detail->jangka*30;
                                $jatuh_tempo    = date('Y-m-d', strtotime('+'.$jangka_waktu.' days', strtotime($tgl)));
                            }
                            //balance masih
                            $no_rek = $this->pengajuannmodel->getdatarek()->rek_pinjaman;
                            $no_rek = $no_rek+1;
                            $no_rek = '00-00-'.sprintf("%09s", $no_rek);
                            $totalbunga = ($detail->bunga*$detail->jangka)/100;
                            $totalbunga_idr = $totalbunga * $detail->jumlah;
                            $pokok = $detail->jumlah/$detail->jangka;
                            $total_angsuran = ($totalbunga_idr+$detail->jumlah)/$detail->jangka;
                            $bunga_angsuran = $totalbunga_idr/$detail->jangka;
                            $kolektor = $this->request->getVar('kolektor');
                            $lastpinjaman = $this->datapinjamanmodel->getangsuranwaiting($detail->id_anggota);
                            $data_pinjaman = array(
                                'id_anggota'=>$detail->id_anggota,
                                'akun'=>$jenis_kas,
                                'rek_pinjaman'=>$no_rek,
                                'jenis_pinjaman'=>$detail->jenis_pinjaman,
                                'lama_pinjaman'=>$detail->jangka,
                                'jumlah_pokok'=>$pokok,
                                'jumlah_bunga'=>$bunga_angsuran,
                                'tgl'=>$tgl,
                                'tgl_jatuh_tempo'=>$jatuh_tempo,
                                'jumlah'=>$detail->jumlah,
                                'sisa_pinjaman'=>$detail->jumlah,
                                'id_transaksi'=>$id_transaksi,
                                'debt_colector'=>$kolektor
                            );
                            $save = $this->datapinjamanmodel->insert($data_pinjaman);
                            $lastid = $this->datapinjamanmodel->getInsertID();
                            if($save){
                                //update pengajuan 
                                $data_update = array(
                                    'status'=>1
                                );
                                $this->pengajuannmodel->updatedata($id,$data_update);
                                $this->savejurnal($jenis_kas,$detail,$id_transaksi,$tgl);
                                $this->createTagihan($lastid,$detail,$tgl);
                                //setbiaya
                                $this->savebiayapendapatan($detail->id_anggota,$detail->jenis_pinjaman,$id_transaksi,$tgl,$jenis_kas,$detail->jumlah);
                                
                                if($lastpinjaman){
                                    foreach($lastpinjaman as $sisaangsuran){
                                        $id_pinjaman_sebelumnya = $sisaangsuran->id_pinjaman;
                                        $subtotal = $sisaangsuran->jumlah_pokok+$sisaangsuran->jumlah_bunga;
                                        //save to jurnal 
                                        $data_jurnal = array(
                                            'id_transaksi'=>$id_transaksi,
                                            'date'=>$tgl,
                                            'kode_akun'=>$jenis_kas,
                                            'uraian'=>'Pelunasan Pinjaman Dari OB '.$detail->id_anggota,
                                            'kredit'=>0,
                                            'debet'=>$subtotal
                                        );
                                        $this->jurnalmodel->insert($data_jurnal);
                                        //update angsuran 
                                        $data_angsuran = array(
                                            'status'=>1,
                                            'id_transaksi'=>'PELUNASANOB',
                                            'tgl_bayar'=>date('Y-m-d'),
                                            'username'=>$detail->user,
                                            'bukti_pembayaran'=>'PELUNASANOB',
                                            'approve_status'=>1
                                        );
                                        $this->datapinjamanmodel->updateangsuran($sisaangsuran->id,$data_angsuran);
                                    }
                                    if($id_pinjaman_sebelumnya){
                                        //update sisa pinjaman
                                        $_pinjaman_data = array(
                                            'sisa_pinjaman'=>0
                                        );
                                        $this->datapinjamanmodel->update($id_pinjaman_sebelumnya,$_pinjaman_data);
                                    }
                                }
                                
                                session()->setFlashdata('success','Pinjaman disetujui');
                                return redirect('datapengajuan');
                            }
                        }else{
                            session()->setFlashdata('error','Saldo tidak cukup');
                            return redirect('datapengajuan');
                        }
                    }
                }else{
                    session()->setFlashdata('error','Kode akun salah');
                    return redirect('datapengajuan');
                }
            }else{
                session()->setFlashdata('error','status pinjaman tidak pending');
                return redirect('datapengajuan');
            }
        }else{
            session()->setFlashdata('error','data tidak ada ');
            return redirect('datapengajuan');
        }
    }

    protected function savebiayapendapatan($uraian,$jenis_pinjaman,$id_transaksi,$tgl,$jenis_kas,$jumlah_pinjaman){
        $results_biaya = $this->biayapinjamanmodel->where('id_pinjaman',$jenis_pinjaman)->findAll();
        foreach($results_biaya as $row){
            if($row['jenis_biaya']==1){
                $row['jumlah']=$row['jumlah']/100*$jumlah_pinjaman;
            }
            $data = array(
                'uraian'=>$row['nama_biaya'].' '.$uraian,
                'id_transaksi'=>$id_transaksi,
                'tgl'=>$tgl,
                'jumlah'=>$row['jumlah'],
                'akun'=>$row['kode_akun']
            );
            //save pendapatan
            $this->pendapatanmodel->insert($data);
            //jurnal 
            $data_jurnal = array(
                'id_transaksi'=>$id_transaksi,
                'date'=>$tgl,
                'kode_akun'=>$jenis_kas,
                'uraian'=>$row['nama_biaya'].' '.$uraian,
                'kredit'=>0,
                'debet'=>$row['jumlah']
            );
    
            $data_jurnal2 = array(
                'id_transaksi'=>$id_transaksi,
                'date'=>$tgl,
                'kode_akun'=>$row['kode_akun'],
                'uraian'=>$row['nama_biaya'].' '.$uraian,
                'kredit'=>$row['jumlah'],
                'debet'=>0
            );
            $this->jurnalmodel->insert($data_jurnal);
            $this->jurnalmodel->insert($data_jurnal2);
        }
    }
    protected function savejurnal($kode_akun,$detail,$id_transaksi,$tgl){
        //$tgl = date('Y-m-d');
        if($detail->type=='1'){
            //harian
            $akun_debet = '01.02.130-15';
            $uraian='Pinjaman Harian';
        }
        if($detail->type=='2'){
            //mingguan
            $akun_debet = '01.02.130-20';
            $uraian='Pinjaman Mingguan';
        }
        if($detail->type=='3'){
            //bulanan
            $akun_debet = '01.02.130-25';
            $uraian='Pinjaman Bulanan';
        }
        if($detail->type=='4'){
            //kondisional
            $akun_debet = '01.02.130-30';
            $uraian='Pinjaman Kondisional';
        }
        $data_jurnal = array(
            'id_transaksi'=>$id_transaksi,
            'date'=>$tgl,
            'kode_akun'=>$akun_debet,
            'uraian'=>$uraian,
            'kredit'=>0,
            'debet'=>$detail->jumlah
        );

        $data_jurnal2 = array(
            'id_transaksi'=>$id_transaksi,
            'date'=>$tgl,
            'kode_akun'=>$kode_akun,
            'uraian'=>$uraian,
            'kredit'=>$detail->jumlah,
            'debet'=>0
        );
        $this->jurnalmodel->insert($data_jurnal);
        $this->jurnalmodel->insert($data_jurnal2);

        //neraca 
        $t_transaksi = explode("-",$tgl);
        $bulan = $t_transaksi[1];
        $tahun = $t_transaksi[0];

        $data_neraca = array(
            'id_transaksi'=>$id_transaksi,
            'kode_akun'=>$akun_debet,
            'saldo_normal'=>'D',
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'balance'=>$detail->jumlah,
            'is_awal'=>0
        );

        $data_neraca2 = array(
            'id_transaksi'=>$id_transaksi,
            'kode_akun'=>$kode_akun,
            'saldo_normal'=>'K',
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'balance'=>$detail->jumlah,
            'is_awal'=>0
        );

        $this->neracamodel->insert($data_neraca);
        $this->neracamodel->insert($data_neraca2);
    }

    protected function createTagihan($lastid,$detail,$tgl){
        $datamutasipinjaman = array(
            'id_pinjaman'=>$lastid,
            'tgl'=>$tgl,
            'debet'=>$detail->jumlah,
            'kredit'=>0,
            'balance'=>$detail->jumlah,
            'status'=>1
        );
        $this->datapinjamanmodel->cratemutasi($datamutasipinjaman);
        if($detail->type=='1'){
            //harian
            $tambah=1;
        }
        if($detail->type=='2'){
            //mingguan
            $tambah=7;
        }
        if($detail->type=='3'){
            //bulanan
            $tambah=30;
        }
        if($detail->type=='4'){
            $tambah=30;
        }
        //$tgl = date('Y-m-d');
        $totalbunga = ($detail->bunga*$detail->jangka)/100;
        $totalbunga_idr = $totalbunga * $detail->jumlah;
        $pokok = $detail->jumlah/$detail->jangka;
        $total_angsuran = ($totalbunga_idr+$detail->jumlah)/$detail->jangka;
        $bunga_angsuran = $totalbunga_idr/$detail->jangka;
        $tambah2=0;
        for($i=2;$i<=($detail->jangka+1);$i++){
            if($tambah2==0){
                $tambah2=$tambah;
            }
            $tgl2    = date('Y-m-d', strtotime('+'.$tambah2.' days', strtotime($tgl)));
            $data_angsuran = array(
                'id_pinjaman'=>$lastid,
                'tgl'=>$tgl2,
                'jumlah_bunga'=>$bunga_angsuran,
                'jumlah_pokok'=>$pokok,
                'status'=>0
            );
            $this->datapinjamanmodel->crateangsuran($data_angsuran);
            $tambah2 = $tambah*$i;
        }
    }

    public function datapencairan(){
        if(session('userlevel')!=4 && session('userlevel')!=6 && session('userlevel')!=3){
            return redirect('pencairanpinjaman');
        }
        $where = ['tbdatapinjaman.status =' => 0];
        $column_order = array('tbdatapinjaman.id','tbdatapinjaman.rek_pinjaman','tbdatapinjaman.jumlah_pokok','tbdatapinjaman.jumlah_bunga');
        $column_search = array('tbdatapinjaman.id','tbdatapinjaman.rek_pinjaman','tbdatapinjaman.jumlah_pokok','tbdatapinjaman.jumlah_bunga');
        $order = array('tbdatapinjaman.tgl' => 'asc');
        $list = $this->datapinjamanmodel->get_datatables('tbdatapinjaman', $column_order, $column_search, $order, $where);
        $data = array(
            'list'=>$list,
            'no'=>0
        );
        if(session('userlevel')!=0){
            return view('main/datapinjaman',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function getdatapencairan(){
        $request = \Config\Services::request();
        //$list_data = $this->serverside_model;
        $where = ['tbdatapinjaman.status =' => 0];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('tbdatapinjaman.id','tbdatapinjaman.rek_pinjaman','tbdatapinjaman.jumlah_pokok','tbdatapinjaman.jumlah_bunga');
        $column_search = array('tbdatapinjaman.id','tbdatapinjaman.rek_pinjaman','tbdatapinjaman.jumlah_pokok','tbdatapinjaman.jumlah_bunga');
        $order = array('tbdatapinjaman.tgl' => 'asc');
        $list = $this->datapinjamanmodel->get_datatables('tbdatapinjaman', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            if($lists->status==1){
                $status='Sukses';
            }else if($lists->status==-1){
                $status='Cancel';
            }else if($lists->status==0){
                $status='Pending';
            }
            $row[] = $no;
            //$r= "'".$lists->no_anggota."'";
            $row[] = $lists->tgl;
            $row[] = $lists->rek_pinjaman;
            $row[] = $lists->no_anggota;
            $row[] = $lists->nama;
            $row[] = $lists->nama_simpanan;
            //$row[] = $lists->jumlah;
            $row[] = number_format($lists->jumlah);
            $row[] = $lists->lama_pinjaman;
            $row[] = number_format($lists->jumlah_pokok);
            $row[] = number_format($lists->jumlah_bunga);
            $row[] = number_format($lists->sisa_pinjaman);
            $row[]=$status;
            $row[]='<a href="'.site_url('lihatdetailpinjaman?id='.$lists->id).'" class="" title="Detail Pinjaman"><i class="bi bi-box-arrow-in-right" style="font-size:20px;"></i></a>&nbsp;&nbsp;<a href="'.site_url('setujuipencairan?id='.$lists->id).'" class="" title="Setujui Pencairan"><i class="bi bi-check2-circle" style="font-size:20px;"></i></a>&nbsp;&nbsp;<a href="javascript:cancelpencairan('.$lists->id.');" class="" title="Cancel Pencairan"><i class="bi bi-x-square-fill" style="font-size:20px;"></i></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $this->datapinjamanmodel->count_all('tbdatapinjaman', $where),
            "recordsFiltered" => $this->datapinjamanmodel->count_filtered('tbdatapinjaman', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
 
        return json_encode($output);
    }

    public function cancelpencairan(){
        $id = $this->request->getVar('id');
        if($id){
            $result=$this->datapinjamanmodel->where('id',$id)->first();
            //update jurnal 
            $get_jurnal_debet = $this->jurnalmodel->where('id_transaksi',$result['id_transaksi'])->where('debet>',0)->first();
            //echo $get_jurnal_debet['id'];
            $get_saldo_jurnal = $this->datapinjamanmodel->getsaldo($get_jurnal_debet['kode_akun']);
            //
            $data_saldo_debet = array(
                'balance'=>$get_saldo_jurnal->balance-$get_jurnal_debet['debet']
            );
            $this->datapinjamanmodel->updatesaldoakun($get_jurnal_debet['kode_akun'],$data_saldo_debet);
            $this->jurnalmodel->where('id',$get_jurnal_debet['id'])->delete();

            $get_jurnal_kredit = $this->jurnalmodel->where('id_transaksi',$result['id_transaksi'])->where('kredit>',0)->first();
            $get_saldo_jurnal = $this->datapinjamanmodel->getsaldo($get_jurnal_kredit['kode_akun']);
            //
            $data_saldo_kredit = array(
                'balance'=>$get_saldo_jurnal->balance+$get_jurnal_kredit['kredit']
            );
            $this->datapinjamanmodel->updatesaldoakun($get_jurnal_kredit['kode_akun'],$data_saldo_kredit);
            $this->jurnalmodel->where('id',$get_jurnal_kredit['id'])->delete();
            //delete transaksi jurnal
            $this->jurnalmodel->where('id_transaksi',$result['id_transaksi'])->delete();
            //delete neraca 
            $this->neracamodel->where('id_transaksi',$result['id_transaksi'])->delete();

            //delete anggsuran
            $this->datapinjamanmodel->deleteanggsuran($result['id']);

            //delete mutasipinjaman
            $this->datapinjamanmodel->deletemutasi($result['id']);

            //update pinjaman 
            $data_pinjaman = array(
                'status'=>-1
            );
            $update = $this->datapinjamanmodel->update($result['id'],$data_pinjaman);
            if($update){
                $error='0';
                $message ='Pencairan di cancel';
            }else{
                $error='1';
                $message ='Error!!, update';
            }

        }else{
            $error='1';
            $message ='Invalid ID';
        }
        $d = array(
            'error'=>$error,
            'message'=>$message
        );
        
        echo json_encode($d);
    }

    public function setujuipencairan(){
        $id = $_GET['id'];
        if($id){
            $datapinjaman = $this->datapinjamanmodel->where('id',$id)->first();
            if($datapinjaman){
                $datapinjaman = array(
                    'status'=>1
                );
                if($this->datapinjamanmodel->update($id,$datapinjaman)){
                    session()->setFlashdata('success','Pencairan sukses!!');
                }else{
                    session()->setFlashdata('error','Pencairan gagal!!');
                }
            }else{
                session()->setFlashdata('error','Pencairan gagal!!');
            }
        }else{
            session()->setFlashdata('error','Invalid ID!!');
        }
        return redirect('pencairanpinjaman');
    }

    public function getlistpinjaman(){
        $request = \Config\Services::request();
        //$list_data = $this->serverside_model;
        if(isset($_POST['kolektor']) && $_POST['kolektor']!=-1){
            $where = ['datapinjaman_v.status =' => 1,'datapinjaman_v.debt_colector =' => $_POST['kolektor']];
        }else{
            $where = ['datapinjaman_v.status =' => 1,'datapinjaman_v.sisa_pinjaman >'=>0];
        }
        
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('datapinjaman_v.id','datapinjaman_v.tgl','datapinjaman_v.debt_colector','datapinjaman_v.rek_pinjaman','datapinjaman_v.id_anggota','datapinjaman_v.jumlah_pokok','datapinjaman_v.jumlah_bunga');
        $column_search = array('datapinjaman_v.debt_colector','datapinjaman_v.id','datapinjaman_v.rek_pinjaman','datapinjaman_v.id_anggota','datapinjaman_v.jumlah_pokok','datapinjaman_v.jumlah_bunga','tbanggota.nama');
        $order = array('datapinjaman_v.rek_pinjaman' => 'desc');
        $list = $this->datapinjamanmodel->get_datatables('datapinjaman_v', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            if($lists->status==1){
                $status='Sukses';
            }else if($lists->status==-1){
                $status='Cancel';
            }else if($lists->status==0){
                $status='Pending';
            }
            $row[] = $no;
            //$r= "'".$lists->no_anggota."'";
            $row[] = $lists->tgl;
            
            $row[] = $lists->rek_pinjaman;
            $row[] = $lists->debt_colector;
            $row[] = $lists->no_anggota;
            $row[] = $lists->nama;
            $row[] = $lists->nama_simpanan;
            //$row[] = $lists->jumlah;
            $row[] = number_format($lists->jumlah);
            $row[] = $lists->lama_pinjaman;
            $row[] = number_format($lists->jumlah_pokok);
            $row[] = number_format($lists->jumlah_bunga);
            $row[] = number_format($lists->sisa_pinjaman);
            $row[] = number_format($lists->totaltempo);
            $row[] = number_format($lists->totaltunggakan);
            $row[]=$status;
            $row[]='<a href="javascript:edit_kolektor('.$lists->id.');"><i class="bi bi-clipboard2-plus" style="font-size:22px;"></i></a><a href="'.site_url('lihatdetailpinjaman?id='.$lists->id).'" class="" title="Lihat Detail"><i class="bi bi-box-arrow-in-right" style="font-size:25px;"></i></a>&nbsp;<a href="'.site_url('detailangsuran?id='.$lists->id).'" class="" title="Lihat Angsuran"><i class="bi bi-box-arrow-in-up-right" style="font-size:25px;"></i></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $this->datapinjamanmodel->count_all('datapinjaman_v', $where),
            "recordsFiltered" => $this->datapinjamanmodel->count_filtered('datapinjaman_v', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
 
        return json_encode($output);
    }

    public function datapinjaman(){
        $pager = \Config\Services::pager();
        if(isset($_GET['kolektor'])){
            $kolektor = $_GET['kolektor'];
        }else{
            $kolektor = session('user_id');
        }
        
        if(isset($kolektor) && $kolektor!=''){
            if(isset($_GET['cari_data'])){
                $cari_data = $_GET['cari_data'];
                $keyword = $_GET['keyword'];
            }
            
            if(isset($keyword)){
                if($cari_data=='nama'){
                    $anggota = $this->anggotamodel->like('nama',$keyword)->first();
                    if($anggota){
                        $id_anggota = $anggota['no_anggota'];
                    }else{
                        $id_anggota='';
                    }
                }else{
                    $id_anggota=$keyword;
                }
                if($id_anggota){
                    $results = $this->datapinjamanmodel
                    ->select("tbdatapinjaman.*,tbanggota.no_anggota,tbanggota.nama,tbanggota.alamat,tbsetuppinjaman.nama_simpanan,tbsetuppinjaman.jangka,tbsetuppinjaman.bunga")
                    ->join('tbsetuppinjaman','tbsetuppinjaman.id = tbdatapinjaman.jenis_pinjaman')
                    ->join('tbanggota','tbanggota.no_anggota = tbdatapinjaman.id_anggota')
                    ->where('tbdatapinjaman.debt_colector',$kolektor)
                    ->where('tbdatapinjaman.id_anggota',$id_anggota)
                    ->paginate(20,'btcorona');
                }else{
                    $results = $this->datapinjamanmodel
                    ->select("tbdatapinjaman.*,tbanggota.no_anggota,tbanggota.nama,tbanggota.alamat,tbsetuppinjaman.nama_simpanan,tbsetuppinjaman.jangka,tbsetuppinjaman.bunga")
                    ->join('tbsetuppinjaman','tbsetuppinjaman.id = tbdatapinjaman.jenis_pinjaman')
                    ->join('tbanggota','tbanggota.no_anggota = tbdatapinjaman.id_anggota')
                    ->where('tbdatapinjaman.debt_colector',$kolektor)
                    ->paginate(20,'btcorona');
                }
                
            }else{
                $results = $this->datapinjamanmodel
                ->select("tbdatapinjaman.*,tbanggota.no_anggota,tbanggota.nama,tbanggota.alamat,tbsetuppinjaman.nama_simpanan,tbsetuppinjaman.jangka,tbsetuppinjaman.bunga")
                ->join('tbsetuppinjaman','tbsetuppinjaman.id = tbdatapinjaman.jenis_pinjaman')
                ->join('tbanggota','tbanggota.no_anggota = tbdatapinjaman.id_anggota')
                ->where('tbdatapinjaman.debt_colector',$kolektor)
                ->paginate(20,'btcorona');
            }
            
        }else{
            $results = $this->datapinjamanmodel
            ->select("tbdatapinjaman.*,tbanggota.no_anggota,tbanggota.nama,tbanggota.alamat,tbsetuppinjaman.nama_simpanan,tbsetuppinjaman.jangka,tbsetuppinjaman.bunga")
            ->join('tbsetuppinjaman','tbsetuppinjaman.id = tbdatapinjaman.jenis_pinjaman')
            ->join('tbanggota','tbanggota.no_anggota = tbdatapinjaman.id_anggota')
            //->where('tbdatapinjaman.debt_colektor',$kolektor)
            ->paginate(20,'btcorona');
        }
        $data = array(
            'kolektors'=>$this->usermodel->where(array('userlevel'=>2,'status'=>1))->findAll(),
            'kolektor'=>$kolektor,
            'results'=>$results,
            'pager' => $this->datapinjamanmodel->pager,
        );
        if(session('userlevel')!=0){
            return view('main/listpinjaman',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function savekolektor(){
        $rules = [
            'id_data' => 'required',
            'kolektor'=> 'required'
        ];
        if($this->validate($rules)){
            $kolektor = $this->request->getVar('kolektor');
            $id = $this->request->getVar('id_data');
            $data = array(
                'debt_colector'=>$kolektor
            );
            $save = $this->datapinjamanmodel->update($id,$data);
            if($save){
                session()->setFlashdata('success','Data berahasil disimpan');
            }else{
                session()->setFlashdata('error','Data gagal disimpan');
            }
        }
        return redirect('datapinjaman');
    }

    public function detailpinjaman(){
        $id = $_GET['id'];
        $detail = $this->datapinjamanmodel->getdetailpinjaman('tbdatapinjaman',$id);
        $results_biaya = $this->biayapinjamanmodel->where('id_pinjaman',$detail->jenis_pinjaman)->findAll();
        $data['detail']=$detail;
        $data['results_biaya']=$results_biaya;
        $data['id']=$id;
        if(session('userlevel')!=0){
            return view('main/detail-pinjaman',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function printpinjaman(){
        $id = $_GET['id'];
        $profile = $this->profilemodel->first();
        $detail = $this->datapinjamanmodel->getdetailpinjaman('tbdatapinjaman',$id);
        $results_angsuran = $this->datapinjamanmodel->getangsuran($id);
        $results_biaya = $this->biayapinjamanmodel->where('id_pinjaman',$detail->jenis_pinjaman)->findAll();
        $data = array(
            'profile'=>$profile,
            'detail'=>$detail,
            'results_biaya'=>$results_biaya,
            'results_angsuran'=>$results_angsuran
        );
        if(session('userlevel')!=0){
            return view('print/pinjaman',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function printkelengkapanpinjaman(){
        helper('Bulan');
        $id = $_GET['id'];
        $profile = $this->profilemodel->first();
        $detail = $this->datapinjamanmodel->getdetailpinjaman('tbpengajuanpinjaman',$id);
        $results_biaya = $this->biayapinjamanmodel->where('id_pinjaman',$detail->jenis_pinjaman)->findAll();
        $lastpinjaman = $this->datapinjamanmodel->getlastpinjaman($detail->no_anggota);
        $data = array(
            'profile'=>$profile,
            'detail'=>$detail,
            'results_biaya'=>$results_biaya,
            'lastpinjaman'=>$lastpinjaman
        );
        if(session('userlevel')!=0){
            return view('print/kelengkapan-pinjaman',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function detailangsuran(){
        helper('form');
        $id = $_GET['id'];
        $detail = $this->datapinjamanmodel->getdetailpinjaman('tbdatapinjaman',$id);
        $results_angsuran = $this->datapinjamanmodel->getangsuran($id);
        $data_tempo = $this->datapinjamanmodel->getangsurantempo($id);
        //echo json_encode($data_tempo);
        $data = array(
            'detail'=>$detail,
            'id'=>$id,
            'results_angsuran'=>$results_angsuran,
            'n'=>$data_tempo->total
        );
        if(session('userlevel')!=0){
            return view('main/detail-angsuran',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function bayarangsuran(){
        date_default_timezone_set('Asia/Singapore');
        if(date("H")>=19){
            return redirect()->to('dashboard');
        }
        $model = New Statusmodel();
        $status = $model->where('status',0)->first();
        
        if($status){
            return redirect()->to('dashboard'); 
        }
        helper('form');
        if(session()->get('userlevel')!=2 && session('userlevel')!='4' && session('userlevel')!='3' && session('userlevel')!='6'){
            return redirect()->to('dashboard'); 
        }
        $id = $_GET['id'];
        $detail = $this->datapinjamanmodel->getdataangsurandetail($id)->getRow();
        $detail_data = $this->datapinjamanmodel->getdetailpinjaman('tbdatapinjaman',$detail->id_pinjaman);

        if(session('userlevel')==2){
            if(session('user_id')!=$detail_data->debt_colector){
                return redirect()->to('dashboard');
            }
        }
        $result_kas_akun = $this->akunmodel->where('no_akun','01.01')->first();
        $data_akun_kas = $this->akunmodel->where('sub_account',$result_kas_akun['id'])->findAll();
        $data_tempo = $this->datapinjamanmodel->getangsurantempo($id);
        $data = array(
            'detail'=>$detail_data,
            'detail_data'=>$detail,
            'id'=>$id,
            'data_akun'=>$data_akun_kas,
            //'n'=>$data_tempo->n
        );
        //echo json_encode($detail_data);
        if(session('userlevel')!=0){
            return view('main/bayarangsuran',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function saveangsuran(){
        $upload = NEW Uploadkit();
        date_default_timezone_set('Asia/Singapore');
        $id_angsuran = $this->request->getVar('id_angsuran');
        $bukti = $this->request->getVar('img_id');
        $tgl = date('Y-m-d');
        $random = rand(000,999);
        $id_transaksi = date('Ymdhis').$random;
        $akun = $this->request->getVar('jenis_kas');
        if(!$akun){
            session()->setFlashdata('error','Kas belum dipilih');
            return redirect()->back();
        }
        
        if(session('userlevel')!=3){
            if(!$bukti){
                session()->setFlashdata('error','Photo Bukti Belum terisi');
                return redirect()->back();
            }
        }
        
        if($id_angsuran){
            foreach($id_angsuran as $d){
                if($d){
                    $data_tempo = $this->datapinjamanmodel->getdataangsurandetail($d)->getRow();
                    if($data_tempo){
                        if($bukti==''){
                            $photo_bukti='';
                        }else{
                            $uppath2 = WRITEPATH . 'uploads/'.$bukti;
                            $photo_bukti = $upload->uploaddata($uppath2,$bukti,'buktipembayaran');
                            unlink($uppath2);
                        }
                        
                        $data_angsuran = array(
                            'status'=>1,
                            'id_transaksi'=>$id_transaksi,
                            'tgl_bayar'=>$tgl,
                            'username'=>session()->get('username'),
                            'bukti_pembayaran'=>$photo_bukti,
                            'approve_status'=>0
                        );
                        $this->datapinjamanmodel->updateangsuran($d,$data_angsuran);
                        //sisa hutang 
                        $data_pinjaman = $this->datapinjamanmodel->getdetailpinjaman('tbdatapinjaman',$data_tempo->id_pinjaman);
                        if($data_pinjaman){
                            //update pinjaman 
                            $sisa_hutang = $data_pinjaman->sisa_pinjaman-$data_tempo->jumlah_pokok;
                            $_pinjaman_data = array(
                                'sisa_pinjaman'=>$sisa_hutang
                            );
                            $this->datapinjamanmodel->update($data_pinjaman->id,$_pinjaman_data);
                        }
                        $data_mutasi = array(
                            'id_pinjaman'=>$data_pinjaman->id,
                            'tgl'=>$tgl,
                            'debet'=>0,
                            'kredit'=>$data_tempo->jumlah_pokok,
                            'balance'=>$sisa_hutang,
                            'status'=>1
                        );
                        $this->datapinjamanmodel->cratemutasi($data_mutasi);
                        $this->jurnalangsuranpokok($id_transaksi,$data_tempo->jumlah_pokok,$akun,$data_pinjaman,$tgl);
                        //komen dulu untuk setup awal
                        $this->jurnalangsuranbunga($id_transaksi,$data_tempo->jumlah_bunga,$akun,$data_pinjaman,$tgl);
                        //save ke followup jika ada di data followup 
                        $model = new Kunjunganwajibmodel();
                        $updatekunjungan = $model->updatekunjungan($data_pinjaman->no_anggota);
                    }    
                }
            }
        }
        session()->setFlashdata('success','Angsuran berhasil disimpan');
        echo '<script type="text/javascript">location.href="detailangsuran?id='.$data_pinjaman->id.'";</script>';
    }

    public function jurnalangsuranpokok($id_transaksi,$jumlah,$akun,$data_pinjaman,$tgl){
        $jenis_pinjaman = $this->setuppinjamanmodel->where('id',$data_pinjaman->jenis_pinjaman)->first();
        if($jenis_pinjaman['jenis_pinjaman']==1){
            $akun_kredit = '01.02.130-15';
        }
        if($jenis_pinjaman['jenis_pinjaman']==2){
            $akun_kredit = '01.02.130-20';
        }
        if($jenis_pinjaman['jenis_pinjaman']==3){
            $akun_kredit = '01.02.130-25';
        }
        if($jenis_pinjaman['jenis_pinjaman']==4){
            $akun_kredit = '01.02.130-30';
        }
        $data_jurnal_debet = array(
            'id_transaksi'=>$id_transaksi,
            'date'=>$tgl,
            'kode_akun'=>$akun,
            'uraian'=>'Angsuran pokok '.$data_pinjaman->rek_pinjaman,
            'debet'=>$jumlah,
            'kredit'=>0,
            'jenis_transaksi'=>5
        );

        $data_jurnal_kredit = array(
            'id_transaksi'=>$id_transaksi,
            'date'=>$tgl,
            'kode_akun'=>$akun_kredit,
            'uraian'=>'Piutang pokok '.$data_pinjaman->rek_pinjaman,
            'debet'=>0,
            'kredit'=>$jumlah,
            'jenis_transaksi'=>5
        );
        $this->jurnalmodel->insert($data_jurnal_debet);
        $this->jurnalmodel->insert($data_jurnal_kredit);

        //neraca 
        //neraca 
        $t_transaksi = explode("-",$tgl);
        $bulan = $t_transaksi[1];
        $tahun = $t_transaksi[0];

        $data_neraca = array(
            'id_transaksi'=>$id_transaksi,
            'kode_akun'=>$akun,
            'saldo_normal'=>'D',
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'balance'=>$jumlah,
            'is_awal'=>0
        );

        $data_neraca2 = array(
            'id_transaksi'=>$id_transaksi,
            'kode_akun'=>$akun_kredit,
            'saldo_normal'=>'K',
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'balance'=>$jumlah,
            'is_awal'=>0
        );

        $this->neracamodel->insert($data_neraca);
        $this->neracamodel->insert($data_neraca2);
    }

    public function jurnalangsuranbunga($id_transaksi,$jumlah,$akun,$data_pinjaman,$tgl){
        $jenis_pinjaman = $this->setuppinjamanmodel->where('id',$data_pinjaman->jenis_pinjaman)->first();
        if($jenis_pinjaman['jenis_pinjaman']==1){
            $akun_kredit = '02.01.210-50';
        }
        if($jenis_pinjaman['jenis_pinjaman']==2){
            $akun_kredit = '02.01.210-60';
        }
        if($jenis_pinjaman['jenis_pinjaman']==3){
            $akun_kredit = '02.01.210-70';
        }
        if($jenis_pinjaman['jenis_pinjaman']==4){
            $akun_kredit = '02.01.210-80';
        }
        $data_jurnal_debet = array(
            'id_transaksi'=>$id_transaksi,
            'date'=>$tgl,
            'kode_akun'=>$akun,
            'uraian'=>'Angsuran pokok '.$data_pinjaman->rek_pinjaman,
            'debet'=>$jumlah,
            'kredit'=>0,
            'jenis_transaksi'=>5
        );

        $data_jurnal_kredit = array(
            'id_transaksi'=>$id_transaksi,
            'date'=>$tgl,
            'kode_akun'=>$akun_kredit,
            'uraian'=>'Piutang pokok '.$data_pinjaman->rek_pinjaman,
            'debet'=>0,
            'kredit'=>$jumlah,
            'jenis_transaksi'=>5
        );
        $this->jurnalmodel->insert($data_jurnal_debet);
        $this->jurnalmodel->insert($data_jurnal_kredit);

        //neraca 
        //neraca 
        $t_transaksi = explode("-",$tgl);
        $bulan = $t_transaksi[1];
        $tahun = $t_transaksi[0];

        $data_neraca = array(
            'id_transaksi'=>$id_transaksi,
            'kode_akun'=>$akun,
            'saldo_normal'=>'D',
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'balance'=>$jumlah,
            'is_awal'=>0
        );

        $data_neraca2 = array(
            'id_transaksi'=>$id_transaksi,
            'kode_akun'=>$akun_kredit,
            'saldo_normal'=>'K',
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'balance'=>$jumlah,
            'is_awal'=>0
        );

        $this->neracamodel->insert($data_neraca);
        $this->neracamodel->insert($data_neraca2);
    }

    public function approvestatus(){
        $id_pinjaman = $_GET['id_pinjaman'];
        
    }

    function detailpembayaran(){
        $id_pinjaman = $_GET['id'];
        $last = $this->datapinjamanmodel->getpembayaranlast($id_pinjaman);
        $datapembayarans = $this->datapinjamanmodel->getdatapembayarandetails($id_pinjaman);
        $data = array(
            'last'=>$last,
            'datapembayarans'=>$datapembayarans
        );
        echo json_encode($data);
    }

    function approvedata(){
        $id = $this->request->getVar('id');
        if($id){
            if($this->datapinjamanmodel->updatedataangsuran($id)){
                echo 'Data berhasil disimpan';
            }else{
                echo 'Gagal, menyimpan data';
            }
        }else{
            echo 'ID salah';
        }
    }

    function simpankartuhilang(){
        $id = $this->request->getVar('id');
        $alasan = $this->request->getVar('alasan');
        $kolektor = $this->request->getVar('kolektor');
        $data = array(
            'created_at'=>date('Y-m-d H:i:s'),
            'id_pinjaman'=>$id,
            'kolektor'=>$kolektor,
            'alasan'=>$alasan
        );
        if($this->datapinjamanmodel->_insertkartuhilang($data)){
            $this->datapinjamanmodel->updatedataangsuranstatus($id,2);
            echo 'Data berhasil disimpan';
        }
    }

    function dataselisih(){
        $id_pinjaman = $_GET['id'];
        $results = $this->datapinjamanmodel->_getselisih($id_pinjaman);
        echo json_encode($results);
    }

    function simpanselisih(){
        $id = $this->request->getVar('id');
        $tgl_selisih = $this->request->getVar('tgl_selisih');
        $kolektor = $this->request->getVar('kolektor');
        $keterangan = $this->request->getVar('keterangan');
        $query = $this->datapinjamanmodel->getdetailpinjaman('tbdatapinjaman',$id);
        $data_selisih = array(
            'created_at'=>date("Y-m-d H:i:s"),
            'id_pinjaman'=>$id,
            'tgl_selisih'=>$tgl_selisih,
            'jumlah'=>$query->jumlah_pokok+$query->jumlah_bunga,
            'kolektor'=>$kolektor,
            'keterangan'=>$keterangan
        );
        if($this->datapinjamanmodel->_insertselisih($data_selisih)){
            echo 'Data berhasil disimpan';
        }else{
            echo 'Tidak berhasil menyimpan Data';
        }
    }

    function hapusselisih(){
        $id = $this->request->getVar('id');
        if($this->datapinjamanmodel->_hapusselisih($id)){
            echo 'Data berhasil di hapus';
        }else{
            echo 'Gagal menghapus data';
        }
    }

    function submitselisih(){
        if($this->datapinjamanmodel->updatedataangsuranstatus($id,3)){
            echo 'Selisih berhasil disubmit';
        }else{
            echo 'Gagal menyimpan selisih';
        }
    }
    
}
?>