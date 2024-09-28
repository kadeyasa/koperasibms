<?php
namespace App\Controllers;
//use App\Models\pengajuanmodel;
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
use App\Models\Datasimpananmodel;
use App\Models\Pengajuanmodel;
use App\Models\Usermodel;
use App\Models\Profilemodel;
use App\Models\Datapinjamanmodel;
use App\Models\Pengajuandetailmodel;
use App\Libraries\Uploadkit;
use CodeIgniter\Files\File;

class Pengajuanpinjaman extends BaseController
{
    public function __construct(){
       // $this->pengajuanmodel=new Pengajuanmodel();
        $this->setuppinjamanmodel=new setuppinjamanmodel();
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
        $this->usermodel=new Usermodel();
        $this->profilemodel=new Profilemodel();
        helper('form');
    }

    public function datapengajuan(){
        $data = array(
            //'results'=>$this->simpananmodel->getSimpanananggota()->getResult()
        );
        //$data['anggota']=$this->anggotamodel->findAll();
        if(session('userlevel')!=0){
            return view('main/pengajuanpinjaman',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function getDataPengajuan(){
        $request = \Config\Services::request();
        //$list_data = $this->serverside_model;
        $where = ['tbpengajuanpinjaman.status =' => 0];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array(NULL,'tbpengajuanpinjaman.jenis_pinjaman','tbanggota.nama','tbanggota.no_anggota');
        $column_search = array('tbpengajuanpinjaman.jenis_pinjaman','tbanggota.nama','tbanggota.no_anggota');
        $order = array('tbpengajuanpinjaman.tgl_pengajuan' => 'asc');
        $list = $this->pengajuannmodel->get_datatables('tbpengajuanpinjaman', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            if($lists->status==1){
                $status='Disetujui';
            }else if($lists->status==-1){
                $status='Ditolak';
            }else if($lists->status==0){
                $status='Pending';
            }else if($lists->status==2){
                $status='Menunggu Persetujuan';
            }
            //$row[] = $no;
            //$r= "'".$lists->no_anggota."'";
            $row[] = $lists->no_anggota.'/'.$lists->no_telp;
            $row[] = $lists->tgl_pengajuan;
            $row[] = $lists->no_anggota;
            $row[] = $lists->nama;
            if($lists->jaminan!=''){
                $row[] = $lists->nama_simpanan.' ( Jaminan '.$lists->jaminan.' ) ';
            }else{
                $row[] = $lists->nama_simpanan;
            }
            
            $row[] = number_format($lists->jumlah);
            $row[]=$status;
            if($lists->detailstatus==1 || $lists->status==0){
                $row[]='<a href="'.site_url('editstatuspengajuan?id='.$lists->id).'" class="btn btn-primary">Edit Status</a><br/><a href="'.site_url('printkelengkapanpinjaman?id='.$lists->id).'" class="btn btn-warning">Print</a>
                <br/><a target="__blank" href="https://wa.me/'.$lists->no_telp.'?text=Kami dari Koperasi Bhakti Mulia Shanti, Mau Konfirmasi untuk pengajuan kembali pinjaman A.n '.$lists->nama.', Jumlah Pinjaman : '.number_format($lists->jumlah).' Mohon Balas WA ini untuk proses pencairan pinjaman" class="btn btn-success">Konfirmasi WA</a>';
            }else{
                $row[]='<a href="'.site_url('printkelengkapanpinjaman?id='.$lists->id).'" class="btn btn-warning">Print</a>
                <br/><a target="__blank" href="https://wa.me/'.$lists->no_telp.'?text=Kami dari Koperasi Bhakti Mulia Shanti, Mau Konfirmasi untuk pengajuan kembali pinjaman A.n '.$lists->nama.', Jumlah Pinjaman : '.number_format($lists->jumlah).' Mohon Balas WA ini untuk proses pencairan pinjaman" class="btn btn-success">Konfirmasi WA</a>';
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $this->pengajuannmodel->count_all('tbpengajuanpinjaman', $where),
            "recordsFiltered" => $this->pengajuannmodel->count_filtered('tbpengajuanpinjaman', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
 
        return json_encode($output);
    }

    public function ajukanpinjaman(){
        if(isset($_GET['id'])){
            $data['id'] = $_GET['id'];
        }else{
            $data['id'] = '';
        }
        //$data['id'] = $_GET['id'];
        $result2 = $this->setuppinjamanmodel->orderBy('id','DESC')->findAll();
        $data['results2']=$result2;
        $data['row']=$this->setuppinjamanmodel->where('id',$data['id'])->first();
        $data['rowbiaya']=$this->biayapinjamanmodel->where('id_pinjaman',$data['id'])->findAll();
        $modeluser = New Usermodel();
        $kolektors = $modeluser->where('userlevel',2)->findAll();
        $data['kolektors']=$kolektors;
        //$result_kas_akun = $this->akunmodel->where('no_akun','01.01')->first();
        //$data_akun_kas = $this->akunmodel->where('sub_account',$result_kas_akun['id'])->findAll();
        //$data['result_akun']=$data_akun_kas;
        //$data['anggota']=$this->anggotamodel->findAll();
        if(session('userlevel')!=0){
            return view('main/tambahpengajuan',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function savepengajuan(){
        $upload = NEW Uploadkit();
        $id = $this->request->getVar('jenis_pinjaman');
        $rules = [
            'jumlah_pinjaman' => 'required',
            'jaminan' => 'required',
            //'photo_jaminan'=>'required',
            //'bukti_pembayaran'=>'required'
        ];
        //$id= $this->request->getVar('nama_simpanan');
        if($this->validate($rules)){
            
            $img = $this->request->getFile('photo_jaminan');
            $newName = $img->getRandomName();
            $img->move(WRITEPATH . 'uploads',$newName);
            //move to image kit
            $uppath = WRITEPATH . 'uploads/'.$newName;
            
            $img2 = $this->request->getFile('bukti_pembayaran');
            $newName2 = 'bukti_.'.$img2->getRandomName();
            $img2->move(WRITEPATH . 'uploads',$newName2);
            //move to image kit
            $uppath2 = WRITEPATH . 'uploads/'.$newName2;
           
            //unlink($uppath2);

            $pengajuan_dari = $this->request->getVar('pengajuan_dari');
            $tgl = $this->request->getVar('tgl');
            $jumlah_pinjaman = $this->request->getVar('jumlah_pinjaman');

            $photo_jaminan = $upload->uploaddata($uppath,$newName,'datakoperasi');
            $photo_bukti = $upload->uploaddata($uppath2,$newName2,'buktipembayaran');
            $kolektor = $this->request->getVar('kolektor');

            unlink($uppath2);
            unlink($uppath);
            if($pengajuan_dari==0){
                $nik = $this->request->getVar('nik');
                $nama = $this->request->getVar('nama');
                $alamat = $this->request->getVar('alamat');
                $no_telp = $this->request->getVar('no_telp');
                $jaminan = $this->request->getVar('jaminan');
                $jenis_anggota = 'calon';
                $jenis_kelamin = $this->request->getVar('jenis_kelamin');
                
                $num_rows = $this->anggotamodel->countAll();
                //$data['results']=$result;
                $urutan = $num_rows+1;
                $no_anggota='BMS'.sprintf("%05s", $urutan);
                $data_anggota = array(
                    'nik'=>$nik,
                    'nama'=>$nama,
                    'alamat'=>$alamat,
                    'no_telp'=>$no_telp,
                    'jenis_kelamin'=>$jenis_kelamin,
                    'no_anggota'=>$no_anggota,
                    //'user'=>$kolektor
                );
                $save = $this->anggotamodel->addCalonAnggota($data_anggota);
                
                if($save){
                    //
                    $data_pengajuan = array(
                        'id_anggota'=>$no_anggota,
                        'jenis_pinjaman'=>$id,
                        'tgl_pengajuan'=>$tgl,
                        'jumlah'=>$jumlah_pinjaman,
                        'status'=>0,
                        'no_anggota'=>$no_anggota,
                        'jaminan'=>$jaminan,
                        'photo'=>$photo_jaminan,
                        'bukti_pembayaran'=>$photo_bukti,
                        'user'=>$kolektor
                    );
                    $save_pengajuan = $this->pengajuannmodel->insert($data_pengajuan);
                }
            }else{
                $anggota = $this->anggotamodel->where('id',$id)->first();
                $no_anggota = $this->request->getVar('kode_anggota');
                //check data pinjaman 
                $modelpinjaman = new Datapinjamanmodel();
                $datapinjaman_anggota = $modelpinjaman->where('id_anggota',$no_anggota)->where('status',1)->orderby('sisa_pinjaman','DESC')->first();
                if($datapinjaman_anggota){
                    //echo json_encode($datapinjaman_anggota);
                    if($datapinjaman_anggota['sisa_pinjaman']){
                        if(floor(($datapinjaman_anggota['sisa_pinjaman']/$datapinjaman_anggota['jumlah_pokok']))>3){
                            session()->setFlashdata('error','Anggota ini masih memiliki pinjaman diatas 3x angsuran, cek kembali ');
                            return redirect('pengajuanpinjaman');
                        }
                    }
                }else{
                    $totalpinjamaaktif=0;
                }
                if($no_anggota){
                    $jaminan = $this->request->getVar('jaminan');
                    $data_pengajuan = array(
                        'id_anggota'=>$no_anggota,
                        'jenis_pinjaman'=>$id,
                        'tgl_pengajuan'=>$tgl,
                        'jumlah'=>$jumlah_pinjaman,
                        'jaminan'=>$jaminan,
                        'status'=>0,
                        'photo'=>$photo_jaminan,
                        'bukti_pembayaran'=>$photo_bukti,
                        'user'=>$kolektor
                    );
                    $save_pengajuan = $this->pengajuannmodel->insert($data_pengajuan);
                }
            }
            if($save_pengajuan){
                session()->setFlashdata('success','Data berhasil disimpan');
                return redirect('pengajuanpinjaman');
            }else{
                session()->setFlashdata('error','Data gagal disimpan');
                return redirect('pengajuanpinjaman');
            }
        }else{
            $error=1;
            session()->setFlashdata('error',$this->validator->listErrors());
            return redirect('pengajuanpinjaman');
        }
        
    }

    public function editstatuspengajuan(){
        $modelpinjaman = new Datapinjamanmodel();
        if(session('userlevel')!=4 && session('userlevel')!=3 && session('userlevel')!=6){
            return redirect('pencairanpinjaman');
        }

        $id = $_GET['id'];
        
        //echo json_encode($results_biaya);
        //$data['detail']=$this->pengajuannmodel->getdatapengajuandetail($id);
        $detail = $this->pengajuannmodel->getdatapengajuandetail($id);
        $results_biaya = $this->biayapinjamanmodel->where('id_pinjaman',$detail->jenis_pinjaman)->findAll();
        $lastpinjaman = $modelpinjaman->getlastpinjaman($detail->id_anggota);
        $data = array(
            'id'=>$id,
            'detail'=>$detail,
            'results_biaya'=>$results_biaya,
            'lastpinjaman'=>$lastpinjaman
        );

        //echo json_encode($detail);

        if(session('userlevel')!=0){
            return view('main/editstatus',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function simpantolakpengajuan(){
        $id = $this->request->getVar('id_data');
        if($id){
            $alasan = $this->request->getVar('alasan');
            $data = array(
                'keterangan'=>$alasan,
                'status'=>-1
            );
            /*
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

            //delete neraca 
            $this->neracamodel->where('id_transaksi',$result['id_transaksi'])->delete();

            //delete anggsuran
            $this->datapinjamanmodel->deleteanggsuran($result['id']);

            //delete mutasipinjaman
            $this->datapinjamanmodel->deletemutasi($result['id']);
            */
            $save = $this->pengajuannmodel->update($id,$data);
            if($save){
                session()->setFlashdata('success','Data berhasil disimpan');
                return redirect('datapengajuan');
            }else{
                session()->setFlashdata('error','Data gagal disimpan');
                return redirect('datapengajuan');
            }
        }
    }

    public function terimapengajuan(){
        $id = $_GET['id'];
        $result_kas_akun = $this->akunmodel->where('no_akun','01.01')->first();
        $data_akun_kas = $this->akunmodel->where('sub_account',$result_kas_akun['id'])->findAll();
        $data['result_akun']=$data_akun_kas;
        $data['id_data']=$id;
        $data['kolektors']=$this->usermodel->where(array('userlevel'=>2,'status'=>1))->findAll();
        if(session('userlevel')!=0){
            return view('main/terimapengajuan',$data);
        }else{
            return view('member/terimapengajuan',$data);
        }
    }

    public function ceksaldo(){
        //$akun = $this->request->getVar('akun');
        $akun = $_GET['akun'];
        $ceksaldo = $this->pengajuannmodel->ceksaldoakun($akun);
        
        if($ceksaldo){
            if($ceksaldo->balance){
                $error=0;
                $balance = $ceksaldo->balance;
            }else{
                $error=1;
                $balance=0;
            }
            
        }else{
            $error=1;
            $balance=0;
        }
        $data = array(
            'error'=>$error,
            'balance'=>$balance
        );
        echo json_encode($data);
    }

    public function pinjamanawal(){
        $data['id'] = $this->request->getVar('id');
        $result2 = $this->setuppinjamanmodel->orderBy('id','DESC')->findAll();
        $data['results2']=$result2;
        $data['row']=$this->setuppinjamanmodel->where('id',$data['id'])->first();
        $data['rowbiaya']=$this->biayapinjamanmodel->where('id_pinjaman',$data['id'])->findAll();
        //$result_kas_akun = $this->akunmodel->where('no_akun','01.01')->first();
        //$data_akun_kas = $this->akunmodel->where('sub_account',$result_kas_akun['id'])->findAll();
        //$data['result_akun']=$data_akun_kas;
        //$data['anggota']=$this->anggotamodel->findAll();
        if(session('userlevel')!=0){
            return view('main/pinjamanawal',$data);
        }else{
            return view('member/profile',$data);
        }
    }

    public function buktiangsuran(){
        $results = $this->pengajuannmodel->select('tbpengajuanpinjaman.*,tbsetuppinjaman.jenis_pinjaman AS type,tbsetuppinjaman.bunga,tbsetuppinjaman.jangka,tbanggota.no_anggota,tbanggota.nama,tbanggota.alamat,tbanggota.no_telp')->join("tbanggota","tbanggota.no_anggota=tbpengajuanpinjaman.id_anggota")->where('tbpengajuanpinjaman.status',0)->join('tbsetuppinjaman','tbsetuppinjaman.id=tbpengajuanpinjaman.jenis_pinjaman')->findAll();
        //echo json_encode($results);
        $profile = $this->profilemodel->first();
        $data = array(
            'results'=>$results,
            'profile'=>$profile
        );
        return view('print/print-angsuran',$data);
    }

    function savedetail(){
        $upload = NEW Uploadkit();
        $model=new Pengajuandetailmodel();
        date_default_timezone_set('Asia/Singapore');
        $id_pengajuan = $this->request->getVar('id_pengajuan');
        
        if($id_pengajuan){
            $photo = $this->request->getVar('photo');
            $lokasi = $this->request->getVar('lokasi');
            $uppath2 = WRITEPATH . 'uploads/'.$photo;
            $photo_bukti = $upload->uploaddata($uppath2,$photo,'Datapengajuan');
            unlink($uppath2);
            $datadetail = array(
                'created_at'=>date("Y-m-d H:i:s"),
                'id_pengajuan'=>$id_pengajuan,
                'photo'=>$photo,
                'lokasi'=>$lokasi,
                'user'=>session('username')
            );
            if($model->insert($datadetail)){
                //update data pengajuan
                $data = array(
                    'status'=>0,
                    'detailstatus'=>1
                );
                if($this->pengajuannmodel->update($id_pengajuan,$data)){
                    session()->setFlashdata('success','Data berhasil disimpan');
                    return redirect()->back();
                }
            }
        }
    }
}
?>