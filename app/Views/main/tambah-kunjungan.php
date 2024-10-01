<!DOCTYPE html>
<html lang="en">
    <?php 
        include('header.php');
    ?>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Laporan Kunjungan</h1>
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
											<li class="breadcrumb-item text-muted">Laporan Kunjungan</li>
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
									
									<div class="row gx-5 gx-xl-10">
										<!--begin::Col-->
										<div class="col-xxl-12 mb-5 mb-xl-10">
											<!--begin::Chart widget 8-->
											<div class="card card-flush h-xl-100">
												
												<!--begin::Body-->
												<div class="card-body pt-6">
                                                
														<div class="row">
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
                                                        <?php 
                                                        if($session->getFlashdata('error')):
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
                                                                        <h4 class="text-gray-900 fw-bold">Error!!</h4>
                                                                        <div class="fs-6 text-gray-700"><?php echo $session->getFlashdata('error');?></div>
                                                                    </div>
                                                                    <!--end::Content-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                            </div>
                                                            <!--end::Notice-->
                                                            <?php endif;?>
                                                        
															<!--begin::Card-->
                                                            <div class="card">
                                                                <!--begin::Card header-->
                                                                <div class="card-header border-0 pt-6">
                                                                    <!--begin::Card title-->
                                                                    <div class="card-title">
                                                                        <!--begin::Search-->
                                                                        <div class="d-flex align-items-center position-relative my-1">
                                                                            &nbsp;
                                                                        </div>
                                                                        <!--end::Search-->
                                                                    </div>
                                                                </div>
                                                                <!--end::Card header-->
                                                                <!--begin::Card body-->
                                                                <div class="card-body pt-0">
																<?php echo form_open('savekunjunganwajib',array('method'=>'post'));?>
																	<h3>Detail Kunjungan</h3>
                                                                    <div class="row">
                                                                        <div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="required fs-6 fw-semibold mb-2">NO Nasabah</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" placeholder="No Nasabah" name="nonasabah" value="<?php echo $row->id_nasabah;?>"  id="nonasabah"/>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="required fs-6 fw-semibold mb-2">Nama</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" placeholder="No Nasabah" name="nama" value="<?php echo $row->nama;?>"  id="nama"/>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="required fs-6 fw-semibold mb-2">Alamat</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" placeholder="Alamat" name="nama" value="<?php echo $row->alamat;?>"  id="alamat"/>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="required fs-6 fw-semibold mb-2">Jumlah Pinjaman</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" placeholder="jumlah pinjaman" name="jumlahpinjaman" value="<?php echo number_format($rowpinjaman['jumlah']);?>"  id="pinjaman"/>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="required fs-6 fw-semibold mb-2">Jumlah Pokok</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" placeholder="jumlah pokok" name="jumlahpokok" value="<?php echo number_format($rowpinjaman['jumlah_pokok']);?>"  id="jumlahpokok"/>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="required fs-6 fw-semibold mb-2">Jumlah Bunga</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" placeholder="jumlah bunga" name="jumlahbunga" value="<?php echo number_format($rowpinjaman['jumlah_bunga']);?>"  id="jumlahbunga"/>
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="required fs-6 fw-semibold mb-2">Keterangan</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" placeholder="Keterangan" name="keterangan" value=""  id="keterangan"/>
                                                                            <!--end::Input-->
                                                                        </div>
																		<div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="required fs-6 fw-semibold mb-2">Lokasi</label>
                                                                            <input type="hidden" id="lat">
																			<input type="hidden" id="lang">
																			<input type="hidden" class="lokasi form-control" name="lokasi"  style="width:100%;">
                                                                        </div>
                                                                        <div class="fv-row mb-7">
                                                                            <input type="hidden" name="photo" value="" id="img_id">
                                                                            <label class="fs-5 fw-semibold mb-2"><div id="camera" style="width:50%;"></div></label>
                                                                            <br/>
                                                                            <button onclick="return capture()" class="capture btn btn-warning" >PHOTO</button>
                                                                        </div>
																		<div class="row mb-5">
																			<div class="col-md-12 fv-row">
																					
																					<button class="btn btn-primary" style="width:100%;">Simpan</button>
																			</div>
																		</div>
                                                                    </div>
																	<?php echo form_close();?>
                                                                </div>
                                                            </div>
                                                            <!--end::Card-->
														</div>
														
												</div>
												<!--end::Body-->
											</div>
											<!--end::Chart widget 8-->
										</div>
										<!--end::Col-->
										
									</div>
									<!--end::Row-->
								</div>
								<!--end::Content container-->
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
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="assets/js/custom/apps/ecommerce/sales/save-order.js"></script>
		<script src="assets/js/custom/utilities/modals/users-search.js"></script>
        <script src="assets/js/custom/apps/ecommerce/customers/listing/add-setupbiaya.js"></script>
        <script src="assets/js/custom/apps/ecommerce/customers/listing/listing-setupbiaya.js"></script>
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
            // WebcamJS initialization
            Webcam.set({
				width: 250,
				height: 200,
				dest_width: 640,
				dest_height: 480,
				image_format: 'jpeg',
				jpeg_quality: 90,
				constraints: {
					facingMode: 'environment'
				}
			});

            Webcam.attach('#camera');

            
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
						$('.capture').hide();
					})
					.catch(error => {
						console.error('Error:', error);
					});
				});
				return false;
			}
        </script>	
		<script type="text/javascript">
			$("#followupdate").flatpickr({ altInput: !0, altFormat: "Y-m-d", dateFormat: "Y-m-d" });
			$('#nonasabah').on('keyup', function (){
				let query = $(this).val();
				if (query.length > 2) {
					$.ajax({
						url: 'carianggotawajib', // Replace with the actual controller URL
						method: 'GET',
						data: { search: query },
						dataType: 'json', // Make sure dataType is set to 'json'
						success: function (data) {
							//alert(data.nama);
							$('#nama').val(data.nama);
							$('#alamat').val(data.alamat);
						},
						error: function (xhr, status, error) {
							console.error('Error:', error);
						}
					});
				} else {
					$('#nama').val('');
					$('#alamat').val('');
				}
			});
			$('#simpankunjunganwajib').click(function(){
			// Disable the button to prevent multiple submissions
			$('#simpankunjunganwajib').prop('disabled', true);

			// Collect form data
			var kolektor = $('#kolektordata').val();
			var nonasabah = $('#nonasabah').val();
			var followupDate = $('#followupdate').val();

			// Check if any fields are empty
			if (kolektor === '' || nonasabah === '' || followupDate === '') {
				alert('Data tidak lengkap');
				$('#simpankunjunganwajib').prop('disabled', false); // Re-enable the button
			} else {
				// Perform the AJAX request
				$.ajax({
					url: 'tambahkunjunganwajib', // Replace with the correct URL to your controller's method
					method: 'POST',
					data: {
						kolektor: kolektor,
						nonasabah: nonasabah,
						date: followupDate
					},
					dataType: 'json', // Expect a JSON response from the server
					success: function(response) {
						if (response.status === 'success') {
							alert(response.message); // Display success message
							// You may want to clear the form fields or perform other actions here
							$('#kolektordata').val('');
							$('#nonasabah').val('');
							$('#followupdate').val('');
						} else {
							alert('Error: ' + response.message); // Display error message
						}
						$('#simpankunjunganwajib').prop('disabled', false); // Re-enable the button
					},
					error: function(xhr, status, error) {
						alert('An error occurred: ' + error); // Display AJAX error
						$('#simpankunjunganwajib').prop('disabled', false); // Re-enable the button
					}
				});
			}
		});

		</script>

</html>