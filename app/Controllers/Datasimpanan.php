<?php

namespace App\Controllers;

use App\Models\Setupsimpananmodel;
use App\Models\Biayapinjamanmodel;
use App\Models\Serversidemodel;
use App\Models\Akunmodel;
use App\Models\Anggotamodel;
use App\Models\Simpanananggotamodel;
use App\Models\Mutasianggotamodel;
use App\Models\Jurnalmodel;
use App\Models\Neracamodel;
use App\Models\Simpananmodel;
use App\Models\Datasimpananmodel;
use App\Models\Pengajuanmodel;
use App\Models\Pengeluaranmodel;

class Datasimpanan extends BaseController
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
        $this->datasimpananmodel=new Datasimpananmodel();
        $this->pengajuannmodel=new Pengajuanmodel();
        $this->pengeluaranmodel=new Pengeluaranmodel();
        helper('form');
    }

    public function index(){
        $data = array(
            //'results'=>$this->simpananmodel->getSimpanananggota()->getResult()
        );
        //$data['anggota']=$this->anggotamodel->findAll();
        if(session('userlevel')!=0){
            return view('main/simpanananggota',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function tambahsimpanananggota(){
        $result2 = $this->setupsimpananmodel->orderBy('id','DESC')->findAll();
        $data['results2']=$result2;
        $result_kas_akun = $this->akunmodel->where('no_akun','01.01')->first();
        $data_akun_kas = $this->akunmodel->where('sub_account',$result_kas_akun['id'])->findAll();
        $data['result_akun']=$data_akun_kas;
        //$data['anggota']=$this->anggotamodel->findAll();
        if(session('userlevel')!=0){
            return view('main/tambahsimpanananggota',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function dataanggota(){
        $request = \Config\Services::request();
        //$list_data = $this->serverside_model;
        $where = ['id !=' => 0,'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array(NULL,'tbanggota.no_anggota','tbanggota.nama','tbanggota.alamat');
        $column_search = array('tbanggota.no_anggota','tbanggota.nama','tbanggota.alamat');
        $order = array('tbanggota.nama' => 'asc');
        $list = $this->serversidemodel->get_datatables('tbanggota', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
        	//check pinjaman sebelumnya 
        	$check = $this->pengajuannmodel->where('id_anggota',$lists->no_anggota)->orderby('id','DESC')->first();
        	if($check){
            	$jaminan =$check['jaminan'];
            }else{
            	$jaminan ='';
            }
            $no++;
            $row    = array();
            //$row[] = $no;
            $r= "'".$lists->no_anggota."'";
            $row[] = $lists->no_anggota;
            $row[] = $lists->nama;
            $row[] = $lists->alamat;
        	$row[]= $jaminan;
            $row[]='<a href="javascript:pilihanggota('.$r.');" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
          </svg>&nbsp;PILIH</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $this->serversidemodel->count_all('tbanggota', $where),
            "recordsFiltered" => $this->serversidemodel->count_filtered('tbanggota', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
 
        return json_encode($output);
    }

    public function datasimpanan(){
        $request = \Config\Services::request();
        //$list_data = $this->serverside_model;
        $where = array();
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('tbsimpanananggota.id_transaksi','tbsimpanananggota.id_anggota','tbsimpanananggota.tgl','tbanggota.nama','tbanggota.no_anggota');
        $column_search = array('tbsimpanananggota.id_transaksi','tbsimpanananggota.id_anggota','tbsimpanananggota.tgl','tbanggota.nama','tbanggota.no_anggota');
        $order = array('tbsimpanananggota.id' => 'DESC');
        $list = $this->datasimpananmodel->get_datatables('tbsimpanananggota', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            if($lists->status==1){
                $status='Aktif';
                $link ='<a href="'.site_url('tariksimpanan/?id='.$lists->id_transaksi).'" class="btn btn-warning"><i class="bi bi-arrow-right-square-fill" style="font-size:20px;font-weight:bold;"></i>&nbsp;TARIK</a>';
            }else{
                $status='Tidak Aktif';
                $link='-';
            }
            $row    = array();
            $row[]=$lists->id_transaksi;
            $row[]=$lists->no_anggota;
            $row[]=$lists->nama;
            $row[]=$lists->tgl;
            $row[]=$lists->tgl_jatuh_tempo;
            $row[]=$lists->nama_simpanan;
            $row[]=$lists->jangka;
            $row[]=number_format($lists->jumlah);
            $row[]=$status;
            $row[]=$link;
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $this->datasimpananmodel->count_all('tbsimpanananggota', $where),
            "recordsFiltered" => $this->datasimpananmodel->count_filtered('tbsimpanananggota', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
 
        return json_encode($output);
    }
    
    public function savesimpanan(){
        $rules = [
            'kode_anggota' => 'required',
            'jenis_simpanan'=> 'required',
            'jumlah_simpanan' => 'required|numeric',
            'tgl'=>'required'
        ];
        if($this->validate($rules)){
            $id_transaksi = date("YmdHis");
            $kode_anggota = $this->request->getVar('kode_anggota');
            $jenis_simpanan = $this->request->getVar('jenis_simpanan');
            $jumlah_simpanan = $this->request->getVar('jumlah_simpanan');
            $tgl =$this->request->getVar('tgl');
            $jenis_kas =$this->request->getVar('jenis_kas');
            $result2 = $this->setupsimpananmodel->where('id',$jenis_simpanan)->orderBy('id','DESC')->first();
            $jangka = $result2['jangka'];
            $tgl2    = date('Y-m-d', strtotime('+'.$jangka.' months', strtotime($tgl)));
            $anggota = $this->anggotamodel->orderBy('nama','ASC')->where('no_anggota',$kode_anggota)->first();
            $setupsimpanan = $this->setupsimpananmodel->orderBy('nama_simpanan','ASC')->where('id',$jenis_simpanan)->first();
            $data_jurnal = array(
                'id_transaksi'=>$id_transaksi,
                'date'=>$tgl,
                'kode_akun'=>'02.01.210-15',
                'uraian'=>$setupsimpanan['nama_simpanan'].' '.$anggota['no_anggota'],
                'kredit'=>$jumlah_simpanan,
                'debet'=>0
            );

            $data_jurnal2 = array(
                'id_transaksi'=>$id_transaksi,
                'date'=>$tgl,
                'kode_akun'=>$jenis_kas,
                'uraian'=>$setupsimpanan['nama_simpanan'].' '.$anggota['no_anggota'],
                'kredit'=>0,
                'debet'=>$jumlah_simpanan
            );

            $t_transaksi = explode("-",$tgl);
            $bulan = $t_transaksi[1];
            $tahun = $t_transaksi[0];

            $data_neraca = array(
                'id_transaksi'=>$id_transaksi,
                'kode_akun'=>$jenis_kas,
                'saldo_normal'=>'D',
                'bulan'=>$bulan,
                'tahun'=>$tahun,
                'balance'=>$jumlah_simpanan,
                'is_awal'=>0
            );

            $data_neraca2 = array(
                'id_transaksi'=>$id_transaksi,
                'kode_akun'=>'02.01.210-15',
                'saldo_normal'=>'K',
                'bulan'=>$bulan,
                'tahun'=>$tahun,
                'balance'=>$jumlah_simpanan,
                'is_awal'=>0
            );

            $data_simpanan = array(
                'id_anggota'=>$anggota['id'],
                'id_transaksi'=>$id_transaksi,
                'id_jenis_simpanan'=>$jenis_simpanan,
                'tgl'=>$tgl,
                'tgl_jatuh_tempo'=>$tgl2,
                'jumlah'=>$jumlah_simpanan,
                'status'=>1
            );

            //save jurnal
            $this->jurnalmodel->insert($data_jurnal2);
            $this->jurnalmodel->insert($data_jurnal);
            

            //save neraca
            $this->neracamodel->insert($data_neraca);
            $this->neracamodel->insert($data_neraca2);

            //save to simpanan
            $save = $this->simpanananggotamodel->insert($data_simpanan);
            if($save){
                //get mutasi
                $cekmutasi = $this->mutasianggotamodel->orderBy('id','DESC')->where('id_anggota',$anggota['id'])->first();
                if($cekmutasi){
                    $balance = $cekmutasi['balance']+$jumlah_simpanan;
                }else{
                    $balance=$jumlah_simpanan;
                }
                $data_mutasi = array(
                    'id_anggota'=>$anggota['id'],
                    'id_transaksi'=>$id_transaksi,
                    'kode_transaksi'=>'DEP',
                    'tgl_transaksi'=>$tgl,
                    'debet'=>$jumlah_simpanan,
                    'kredit'=>0,
                    'balance'=>$balance,
                    'status'=>1
                );
                
                $this->mutasianggotamodel->insert($data_mutasi);
                session()->setFlashdata('success','Data tabungan telah tersimpan');
                return redirect('tambahsimpanananggota');
            }else{
                session()->setFlashdata('error','Data tidak tersimpan');
                return redirect('tambahsimpanananggota');
            }
            //echo json_encode($data_jurnal);
        }else{
            session()->setFlashdata('error',$this->validator->listErrors());
            return redirect('tambahsimpanananggota');
        }
    }

    //
    public function simpanpinjaman(){
        $id = $this->request->getVar('id');
        $detail = $this->pengajuannmodel->getdatapengajuandetail($id);
        if($detail){
            if($detail->status==0){
                $jenis_kas = $this->request->getVar('jenis_kas');
                if($jenis_kas){
                    //cek saldo kas 
                    $cek_kas = $this->pengajuannmodel->ceksaldoakun($jenis_kas);
                    if($cek_kas){
                        if($cek_kas->balance>=$detail->jumlah){
                            //balance masih
                            $no_rek = $this->pengajuannmodel->getdatarek()->rek_pinjaman;
                            $no_rek = $no_rek+1;
                            $no_rek = '00-00-'.sprintf("%09s", $no_rek);
                            $totalbunga = ($detail->bunga*$detail->jangka)/100;
                            $totalbunga_idr = $totalbunga * $detail->jumlah;
                            $pokok = $detail->jumlah/$detail->jangka;
                            $total_angsuran = ($totalbunga_idr+$detail->jumlah)/$detail->jangka;
                            $bunga_angsuran = $totalbunga_idr/$detail->jangka;
                            $data_pinjaman = array(
                                'id_anggota'=>$detail->id_anggota,
                                'akun'=>$jenis_kas,
                                'rek_pinjaman'=>$no_rek,
                                'jenis_pinjaman'=>$detail->jenis_pinjaman,
                                'lama_pinjaman'=>$detail->jangka,
                                'jumlah_pokok'=>$pokok,
                                'jumlah_bunga'=>$bunga_angsuran,
                                'tgl'=>date('Y-m-d'),
                                'jumlah'=>$detail->jumlah,
                                'sisa_pinjaman'=>$detail->jumlah
                            );
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

    public function addbungadeposito(){
        $results = $this->simpanananggotamodel
                    ->join('tbsetupsimpanan','tbsimpanananggota.id_jenis_simpanan=tbsetupsimpanan.id')
                    ->select('tbsimpanananggota.*,tbsetupsimpanan.bunga')->findAll();
        $i=0;
        if(count($results)>0){
            foreach($results as $row){
                $i++;
                if($row['updated_at']<$row['tgl']){
                    $_s_date = $row['tgl'];
                }else{
                    $_s_date = $row['updated_at'];
                }
                //echo $_s_date;
                $_time_date = date('Y-m-d', strtotime('+1 month', strtotime($_s_date))); 
                //echo $i.' '.$_time_date.'<br/>';
                if($_time_date<date('Y-m-d')){
                    //input to bunga 
                    $bunga = ($row['bunga']/100)*$row['jumlah'];
                    $data_bunga = array(
                        'id_tabungan'=>$row['id'],
                        'id_anggota'=>$row['id_anggota'],
                        'date'=>$_time_date,
                        'debet'=>$bunga
                    );
                    //echo json_encode($data_bunga);
                    if($this->simpanananggotamodel->addbungadeposito($data_bunga)){
                        echo $_s_date;
                    }
                }
            }
        }
    }

    public function listsimpanan(){
        $results = $this->simpanananggotamodel->getdatasimpanananggota();
        $data['results']=$results;
        if(session('userlevel')!=0){
            return view('main/listsimpanan',$data);
        }else{
            return view('member/profile',$data);
        }
    }
    
    public function tarikbunga(){
        $id_anggota = $_GET['id'];
        $datatabungan =$this->simpanananggotamodel->getsaldoanggota($id_anggota);
        $data = array(
            'id_anggota'=>$id_anggota,
            'datatabungan'=>$datatabungan
        );
        if(isset($_POST['submit'])){
            $rules = [
                'jumlah' => 'required|numeric',
                'tgl'=> 'required'
            ];
            if($this->validate($rules)){
                if(isset($_POST['jumlah'])){
                    $id_transaksi = date("YmdHis");
                    $jumlah = $this->request->getVar('jumlah');
                    $tgl = $this->request->getVar('tgl');
                    if($jumlah>$datatabungan->total){
                        session()->setFlashdata('error','Jumlah penarikan lebih besar dari saldo');
                        return redirect('listsimpanan');
                    }
                    $data_bunga  = array(
                        'id_tabungan'=>0,
                        'id_anggota'=>$id_anggota,
                        'date'=>$tgl,
                        'debet'=>0,
                        'kredit'=>$jumlah
                    );
                    if($this->simpanananggotamodel->addbungadeposito($data_bunga)){
                        //save to history tabungan 
                        $data_history = array(
                            'date'=>$tgl,
                            'id_anggota'=>$id_anggota,
                            'uraian'=>'Penarikan bunga tabungan ',
                            'jumlah'=>$jumlah,
                            'status'=>1,
                            'id_transaksi'=>$id_transaksi
                        );
                        if($this->simpanananggotamodel->savehistorytabungan($data_history)){
                            //save to pengeluaran 
                            $data = array(
                                'akun'=>'02.01.220-60',
                                'tgl'=>$tgl,
                                'uraian'=>'Penarikan Bunga Tabungan',
                                'jumlah'=>$jumlah,
                                'id_transaksi'=>$id_transaksi
                            );
                            //save pendapatan 
                            $save = $this->pengeluaranmodel->insert($data);
                            //save to jurnal
                            $akun ='02.01.220-60';
                            $akun_kredit='01.01.110-40';

                            $data_jurnal_debet = array(
                                'id_transaksi'=>$id_transaksi,
                                'date'=>$tgl,
                                'kode_akun'=>$akun,
                                'uraian'=>'Penarikan Bunga Tabungan',
                                'debet'=>$jumlah,
                                'kredit'=>0,
                                'jenis_transaksi'=>8//Bunga tabungan
                            );
                    
                            $data_jurnal_kredit = array(
                                'id_transaksi'=>$id_transaksi,
                                'date'=>$tgl,
                                'kode_akun'=>$akun_kredit,
                                'uraian'=>'Penarikan Bunga Tabungan',
                                'debet'=>0,
                                'kredit'=>$jumlah,
                                'jenis_transaksi'=>8//Bunga tabungan
                            );
                            $this->jurnalmodel->insert($data_jurnal_debet);
                            $this->jurnalmodel->insert($data_jurnal_kredit);
                            session()->setFlashdata('success','Penarikan berhasil');
                            return redirect('tarikbunga?id='.$id_anggota);
                        }
                    }
                }else{
                    session()->setFlashdata('error','Jumlah harus di isi');
                }
            }
            
        }
        if(isset($id_anggota)){
            return view('main/tariktabungan',$data);
        }
    }
}
?>