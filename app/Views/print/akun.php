<table width="80%" align="center" style="border:1px solid #ccc;">
    <tr>
        <th width="300" align="left">Kode Akun</th>
        <th align="left">Nama Akun</th>
    </tr>
    <?php 
        foreach($results_0 as $row_0){
            $result_2 = $akunmodel->where('sub_account',$row_0['id'])->orderBy('no_akun','ASC')->findAll();
    ?>
    <tr>
        <td align="left"><b><?php echo $row_0['no_akun'];?></b></td>
        <td><b><?php echo $row_0['account_name'];?></b></td>
            <?php 
                
                if($result_2){
                    
                    echo '</tr>';
                    foreach($result_2 as $row_2){
                        $result_3 = $akunmodel->where('sub_account',$row_2['id'])->orderBy('no_akun','ASC')->findAll();
                        echo '<tr>
                            <td align="left">&nbsp;&nbsp;&nbsp;'.$row_2['no_akun'].'</td>
                            <td align="">&nbsp;&nbsp;&nbsp;'.$row_2['account_name'].'</td>';
                        if($result_3){
                            echo '</tr>';
                            foreach($result_3 as $row_3){
                                echo '<tr>
                                        <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row_3['no_akun'].'</td>
                                        <td align="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row_3['account_name'].'</td>
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