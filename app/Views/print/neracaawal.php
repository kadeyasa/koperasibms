<table width="80%" align="center" style="border:1px solid #ccc;" cellpadding="5" cellspacing="0">
    <tr>
        <th width="300" align="center" style="border:1px solid #ccc;">KODE AKUN</th>
        <th align="center" style="border:1px solid #ccc;">NAMA AKUN</th>
        <th align="center" style="border:1px solid #ccc;">JUMLAH</th>
    </tr>
    <?php 
        foreach($results_0 as $row_0){
            $result_2 = $akunmodel->where('sub_account',$row_0['id'])->orderBy('no_akun','ASC')->findAll();
    ?>
    <tr>
        <td align="left" style="border:1px solid #ccc;"><b><?php echo $row_0['no_akun'];?></b></td>
        <td style="border:1px solid #ccc;"><b><?php echo $row_0['account_name'];?></b></td>
        <td style="border:1px solid #ccc;">&nbsp;</td>
            <?php 
                
                if($result_2){
                    
                    echo '</tr>';
                    foreach($result_2 as $row_2){
                        $jumlah = $neracamodel->totalBalance($row_2['no_akun'],$tahun)->getRow();
                        $result_3 = $akunmodel->where('sub_account',$row_2['id'])->orderBy('no_akun','ASC')->findAll();
                        echo '<tr>
                            <td align="left" style="border:1px solid #ccc;">&nbsp;&nbsp;&nbsp;'.$row_2['no_akun'].'</td>
                            <td align="" style="border:1px solid #ccc;">&nbsp;&nbsp;&nbsp;'.$row_2['account_name'].'</td>
                            <td align="right" style="border:1px solid #ccc;">'.number_format($jumlah->jumlah).'</td>
                            ';
                        if($result_3){
                            echo '</tr>';
                            foreach($result_3 as $row_3){
                                $jumlah2 = $neracamodel->totalBalance($row_3['no_akun'],$tahun)->getRow();
                                echo '<tr>
                                        <td align="left" style="border:1px solid #ccc;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row_3['no_akun'].'</td>
                                        <td align="" style="border:1px solid #ccc;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row_3['account_name'].'</td>
                                        <td align="right" style="border:1px solid #ccc;">'.number_format($jumlah2->jumlah).'</td>
                                      </tr>';
                            }
                        }else{
                            echo '</tr>';
                        }
                        
                    }
                    
                }else{
                    echo '</tr>';
                }
            ?>
    
    <?php 
        }
    ?>
</table>