<?php 
helper('number');
?>
<table width="80%" align="center" style="border:1px solid #ccc;font-size:12px;">
    <tr>
        <td colspan="4" align="center"><h4>KOPERASI BHAKTI MULIA SHANTI</h4></td>
    </tr>
    <tr>
        <td colspan="4" align="center">NERACA PER JANUARI 2023</td>
    </tr>
    <tr>
        <td colspan="4" align="center"><hr/></td>
    </tr>
    <tr>
        <th width="300" align="left">Kode Akun</th>
        <th align="left" width="500">Nama Akun</th>
        <th align="left">Debet</th>
        <th align="left">Kredit</th>
    </tr>
    <?php 
        foreach($results_0 as $row_0){
            $result_2 = $akunmodel->where('sub_account',$row_0['id'])->orderBy('no_akun','ASC')->findAll();
    ?>
    <tr>
        <td align="left"><b><?php echo $row_0['no_akun'];?></b></td>
        <td><b><?php echo $row_0['account_name'];?></b></td>
        <td></td>
        <td></td>
            <?php 
                
                if($result_2){
                    
                    echo '</tr>';
                    foreach($result_2 as $row_2){
                        $result_3 = $akunmodel->getSaldo('2023-01',$row_2['id']);
                        echo '<tr>
                            <td align="left">&nbsp;&nbsp;&nbsp;'.$row_2['no_akun'].'</td>
                            <td align="">&nbsp;&nbsp;&nbsp;'.$row_2['account_name'].'</td>
                            <td align=""></td>
                            <td align=""></td>';
                            
                            
                        if($result_3){
                            echo '</tr>';
                            foreach($result_3 as $row_3){
                                if($row_3->saldo_normal=='K'){
                                    if($row_3->balance<0){
                                        $kredit = $row_3->balance*-1;
                                    }else{
                                        $kredit = $row_3->balance;
                                    }
                                    
                                    $debet=0;
                                }else{
                                    $debet = $row_3->balance;
                                    $kredit=0;
                                }
                                $debet = (int)$debet;
                                $kredit=(int)$kredit;
                                echo '<tr>
                                        <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row_3->no_akun.'</td>
                                        <td align="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row_3->account_name.'</td>
                                        <td align="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.number_format($debet).'</td>
                                        <td align="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.number_format($kredit).'</td>
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