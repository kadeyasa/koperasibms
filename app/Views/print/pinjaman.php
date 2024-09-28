<table width="80%" align="center" style="border:1px solid #ccc;" cellpadding="5" cellspacing="0">
    <tr>
        <td width="50">
            <img src="assets/media/logos/koperasi-logo.png" width="50">
        </td>
        <td valign="center" align="left" style="font-family:arial;"><b><?php echo $profile['nama'];?></b></td>
        <td width="600">
            <table align="left">
                <tr>
                    <td>No Anggota</td>
                    <td>:</td>
                    <td><?php echo $detail->no_anggota;?></td>
                </tr>
                <tr>
                    <td>No Pinjaman</td>
                    <td>:</td>
                    <td><?php echo $detail->rek_pinjaman;?></td>
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
            </table>
        </td>
    </tr>
    
</table>
<br/>
<table width="80%" align="center" style="border:1px solid #ccc;" cellpadding="5" cellspacing="0">
<?php 
    $totalbunga = ($detail->bunga*$detail->jangka)/100;
    $totalbunga_idr = $totalbunga * $detail->jumlah;
    $pokok = $detail->jumlah/$detail->jangka;
    $total_angsuran = ($totalbunga_idr+$detail->jumlah)/$detail->jangka;
    $bunga_angsuran = $totalbunga_idr/$detail->jangka;
?>
    <tr>
        <td>
            <table>
                <tr>
                    <td colspan="3"><b>Info Pinjaman</b></td>
                </tr>
                <tr>
                    <td>Total Pinjaman</td>
                    <td>:</td>
                    <td>Rp.<?php echo number_format($detail->jumlah);?></td>
                </tr>
                <tr>
                    <td>Jangka Waktu</td>
                    <td>:</td>
                    <td><?php echo number_format($detail->jangka);?> Kali</td>
                </tr>
                <tr>
                    <td>Angsuran Pokok</td>
                    <td>:</td>
                    <td>Rp.<?php echo number_format($pokok);?></td>
                </tr>
                <tr>
                    <td>Bunga Angsuran</td>
                    <td>:</td>
                    <td>Rp.<?php echo number_format($bunga_angsuran);?></td>
                </tr>
                <tr>
                    <td>Total Angsuran</td>
                    <td>:</td>
                    <td>Rp.<?php echo number_format($total_angsuran);?></td>
                </tr>
            </table>
        </td>
        <td valign="top">
            <table>
                <tr>
                    <td colspan="3"><b>Info Biaya</b></td>
                </tr>
                <?php
                    $total_biaya=0; 
                    $biaya=0;
                    foreach($results_biaya as $row){
                       
                        if($row['jenis_biaya']==1){
                            $biaya = $row['jumlah']/100*$detail->jumlah;
                        }else{
                            $biaya=$row['jumlah'];
                        }
                        $total_biaya=$total_biaya+$row['jumlah'];
                ?>
                <tr>
                    <td><?php echo $row['nama_biaya'];?></td>
                    <td>:</td>
                    <td align="right">Rp.<?php echo number_format($biaya);?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="3"><hr/></td>
                </tr>
                <tr>
                    <td><b>Total Biaya</b></td>
                    <td><b>:</b></td>
                    <td align="right"><b>Rp.<?php echo number_format($total_biaya);?></b></td>
                </tr>
                <tr>
                    <?php 
                        $total_pencairan = $detail->jumlah-$total_biaya;
                    ?>
                    <td><b>Total Pencairan</b></td>
                    <td><b>:</b></td>
                    <td align="right"><b>Rp.<?php echo number_format($total_pencairan);?></b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br/>
<table width="80%" align="center" cellpadding="5" cellspacing="0">
    <tr>
        <td colspan="7" align="center"><b>INFORMASI ANGSURAN</b></td>
    </tr>
    <tr>
        <td width="10" style="border:1px solid #333;" align="center"><b>No</b></td>
        <td width="50" style="border:1px solid #333;" align="center"><b>Tgl</b></td>
        <td style="border:1px solid #333;" align="center"><b>Jumlah Pokok</b></td>
        <td style="border:1px solid #333;" align="center"><b>Bunga</b></td>
        <td style="border:1px solid #333;" align="center"><b>Total Angsuran</b></td>
        <td style="border:1px solid #333;" align="center"><b>Status</b></td>
        <td style="border:1px solid #333;" align="center"><b>Tgl Bayar</b></td>
    </tr>
    <?php 
        $no=0;
        foreach($results_angsuran as $angsuran){
            $no++;
            ?>
            <tr>
                <td width="10" style="border:1px solid #333;" align="center"><?php echo $no;?></td>
                <td width="20%" style="border:1px solid #333;" align="center"><?php echo date('d F Y', strtotime($angsuran->tgl));?></td>
                <td style="border:1px solid #333;" align="right">Rp. <?php echo number_format($angsuran->jumlah_pokok);?></td>
                <td style="border:1px solid #333;" align="right">Rp. <?php echo number_format($angsuran->jumlah_bunga);?></td>
                <td style="border:1px solid #333;" align="right">Rp. <?php echo number_format($angsuran->jumlah_pokok+$angsuran->jumlah_bunga);?></td>
                <td style="border:1px solid #333;" align="center">
                    <?php echo $angsuran->status?'Sudah Bayar':'Belum Bayar';?>
                </td>
                <td style="border:1px solid #333;" align="center"><?php echo $angsuran->tgl_bayar;?></td>
            </tr>
            <?php
        }
    ?>
</table>
<script type="text/javascript">
    window.print();
</script>