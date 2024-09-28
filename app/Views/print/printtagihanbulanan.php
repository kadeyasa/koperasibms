
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
                                                                                    
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">No Rek Pinjaman</th>
                                                                                    
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Tgl Pencairan</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Kolektor</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">No Anggota</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Nama Anggota</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Alamat</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Jenis Pinjaman</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Jumlah</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Jangka Waktu</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Angsuran</th>
                                                                                    <th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Sisa Pinjaman</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Sisa Angsuran</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Total Tunggakan</th>
																					<th class="min-w-125px" style="font-family:arial; border:1px solid #000; font-size:11px;">Hasil Followup</th>
																				</tr>
																				<!--end::Table row-->
																			</thead>
																			<!--end::Table head-->
																			<!--begin::Table body-->
																			<tbody class="fw-semibold text-gray-600">
																				<?php 
																					$no=0;
                                                                                    foreach($results as $row){
																						$day = date('D', strtotime($row->tgl));
																						$dayList = array(
																							'Sun' => 'Minggu',
																							'Mon' => 'Senin',
																							'Tue' => 'Selasa',
																							'Wed' => 'Rabu',
																							'Thu' => 'Kamis',
																							'Fri' => 'Jumat',
																							'Sat' => 'Sabtu'
																						);
																						$btn='<a href="'.site_url('detailangsuran?id='.$row->id).'" class="" title="Lihat Angsuran"><i class="bi bi-box-arrow-in-up-right" style="font-size:25px;"></i></a>';
																						$no++;
																						$sisa_angsuran = ($row->jumlah_pokok+$row->jumlah_bunga)*$row->totaltunggakan;
																						if($row->totaltunggakan>=3){
																							$bg='red';
																						}else{
																							$bg='white';
																						}
																						?>
																						<tr style="background-color:<?php echo $bg;?>;print-color-adjust: exact;">
																							<td valign="center" align="left" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $no;?></td>
																							<td valign="center" align="left" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->rek_pinjaman;?></td>
                                                                                           
																							<td valign="center" align="left" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $dayList[$day];?>,<?php echo $row->tgl;?></td>
																							<td valign="center" align="left" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->username;?></td>
																							<td valign="center" align="left" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->id_anggota;?></td>
																							<td valign="center" align="left" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->nama;?></td>
																							<td valign="center" align="left" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->alamat;?></td>
																							<td valign="center" align="left" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->nama_simpanan;?></td>
																							<td align="right" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($row->jumlah_pokok);?></td>
																							<td valign="center" align="left" style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->lama_pinjaman;?></td>
																							<td align="right"  style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($row->jumlah_pokok+$row->jumlah_bunga);?></td>
																							<td align="right"  style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($row->sisa_pinjaman);?></td>
																							<td align="right"  style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo number_format($sisa_angsuran);?></td>
																							<td align="center"  style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->totaltunggakan;?></td>
																							<td align="center"  style="background-color:<?php echo $bg;?>;font-family:arial; border:1px solid #000; font-size:11px;"><?php echo $row->followup;?></td>
																						</tr>
																						<?php
																						
                                                                                    }
                                                                                ?>
																			</tbody>
																			<!--end::Table body-->
																		</table>
																		<!--end::Table-->
<script type="text/javascript">
window.print();
</script>