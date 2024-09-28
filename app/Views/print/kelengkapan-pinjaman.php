<table width="80%" align="center"  cellpadding="5" cellspacing="0" style="page-break-before: always">
    <tr>
        <td width="50">
            <img src="assets/media/logos/header-koperasi.png" width="100%">
        </td>
        
    </tr>
    
</table>
<br/>
<table width="80%" align="center"  cellpadding="5" cellspacing="0">
    <tr>
        <td style="padding-left:30px;">
            Saya yang bertandatangan dibawah ini :
            <br/><br/>
            <table align="left" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td><?php echo $detail->nik;?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?php echo $detail->nama;?></td>
                </tr>
                <tr>
                    <td>No Telp</td>
                    <td>:</td>
                    <td><?php echo $detail->no_telp;?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?php echo $detail->alamat;?></td>
                </tr>
                <tr>
                    <td><br/></td>
                    
                </tr>
            </table>
            <br/><br/>
            Bahwa saya mengajukan diri menjadi anggota / calon anggota Koperasi Konsumen Bhakti Mulia Shanti <br/><br/>

            - Bersedia menjalankan kewajiban sebagai anggota  / calon anggota  dengan membayar simpanan pokok sebesar Rp.200.000 bisa di angsur maksimal 8 ( Delapan ) kali anggsuran atau selambat - lambatnya  3 ( Tiga ) bulan.<br/>

            - Bersedia membayar simpanan wajib Rp.10.000 setiap bulan<br/>

            - Bersedia mengikuti AD/ART<br/><br/>

            Dengan bersedianya menjalankan kewajiban sebagai anggota  / calon anggota  berhak mendapatkan pelayanan sewajarnya dari Koperasi Konsumen Bhakti Mulia Shanti. 
            <div align="right">
                    <br/>
                    JEMBRANA,   <?php echo  date("d F Y")?> 

                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <?php echo $detail->nama;?>
            </div>
        </td>
    </tr>
</table>
<br/>



<table width="80%" align="center"  cellpadding="5" cellspacing="0" style="page-break-before: always">
    <tr>
        <td width="50">
            <img src="assets/media/logos/header-koperasi.png" width="100%">
        </td>
        
    </tr>
    <tr>
        <td width="50" align="center">
            NO SURAT : <?php echo $detail->id;?>/BMS /  <?php echo date('d');?> / <?php echo date('m');?>  /<?php echo date('y');?>
        </td>
    </tr>
</table>
<br/>
<table width="80%" align="center"  cellpadding="5" cellspacing="0">
    <tr>
        <td style="padding-left:30px;">
            Yang bertanda tangan di bawah ini :  :
            <br/><br/>
            PIHAK PERTAMA<br/>
            <table align="left" cellpadding="5" cellspacing="0" width="100%">
                
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>I KADE YASA</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>LINGKUNGAN DEWASANA, PENDEM, JEMBRANA - BALI</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Manajer <?php echo $profile['nama'];?></td>
                </tr>
                <tr>
                    <td><br/></td>
                    
                </tr>
            </table>
            <br/><br/>
            PIHAK KEDUA<br/>
            <table align="left" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td><?php echo $detail->nik;?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?php echo $detail->nama;?></td>
                </tr>
                <tr>
                    <td>No Telp</td>
                    <td>:</td>
                    <td><?php echo $detail->no_telp;?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?php echo $detail->alamat;?></td>
                </tr>
                <tr>
                    <td><br/></td>
                    
                </tr>
            </table>
            <br/><br/>
            <?php 
                use App\Models\Datapinjamanmodel;
                $this->datapinjamanmodel=new Datapinjamanmodel();
            ?>
            Dengan ini menyatakan<br/>
            <div style="text-align:justify;">
                <ul>
                    <li>
                        Bahwa benar pada tanggal,  <?php echo  date("d F Y",strtotime($detail->tgl_pengajuan))?>   ,Pihak kedua meminjam uang sebesar <?php echo number_format($detail->jumlah);?> 
                        <br/>
                    </li>
                    <li>
                        Pihak kedua berjanji akan mengembalikan kepada pihak pertama uang tersebut selama  <?php echo $detail->jangka;?> ANGSURAN  Rp.<?php echo number_format(($detail->jumlah/$detail->jangka)+($detail->jumlah*$detail->bunga/100));?>
                Apabila pihak kedua mengingkari dan tidak bisa mengembalikan uang tersebut sesuai kesepakatan tanggal di atas saya pihak kedua siap menerima sanksi dari pihak pertama.
                <br/>        
            </li>
                    <li>
                            Pihak kedua siap menyerahkan barang dan jaminan berupa <b><?php echo $detail->jaminan;?></b> ke pihak koperasi atau melelang barang usaha yang dimiliki sesuai jumlah pinjaman.
                            Apabila barang jaminan yang diserahkan kepada koperasi masih dalam kredit bukan menjadi tanggung jawab koperasi.
                            <br/>
                    </li>
                    </ul>
                <br/>
                Detail Pinjaman : 
                <table width="100%;">
                    <tr>
                        <td>Jumlah Pinjaman</td>
                        <td><?php echo number_format($detail->jumlah);?></td>
                        <td>&nbsp;</td>
                    </tr>

                    <?php 
                        $total=0;
                        //check biaya
                        foreach($results_biaya as $row){
                            if($row['jenis_biaya']==1){
                                $row['jumlah']=$row['jumlah']/100*$detail->jumlah;
                            }
                    ?>
                    <tr>
                        <td><?php echo $row['nama_biaya'];?></td>
                        <td></td>
                        <td><?php echo number_format($row['jumlah']);?></td>
                    </tr>
                    <?php 
                            $total=$total+$row['jumlah'];
                        }
                    ?>
                    <?php 
                        //check biaya
                        if($lastpinjaman){
                            ?>
                        <tr>
                            <td colspan="3">Sisa Pinjaman</td>
                        </tr>
                        <?php
                        foreach($lastpinjaman as $pinjaman){
                                if($pinjaman->status==0){
                        ?>
                        <tr>
                            <td><?php echo $pinjaman->tgl;?></td>
                            <td></td>
                            <td><?php echo number_format(($pinjaman->jumlah_pokok+$pinjaman->jumlah_bunga));?></td>
                        </tr>
                        <?php 
                                    $subtotal = $pinjaman->jumlah_pokok+$pinjaman->jumlah_bunga;
                                    $total=$total+$subtotal;
                                }
                            }
                        }
                    ?>
                    <tr><td colspan="3"><hr/></td></tr>
                    <tr>
                        <td><b>Total Potongan</b></td>
                        <td></td>
                        <td><b><?php echo number_format($total);?></b></td>
                    </tr>
                    <tr>
                        <td><b>Total Pencairan</b></td>
                        <td><b><?php echo number_format($detail->jumlah-$total);?></b></td>
                        <td></td>
                    </tr>
                </table>
                Demikian surat perjanjian ini kami buat dengan sebenar-benarnya tanpa ada unsur paksaan dari 
                kedua belah pihak.  
            </div>
            <table width="100%">
                <tr>
                    <td>
                    <div align="right" width="50%">
                            <br/>
                            PIHAK PERTAMA

                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            I KADE YASA
                    </div>
                    </td>
                    <td>
                    <div align="right">
                            <br/>
                            JEMBRANA,   <?php echo  date("d F Y")?> <br/>
                            PIHAK KEDUA 
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <?php echo $detail->nama;?>
                    </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br/>
