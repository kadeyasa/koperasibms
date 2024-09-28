    <center>
        <h5 style="font-family:arial; font-size:13px;">Jurnal Umum / Tgl Cetak :<?php echo date('d-m-Y');?></h5>
    </center>
    <table width="100%" align="center" style="border:1px solid #ccc;" cellpadding="5" cellspacing="0">
																			<!--begin::Table head-->
																			<thead>
																				<!--begin::Table row-->
																				<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																					
                                                                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																					<th class="w-125px pe-2" style="font-family:arial; border:1px solid #000; font-size:11px;">
                                                                                    Date
																					</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">ID Transaksi</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Kode Akun</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Nama Akun</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Debet</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Kredit</th>
																					
                                                                                    
																				</tr>
																					
																				</tr>
																				<!--end::Table row-->
																			</thead>
																			<!--end::Table head-->
																			<!--begin::Table body-->
																			<tbody class="fw-semibold text-gray-600">
																				<?php 
                                                                                    $total_debet=0;
																					$total_kredit=0;
                                                                                    foreach($results as $row){
                                                                                        $total_debet=$total_debet+$row->debet;
																						$total_kredit=$total_kredit+$row->kredit;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->date;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->id_transaksi;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->kode_akun;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->account_name;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($row->debet);?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($row->kredit);?></td>
                                                                                            
                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    //$total = $total_pokok+$total_bunga;
                                                                                ?>
                                                                                <tr>
                                                                                    <td colspan="4" style="font-family:arial; border:1px solid #000; font-size:11px;">Total</td>
                                                                                    <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($total_debet);?></td>
                                                                                    <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($total_kredit);?></td>
                                                                                    
                                                                                </tr>
																			</tbody>
																			<!--end::Table body-->
																		</table>
																		<!--end::Table-->
<script type="text/javascript">
window.print();
</script>