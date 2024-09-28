    <center>
        <h5 style="font-family:arial; font-size:13px;">Tagihan Kolektor :<?php echo session('username');?> / Tgl Cetak :<?php echo date('d-m-Y');?></h5>
    </center>
    <table width="100%" align="center" style="border:1px solid #ccc;" cellpadding="5" cellspacing="0">
																			<!--begin::Table head-->
																			<thead>
																				<!--begin::Table row-->
																				<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																					<th class="w-125px pe-2" style="font-family:arial; border:1px solid #000; font-size:11px;">
																						#
																					</th>
                                                                                    
                                                                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																					<th class="w-125px pe-2" style="font-family:arial; border:1px solid #000; font-size:11px;">
																						#
																					</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">No Anggota</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Nama</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Alamat</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">ID Transaksi</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Tgl Bayar</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Jumlah Pokok</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Jumlah Bunga</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Total</th>
                                                                                    
																				</tr>
																					
																				</tr>
																				<!--end::Table row-->
																			</thead>
																			<!--end::Table head-->
																			<!--begin::Table body-->
																			<tbody class="fw-semibold text-gray-600">
																				<?php 
                                                                                    $no=0;
                                                                                    $sub_total = 0;
                                                                                    $total_pokok=0;
                                                                                    $total_bunga =0;
                                                                                    $total=0;
                                                                                    foreach($results as $row){
                                                                                        $no++;
                                                                                        $sub_total=$row->jumlah_pokok+$row->jumlah_bunga;
                                                                                        $total_pokok = $total_pokok+$row->jumlah_pokok;
                                                                                        $total_bunga = $total_bunga+$row->jumlah_bunga;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $no;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->no_anggota;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->nama;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->alamat;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->id_transaksi;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->tgl_bayar;?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($row->jumlah_pokok);?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($row->jumlah_bunga);?></td>
                                                                                            <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($sub_total);?></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    $total = $total_pokok+$total_bunga;
                                                                                ?>
                                                                                <tr>
                                                                                    <td colspan="6" style="font-family:arial; border:1px solid #000; font-size:11px;">Total</td>
                                                                                    <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($total_pokok);?></td>
                                                                                    <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($total_bunga);?></td>
                                                                                    <td style="font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($total);?></td>
                                                                                </tr>
																			</tbody>
																			<!--end::Table body-->
																		</table>
																		<!--end::Table-->
<script type="text/javascript">
window.print();
</script>