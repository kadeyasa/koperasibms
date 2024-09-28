<table class="table align-middle table-row-dashed fs-6 gy-5" id="data-tagihan" border="1">
    <tr>
        <td><strong>URAIAN</strong></td>
        <td><strong>DEBET</strong></td>
        <td><strong>KREDIT</strong></td>
        <td><strong>BALANCE</strong></td>
    </tr>
    <?php
        $totalsaldo = 0; 
        $total_tagihan_hari_ini =0;
        $total_balance = array();
        $akun_akhir = $data_akun;
        foreach($data_akun as $akun){
            //check saldo last
            $balance = $model->where('kode_akun',$akun['no_akun'])->orderby('id','DESC')->first();
            if($balance){
                $totalsaldo=$totalsaldo+$balance['debet'];
            }
        ?>
        <tr>
            <td>
                <?php echo $akun['no_akun'].' '.$akun['account_name'];?>
            </td>
            <td align="right">
                <?php 
                    if($balance){
                        echo number_format($balance['debet'],2,",",".");
                        $debet = $balance['debet'];
                    }else{
                        echo number_format(0,2,",",".");
                        $debet = 0;
                    }
                    
                ?>
            </td>
            <td align="right">
                <?php 
                    if($balance){
                        echo number_format($balance['kredit'],2,",",".");
                        $kredit = $balance['kredit'];
                    }else{
                        echo number_format(0,2,",",".");
                        $kredit=0;
                    }
                    
                ?>
            </td>
            <td>
                <?php 
                    $balance = $debet-$kredit;
                    $total_balance[$akun['id']]=$balance;
                ?>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr style="background:#ccc;">
        <td>
            <strong>TOTAL KAS AWAL</strong>
        </td>
        <td align="right"><strong><?php echo number_format($totalsaldo,2,",",".");?></strong></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4"><strong>DATA SETORAN</strong></td>
    </tr>
    <?php 
        //kolektors checks 
        foreach($kolektors as $kolektor){
            ?>
            <tr style="background:#ccc;">
                <td>KOLEKTOR</td>
                <td colspan="3"><strong><?php echo $kolektor['username'];?></strong></td>
            </tr>
            
            <tr>
                <td colspan="4">TITIPAN</td>
            </tr>
            <?php
            $total_titipan_kredit =array();
            $_total_tunai_kolektor = array();
            $_balance_titipan = array();
            $_balance_tagihan = array();
            foreach($data_akun as $akun){
                //tagihan per account 
                ?>
                <tr>
                    <td style="padding-left:20px;">-<?php echo $akun['account_name'];?></td>
                    <td style="padding-left:20px;" align="right">
                        <?php 
                            $titipan_debet = $model->getTitipanByAkun($kolektor['username'],$akun['no_akun'],date('Y-m-d'),date('Y-m-d'),'debet')->debet;
                            $titipan_kredit = $model->getTitipanByAkun($kolektor['username'],$akun['no_akun'],date('Y-m-d'),date('Y-m-d'),'kredit')->kredit;
                            if($titipan_debet!=NULL){
                                echo number_format($titipan_debet,2,",",".");
                                if(in_array($akun['id'],$_total_tunai_kolektor)){
                                    $_total_tunai_kolektor[$akun['id']]=$_total_tunai_kolektor[$akun['id']]+$titipan_debet;
                                }else{
                                    $_total_tunai_kolektor[$akun['id']]=$titipan_debet;
                                }
                            
                            }else{
                                echo number_format(0,2,",",".");
                            } 
                        ?>
                    </td>
                    <td align="right">
                            <?php 
                                if($titipan_kredit!=NULL){
                                    if(in_array($akun['id'],$total_titipan_kredit)){
                                        $total_titipan_kredit[$akun['id']]=$total_titipan_kredit[$akun['id']]+$titipan_kredit;
                                    }else{
                                        $total_titipan_kredit[$akun['id']]=$titipan_kredit;
                                    }
                                    echo number_format($titipan_kredit,2,",",".");
                                }else{
                                    echo number_format(0,2,",",".");
                                } 
                            ?>
                    </td>
                    <td align="right">
                        <?php 
                        if($titipan_debet!=NULL){
                            echo number_format($titipan_debet,2,",",".");
                            $_balance_titipan[$akun['id']]=$titipan_debet;
                            //$total_balance[$akun['id']]=$total_balance[$akun['id']]+$titipan_debet;
                        }else{
                            echo number_format(0,2,",",".");
                            $_balance_titipan[$akun['id']]=0;
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="3">TAGIHAN</td>
            </tr>
            <?php
            
            foreach($data_akun as $akun){
                //tagihan per account 
                $tagihan_kolektor = $model->getTagihanByAkun($kolektor['username'],$akun['no_akun'],date('Y-m-d'),date('Y-m-d'));
                ?>
                <tr>
                    <td style="padding-left:20px;">-<?php echo $akun['account_name'];?></td>
                    <td align="right">
                        <?php
                            if($tagihan_kolektor->totaltagihan!=NULL){
                                echo number_format($tagihan_kolektor->totaltagihan,2,",",".");
                                $b =$tagihan_kolektor->totaltagihan;
                            }else{
                                echo number_format(0,2,",",".");
                                $b =0;
                            } 
                        ?>
                    </td>
                    <td align="right">
                        <?php 
                            //echo $akun['id'];
                            if(isset($total_titipan_kredit[$akun['id']])){
                                echo number_format($total_titipan_kredit[$akun['id']],2,",",".");
                            }else{
                                echo number_format(0,2,",",".");
                            }
                        ?>
                    </td>
                    <td align="right">
                        <?php 
                            if(isset($total_titipan_kredit[$akun['id']])){
                                $b = $tagihan_kolektor->totaltagihan-$total_titipan_kredit[$akun['id']];
                            }
                            $b = $b+$_balance_titipan[$akun['id']];
                            $total_balance[$akun['id']]=$total_balance[$akun['id']]+$b;
                            echo '<b>'.number_format($b,2,",",".").'</b>';
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            
            <?php
        }
    ?>
    <tr style="background:#ccc;">
        <td>
            <strong>TOTAL TAGIHAN HARI INI</strong>
        </td>
        <td align="right" colspan="3">
            <?php 
                $totaltaghian_harian = $model->getTotalTagihanHarian();
            ?>
            <strong><?php echo number_format($totaltaghian_harian->totaltagihan,2,",",".");?></strong>
        </td>
        
    </tr>
    <tr style="background:#ccc;">
        <td>
            <strong>TOTAL TAGIHAN BULAN INI</strong>
        </td>
        <td align="right" colspan="3">
            <?php 
                $totaltaghian = $model->getTotalTagihanBulan();
            ?>
            <strong><?php echo number_format($totaltaghian->totaltagihan,2,",",".");?></strong>
        </td>
        
    </tr>
    <tr>
        <td>
            <strong>PENDAPATAN SISA ANGSURAN PENCAIRAN</strong>
        </td>
        <td align="right">
            <?PHP 
                $start = date("Y-m-d");
                $end = date("Y-m-d 23:59:59");
                $totalpendapatan = $model->getTotalTagihanHarianPelunasan();
                if($totalpendapatan->totaltagihan!=NULL){
                    echo number_format($totalpendapatan->totaltagihan,2,",",".");
                }else{
                    echo number_format(0,2,",",".");
                }
                $pendapatan_cair = $totalpendapatan->totaltagihan;
            ?>
        </td>
        <td>
            
        </td>
        <td>
            
        </td>
    </tr>
    <tr>
        <td>
            <strong>PENDAPATAN</strong>
        </td>
        <td align="right">
            <?PHP 
                $start = date("Y-m-d");
                $end = date("Y-m-d 23:59:59");
                $totalpendapatan = $model->getTotalPendapatan($start,$end);
                if($totalpendapatan->total!=NULL){
                    echo number_format($totalpendapatan->total,2,",",".");
                }else{
                    echo number_format(0,2,",",".");
                }
                
            ?>
        </td>
        <td>
            
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <strong>PENGELUARAN</strong>
        </td>
        <td>
            
        </td>
        <td align="right">
            <?PHP 
                $start = date("Y-m-d");
                $end = date("Y-m-d 23:59:59");
                $totalpengeluaran = $model->getTotalPenngeluaran($start,$end);
                if($totalpengeluaran->total!=NULL){
                    echo number_format($totalpengeluaran->total,2,",",".");
                }else{
                    echo number_format(0,2,",",".");
                }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4">
            <strong>DATA PENCAIRAN</strong>
        </td>
    </tr>
    <?PHP 
        $start = date("Y-m-d");
        $end = date("Y-m-d 23:59:59");
        $datas = $model->getPencairan($start,$end);
        $totalpencairan = 0;
        foreach($datas as $row){
            $totalpencairan=$totalpencairan+$row->jumlah;
    ?>
    <tr>
        <td>
            <?php echo $row->id_anggota;?>
        </td>
        <td></td>
        <td><?php echo number_format($row->jumlah,2,",",".");?></td>
    </tr>
    <?php 
        }
    ?>
        <tr>
        <td colspan="4">
            <strong>SALDO AKHIR</strong>
        </td>
    </tr>
    <?PHP 
        
        foreach($akun_akhir as $_akun){
            if($_akun['no_akun']=='01.01.110-40'){
                $total_balance[$_akun['id']] = $total_balance[$_akun['id']]-$totalpencairan-$totalpengeluaran->total+$totalpendapatan->total+$pendapatan_cair;
            }
    ?>
    <tr>
        <td>
                <?php echo $_akun['no_akun'].' - '.$_akun['account_name'];?>
        </td>
        <td></td>
        <td></td>
        <td align="right"><?php echo number_format($total_balance[$_akun['id']]);?></td>
    </tr>
    <?php 
        }
    ?>
</table>
<script>
    window.print();
</script>
