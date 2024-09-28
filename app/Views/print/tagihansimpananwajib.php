<center>
    <h4>Data Tagihan Simpanan Wajib bulan <?php echo check_bulan($bulan);?> <?php echo $tahun;?></h4>
</center>
<table width="80%" align="center" style="border:1px solid #ccc;" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>No Anggota</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Jumlah</th>
    </tr>
    <?php 
        $i=0;
        $total=0;
        foreach($results as $row){
            $i++;
            if($row->debet==NULL){
                $total = $total+$info['iuran_wajib'];
                ?>
                <tr>
                    <td align="center"><?php echo $i;?></td>
                    <td align="center"><?php echo $row->no_anggota;?></td>
                    <td align="center"><?php echo $row->nama;?></td>
                    <td align="center"><?php echo $row->alamat;?></td>
                    <td align="center"><?php echo number_format($info['iuran_wajib']);?></td>
                </tr>
                <?php
            }
        }
    ?>
    <tr>
        <td colspan="4"><center><b>Total</b></center></td>
        <td colspan="" align="center"><b><?php echo number_format($total);?></b></td>
    </tr>
</table>