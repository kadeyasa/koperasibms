<!DOCTYPE html>
<html lang="en">
    <?php 
        include('header.php');
    ?>
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<?php 
                    include('main-header.php');
                ?>
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<?php include('sidebar.php');?>
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Toolbar-->
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<!--begin::Toolbar container-->
								<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										<!--begin::Title-->
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="<?php echo site_url('dashboard');?>" class="text-muted text-hover-primary">Home</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Dashboard</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
								</div>
								<!--end::Toolbar container-->
							</div>
							<!--end::Toolbar-->
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Row-->
									<h5>Selamat Datang, <?php echo session('username');?></h5>
									<br/>
									<?php 
										$session = session();
										if($session->getFlashdata('success')):
									?>
									<div class="notice d-flex bg-light-success rounded border-warning border border-dashed mb-12 p-6">
										<!--begin::Icon-->
										<!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
										<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
												<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
												<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
											</svg>
										</span>
										<!--end::Svg Icon-->
										<!--end::Icon-->
										<!--begin::Wrapper-->
										<div class="d-flex flex-stack flex-grow-1">
											<!--begin::Content-->
											<div class="fw-semibold">
												<h4 class="text-gray-900 fw-bold">Success!!</h4>
												<div class="fs-6 text-gray-700"><?php echo $session->getFlashdata('success');?></div>
											</div>
											<!--end::Content-->
										</div>
										<!--end::Wrapper-->
									</div>
									<!--end::Notice-->
									<?php endif;?>
									<div class="row gx-5 gx-xl-10">
										<!--begin::Col-->
										<div class="col-xxl-12 mb-5 mb-xl-10">
											<!--begin::Chart widget 8-->
											<div class="card card-flush h-xl-100">
												<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-gray-800">Absen Karyawan</span>
														<span class="text-gray-400 mt-1 fw-semibold fs-6">&nbsp;</span>
													</h3>
													<!--end::Title-->
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body pt-6">
													<div class="row">
														<?php if($absen==0 || $absen['created_at']<date('Y-m-d')){
															?>
															<form method="post" action="simpanabsen">
															Anda belum absen silahkan absen dengan take photo selfie
															<center>
																<input type="hidden" name="photo" value="" id="img_id">
																<label class="fs-5 fw-semibold mb-2"><div id="camera" style="width:50%;"></div></label>
																<br/>
																<button onclick="return capture()" class="capture btn btn-warning" >PHOTO</button>
																<button class="btn btn-primary btn-absen" style="display:none;">ABSEN</button>
																<br/>
																<input type="hidden" class="lokasi" name="lokasi" class="form-control" style="width:100%;">
															</center>
															
															</form>
														<?php }else{
															
															echo '<b><i>Anda hadir jam '.$absen['jam'].'</i></b> ';
															if($absen['jam']>'09:00:00'){
																echo '<b><i>Anda datang Terlambat</i></b>';
															}else{
																echo '<b><i>Anda datang Tepat waktu</i></b>';
															}
														}?>
													</div>
												</div>
												<!--end::Body-->
											</div>
											<!--end::Chart widget 8-->
										</div>
										<!--end::Col-->
									</div>
									<!--end::Row-->
									<?php if($absen!=0){?>
									<div class="row gx-5 gx-xl-10">
										<!--begin::Col-->
										<div class="col-xxl-12 mb-5 mb-xl-10">
											<!--begin::Chart widget 8-->
											<div class="card card-flush h-xl-100">
												<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-gray-800">Pencairan Pinjaman</span>
														<span class="text-gray-400 mt-1 fw-semibold fs-6">&nbsp;</span>
													</h3>
													<!--end::Title-->
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body pt-6">
													<div class="row">
														<div class="table-responsive">
															<table class="table align-middle table-row-dashed fs-6 gy-5">
																<thead>
																	<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																		<th class="w-125px pe-2">No</th>
																		<th class="w-125px pe-2">ID Anggota</th>
																		<th class="w-125px pe-2">Tgl Pengajuan</th>
																		<th class="w-125px pe-2">Jumlah</th>
																		<th class="w-125px pe-2">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$no=0; 
																	foreach($datapengajuan as $pengajuan){
																		$no++;
																		?>
																		<tr>
																			<td><?php echo $no;?></td>
																			<td><?php echo $pengajuan['id_anggota'];?></td>
																			<td><?php echo $pengajuan['tgl_pengajuan'];?></td>
																			<td><?php echo number_format($pengajuan['jumlah']);?></td>
																			<td>
																				<?php 
																				if($pengajuan['status']==0){
																					?>
																					<a href="javascript:takephoto(<?php echo $pengajuan['id'];?>);" class="btn btn-primary">Take Photo</a>
																					<?php
																				}
																				?>
																			</td>
																		</tr>
																		<?php
																	}
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
												<!--end::Body-->
											</div>
											<!--end::Chart widget 8-->
										</div>
										<!--end::Col-->
									</div>
									<!--end::Row-->
                                    <!-- informasi Follow up nasabah -->
                                    <div class="row">
                                    	<div class="col-xxl-12 mb-5 mb-xl-10">
                                    		<div class="card card-flush h-xl-100">
                                    			<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-gray-800">Follow up Nasabah</span>
														<span class="text-gray-400 mt-1 fw-semibold fs-6">&nbsp;</span>
													</h3>
													<!--end::Title-->
												</div>
												<!--end::Header-->
                                                <div class="card-body pt-5">
                                                	<p>Follow up Nasabah berikut ini</p>
													<div class="table-responsive">
													<table class="table align-middle table-row-dashed fs-6 gy-5">
														<thead>
															<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																<th class="min-w-125px">No Anggota</th>
																<th class="min-w-125px">Nama</th>
																<th class="min-w-125px">Alamat</th>
																
																<th class="min-w-125px">Status</th>
																<th class="min-w-125px">Action</th>
															</tr>
														</thead>
														<tbody>
															<?php
																if($pengajuan_results){
																	foreach($pengajuan_results as $row){
																		if($row->status==0){
																			$status = 'Pending';
																		}else{
																			$status='Sudah di Followup '.$row->keterangan;
																		}
																		?>
																		<tr>
																			<td><?php echo $row->id_nasabah;?></td>
																			<td><?php echo $row->nama;?></td>
																			<td><?php echo $row->alamat;?></td>
																			<td><?php echo $status;?></td>
																			<td><a href="tanganiwajib?id=<?php echo $row->id_nasabah;?>">Details</a></td>
																		</tr>
																		<?php
																	}
																}
															?>
														</tbody>
													</table>
													</div>
                                                </div>
                                            </div>
                                    	</div>
                                    </div>
									<!-- informasi jumlah tagihan selama satu bulan -->
                                    <div class="row">
                                    	<div class="col-xxl-12 mb-5 mb-xl-10">
                                    		<div class="card card-flush h-xl-100">
                                    			<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-gray-800">Statistik Tagihan</span>
														<span class="text-gray-400 mt-1 fw-semibold fs-6">&nbsp;</span>
													</h3>
													<!--end::Title-->
												</div>
												<!--end::Header-->
                                                <div class="card-body pt-5">
                                                	<div class="row">
                                                		<div class="col-md-5">
                                                				<div class="form-group">
                                                					<label>Pilih Bulan</label>
                                                						<select name="bulan" class="form-control">
    																		<option value="01">Januari</option>
    																		<option value="02">Februari</option>
    																		<option value="03">Maret</option>
    																		<option value="04">April</option>
    																		<option value="05">Mei</option>
    																		<option value="06">Juni</option>
    																		<option value="07">Juli</option>
    																		<option value="08">Agustus</option>
    																		<option value="09">September</option>
    																		<option value="10">Oktober</option>
    																		<option value="11">November</option>
    																		<option value="12">Desember</option>
																		</select>
                                                				</div>
                                               			</div>
                                                		<div class="col-md-5">
                                                			<button class="btn btn-warning" style="margin-top:20px;">Search</button>
                                                		</div>
                                                	</div>
                                                </div>
                                            </div>
                                    	</div>
                                    </div>
									<?php }?>
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						<div id="kt_app_footer" class="app-footer">
							<!--begin::Footer container-->
							<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
								<!--begin::Copyright-->
								<div class="text-dark order-2 order-md-1">
									<span class="text-muted fw-semibold me-1">2022&copy;</span>
									<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
								</div>
								<!--end::Copyright-->
								<!--begin::Menu-->
								<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
									<li class="menu-item">
										<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
									</li>
									<li class="menu-item">
										<a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
									</li>
									<li class="menu-item">
										<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
									</li>
								</ul>
								<!--end::Menu-->
							</div>
							<!--end::Footer container-->
						</div>
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->
		
		<?php 
            include('footer.php');
        ?>

	<!--begin::Modal - Customers - Add-->
	<div class="modal fade" id="kt_modal_take_photo" tabindex="-1" aria-hidden="true">
															
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-650px">
			<!--begin::Modal content-->
			<div class="modal-content">
				<!--begin::Form-->
				<form class="form" action="<?php echo site_url('savedetailpengajuan');?>" method="post" id="kt_modal_add_customer_form">
					<!--begin::Modal header-->
					<div class="modal-header" id="kt_modal_add_customer_header">
						<!--begin::Modal title-->
						<h2 class="fw-bold">Take Photo</h2>
						<!--end::Modal title-->
						<!--begin::Close-->
						<div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
							<span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
						<!--end::Close-->
					</div>
					<!--end::Modal header-->
					<!--begin::Modal body-->
					<div class="modal-body py-10 px-lg-17">
						<!--begin::Scroll-->
						<div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
							<center>
								<input type="hidden" name="photo" value="" id="img_id">
								<label class="fs-5 fw-semibold mb-2"><div id="camera" style="width:50%;"></div></label>
								<br/>
								<button onclick="return capture()" class="capture btn btn-warning" >PHOTO</button>
								<div class="info" style="display:none;">
									Photo ini diambil dari lokasi :<b><i class="lokasi-info"></i></b>
									<br/>
									<div class="mapping" style="width:300px;height:300px;">
										
									</div>
								</div>
								<br/>
								<input type="hidden" name="id_pengajuan" id="id_pengajuan">
								<input type="hidden" id="lat">
								<input type="hidden" id="lang">
								<input type="hidden" class="lokasi" name="lokasi" class="form-control" style="width:100%;">
							</center>
						</div>
						<!--end::Scroll-->
					</div>
					<!--end::Modal body-->
					<!--begin::Modal footer-->
					<div class="modal-footer flex-center">
						<!--begin::Button-->
						<input type="hidden" name="id" id="id_data" value="">
						<button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3">Discard</button>
						<!--end::Button-->
						<!--begin::Button-->
						<button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
							<span class="indicator-label">Submit</span>
							<span class="indicator-progress">Please wait...
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
						</button>
						<!--end::Button-->
					</div>
					<!--end::Modal footer-->
				</form>
				<!--end::Form-->
			</div>
		</div>
	</div>
	<!--end::Modal - Customers - Add-->
	</body>
	<?php if($absen==0 || $absen['created_at']<date('Y-m-d')){?>
	<script>
        // WebcamJS initialization
        Webcam.set({
            width: 250,
            height: 200,
            dest_width: 640,
            dest_height: 480,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#camera');

        
		function absen(){
			var id=$('#img_id').val();
			$('.btn-absen').prop('disabled',true);
			$('.btn-absen').html('Please wait.....');
			$.post("simpanabsen",
			{
				photo:id 
			},
			function(data, status){
				alert("Data: " + data + "\nStatus: " + status);
				location.reload();
			});
			
		}
    </script>	
	<?php }?>
	<script>
		$( document ).ready(function() {
			getLocation();
		});
		var x = document.getElementById("demo");
 
		function getLocation() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else { 
				Swal.fire({
					text: "Lokasi belum di aktifkan",
					icon: "error",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: { confirmButton: "btn btn-primary" },
				}).then(function (e) {
					e.isConfirmed && ((r.disabled = !1), (window.location = t.getAttribute("data-kt-redirect")));
				});
			}
		}
		
		function showPosition(position) {
			var lokasi = position.coords.latitude+','+position.coords.longitude;
			$('.lokasi').val(lokasi);
			$('#lat').val(position.coords.latitude);
			$('#lang').val(position.coords.longitude);
			$('.lokasi-info').html(lokasi);
		}

		function takephoto(id){
			$('#kt_modal_take_photo').modal('show');
			$("#id_pengajuan").val(id);
			Webcam.set({
				width: 350,
				height: 400,
				dest_width: 400,
				dest_height: 400,
				image_format: 'jpeg',
				jpeg_quality: 100,
				constraints: {
					facingMode: 'environment'
				}
			});

			Webcam.attach('#camera');
		}
		// Capture function
        function capture() {
            Webcam.snap(function(data_uri) {
                // Send data_uri to your server (CodeIgniter controller)
                // Use AJAX to send the captured image data to the server
                fetch('<?= base_url('capture') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: 'data_uri=' + encodeURIComponent(data_uri)
                })
                .then(response => response.json())
                .then(data => {
					$('#img_id').val(data.message);
					$('#camera').html('<img src="<?php echo site_url('show/');?>'+data.message+'" width="100%">');
                    //alert(data.message);
					var lati = $("#lat").val();
					var langi = $("#lang").val();
					$('.info').show();
					$('.capture').hide();
					$('.mapping').html('<iframe width="350" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q='+lati+','+langi+'&hl=es&z=14&amp;output=embed"></iframe>');
					$('.btn-absen').show();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
			return false;
        }
	</script>
</html>