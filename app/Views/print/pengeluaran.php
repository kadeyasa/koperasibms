    <center>
        <h5 style="font-family:arial; font-size:13px;">Data Pengeluaran / Tgl Cetak :<?php echo date('d-m-Y');?></h5>
    </center>
    <table width="100%" align="center" style="border:1px solid #ccc;" cellpadding="5" cellspacing="0">
																			<!--begin::Table head-->
																			<thead>
																				<!--begin::Table row-->
																				<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																					
                                                                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																					<th class="w-125px pe-2" style="font-family:arial; border:1px solid #000; font-size:11px;">
                                                                                    Tgl
																					</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Uraian</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Jumlah</th>
																				</tr>
																					
																				</tr>
																				<!--end::Table row-->
																			</thead>
																			<!--end::Table head-->
																			<!--begin::Table body-->
																			<tbody class="fw-semibold text-gray-600">
																				<?php 
                                                                                    $total=0;
                                                                                    foreach($results as $row){
                                                                                        $total=$total+$row['jumlah'];
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row['tgl'];?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row['uraian'];?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($row['jumlah']);?></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    //$total = $total_pokok+$total_bunga;
                                                                                ?>
                                                                                <tr>
                                                                                    <td colspan="2" style="font-family:arial; border:1px solid #000; font-size:11px;">Total</td>
                                                                                    <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($total);?></td>
                                                                                    
                                                                                </tr>
																			</tbody>
																			<!--end::Table body-->
																		</table>
																		<!--end::Table-->
<script type="text/javascript">
window.print();
</script>