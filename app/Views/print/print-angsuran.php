<table width="100%">

    <tr>
    <?php 
        $i=0;
        foreach($results as $row){
            $i++;
        ?>

        <td width="50%" valign="top">
            <table width="100%" align="center" style="border:1px solid #ccc;" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="50">
                        <img src="assets/media/logos/koperasi-logo.png" width="50">
                    </td>
                    <td> <b style="font-size:20px;"><?php echo $profile['nama'];?></b></td>
                </tr>
                <tr>
                    <td width="100%" colspan="2">
                        <table align="left">
                            <tr>
                                <td>No Anggota</td>
                                <td>:</td>
                                <td><?php echo $row['no_anggota'];?></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><?php echo $row['nama'];?></td>
                            </tr>
                            <tr>
                                <td>No Telp</td>
                                <td>:</td>
                                <td><?php echo $row['no_telp'];?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><?php echo $row['alamat'];?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%" align="center" cellpadding="5" cellspacing="0">
                            <tr>
                                <td colspan="7" align="center"><b>INFORMASI ANGSURAN</b></td>
                            </tr>
                            <tr>
                                <td width="10" style="border:1px solid #333;" align="center"><b>No</b></td>
                                <td width="50" style="border:1px solid #333;" align="center"><b>Tgl</b></td>
                                <td style="border:1px solid #333;" align="center"><b>Total Angsuran</b></td>
                                <td style="border:1px solid #333;" align="center"><b>Tgl Bayar</b></td>
                                <td style="border:1px solid #333;" align="center"><b>Paraf</b></td>
                            </tr>
                            <?php 
                                $jangka = $row['jangka'];
                                $tgl = $row['tgl_pengajuan'];
                                if($row['type']=='1'){
                                    $tambah=1;
                                }
                                if($row['type']=='2'){
                                    //mingguan
                                    $tambah=7;
                                }
                                if($row['type']=='3'){
                                    //bulanan
                                    $tambah=30;
                                }
                                if($row['type']=='4'){
                                    //kondisional
                                    $tambah=30;
                                }
                                $tambah2=0;
                                $jangka=$jangka+1;
                                for($j=2;$j<=$jangka;$j++){
                                    if($tambah2==0){
                                        $tambah2=$tambah;
                                    }
                                    $tgl2    = date('Y-m-d', strtotime('+'.$tambah2.' days', strtotime($tgl)));
                                    $pokok = $row['jumlah']/$row['jangka'];
                                    $bunga = $row['jumlah']*$row['bunga']/100;
                                    $angsuran = $pokok+$bunga;
                                    ?>
                                    <tr>
                                        <td width="10" style="border:1px solid #333;" align="center"><?php echo $j-1;?></td>
                                        <td width="100" style="border:1px solid #333;" align="center"><?php echo $tgl2;?></td>
                                        <td style="border:1px solid #333;" align="center"><?php echo number_format($angsuran);?></td>
                                        <td style="border:1px solid #333;" align="center"></td>
                                        <td style="border:1px solid #333;" align="center"></td>
                                    </tr>
                                    <?php
                                    $tambah2 = $tambah*$j;
                                }
                            ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <?php 
            if($i%2==0){
                echo '</tr><tr>';
            }
        ?>
<?php } ?>
        </table>
<script type="text/javascript">
    window.print();
</script>