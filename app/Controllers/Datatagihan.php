<?php 
    namespace App\Controllers;

    use App\Models\Datapinjamanmodel;

    use App\Models\Usermodel;

    class Datatagihan extends BaseController
    {
        public function __construct(){
            $this->usermodel=new Usermodel();
            $this->datapinjamanmodel=new Datapinjamanmodel();
            helper('form');
        }

        public function getTagihanMingguan(){
            $pager = \Config\Services::pager();
            if(isset($_GET['kolektor'])){
                $kolektor=$_GET['kolektor'];
            }else{
                $kolektor='';
            }
            if(isset($kolektor) && $kolektor!=''){
                $cari_data = $_GET['cari_data'];
                $keyword = $_GET['keyword'];
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
                'nama_pinjaman'=>'Mingguan'
            );
            return view('main/data-tagihan',$data);
        }
    }
?>