<table width="80%" align="center" cellpadding="5" cellspacing="0" style="page-break-before: always">
    <tr>
        <td>
            <table width="100%" style="border:2px dotted #333;">
                <tr>
                    <td colspan="3" align="center"><h2>KWITANSI</h2><hr/></td>
                </tr>
                <tr>
                    <td width="200">No</td>
                    <td width="50">:</td>
                    <td><?='PJM'.sprintf("%05s", $_GET['id']);?></td>
                </tr>
                <tr>
                    <td>Telah Terima Dari</td>
                    <td>:</td>
                    <td>Kopmen Bhakti Mulia Shanti</td>
                </tr>
                <tr>
                    <td>Untuk Sejumlah</td>
                    <td>:</td>
                    <td><i>#
                            <?php if($detail->jumlah!='1500000' && $detail->jumlah!='2500000')
                                    {
                                        echo ucwords(penyebut($detail->jumlah)).' Rupiah'; 
                                    }else{
                            			if($detail->jumlah=='1500000'){
                                        	echo 'Satu Juta Lima Ratus Ribu Rupiah';
                                        }
                            			if($detail->jumlah=='2500000'){
                                        	echo 'Dua Juta Lima Ratus Ribu Rupiah';
                                        }
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    }
                                    ?> #</i></td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran</td>
                    <td>:</td>
                    <td>Pinjaman di Koperasi Bhakti Mulia Shanti</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="" style="padding-top:10px;padding-bottom:10px;">
                        <h3>Rp. <?php echo number_format($detail->jumlah);?></h3>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="" style="padding-top:10px;padding-bottom:10px;" align="right">
                        <br/>
                        Jembrana, <?php echo date('d F Y');?>
                        <br/><br/><br/><br/>
                        <?=$detail->nama;?>
                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
    <tr>
        <td>
            <table width="100%" style="border:2px dotted #333;">
                <tr>
                    <td colspan="3" align="center"><h2>KWITANSI</h2><hr/></td>
                </tr>
                <tr>
                    <td width="200">No</td>
                    <td width="50">:</td>
                    <td><?=$detail->no_anggota;?></td>
                </tr>
                <tr>
                    <td>Telah Terima Dari</td>
                    <td>:</td>
                    <td><?=$detail->nama;?></td>
                </tr>
                <tr>
                    <td>Untuk Sejumlah</td>
                    <td>:</td>
                    <td><i>#Dua Puluh Lima Ribu Rupiah #</i></td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran</td>
                    <td>:</td>
                    <td>Angsuran I Calon Anggota Kopmen Bhakti Mulia Shanti</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="" style="padding-top:10px;padding-bottom:10px;">
                        <h3>Rp. 25.000,-</h3>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="" style="padding-top:10px;padding-bottom:10px;" align="right">
                        <br/>
                        Jembrana, <?php echo date('d F Y');?>
                        <br/><br/><br/><br/>
                        I KADE YASA
                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>
<script type="text/javascript">
    window.print();
</script>

<script type="text/javascript">
    window.print();
</script>