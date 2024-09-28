<?php 
	date_default_timezone_set('Asia/Singapore');
?>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Data Pembayaran Angsuran</h1>
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
											<li class="breadcrumb-item text-muted">Pembayaran Angsuran</li>
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
																<?php echo form_open('saveangsuran',array('method'=>'post'));?>
																<div class="row mb-5">
																	<div class="col-md-12 fv-row">
																		<h4>Informasi Angsuran</h4>
																	</div>
																</div>
																<div class="row mb-5">
																	<div class="col-md-6 fv-row">
																		<label class="fs-5 fw-semibold mb-2">KAS</label>
																		<!--begin::Select-->
                                                                        <select name="jenis_kas" id="jenis_kas" data-control="select2" data-placeholder="PILIH KAS..." class="form-select form-select-solid" onchange="cekssaldo(this.value);">
                                                                            <option value=""></option>
                                                                            <?php 
                                                                                
                                                                                foreach($data_akun as $re){
                                                                                    ?>
                                                                                    <option value="<?php echo $re['no_akun'];?>"><?php echo $re['no_akun'].' '.$re['account_name'];?></option>
                                                                                    <?php
                                                                                } 
                                                                            ?>
                                                                        </select>
                                                                        <!--end::Select-->
																	</div>
																	<div class="col-md-6 fv-row">
																		<label class="fs-5 fw-semibold mb-2">Tgl Transaksi</label>
																		<input class="form-control form-control-solid" placeholder="" name="tgl" value="<?php echo date('Y-m-d H:i:s');?>" readonly/>
																	</div>
																</div>
																<div class="row mb-5">
																	<div class="col-md-6 fv-row">
																		<label class="fs-5 fw-semibold mb-2">Total Pokok</label>
																		<input class="form-control form-control-solid" placeholder="" name="total_pokok" value="<?php echo number_format($detail_data->jumlah_pokok);?>" id="total_pokok" readonly/>
																	</div>
																	<div class="col-md-6 fv-row">
																		<label class="fs-5 fw-semibold mb-2">Total Bunga</label>
																		<input class="form-control form-control-solid" placeholder="" name="total_bunga" value="<?php echo number_format($detail_data->jumlah_bunga);?>" id="total_bunga" readonly/>
																	</div>
																</div>
                                                                <div class="row mb-5">
																	<div class="col-md-6 fv-row">
																		<label class="fs-5 fw-semibold mb-2">Total Bayar</label>
																		<input class="form-control form-control-solid" placeholder="" name="total_bayar" value="<?php echo number_format($detail_data->jumlah_pokok+$detail_data->jumlah_bunga);?>" id="total_bayar" readonly/>
																	</div>
																	
																</div>
																<div class="row mb-12">
																	<div class="col-md-12 fv-row">
																		<center>
																			<input type="hidden" name="img_id" value="" id="img_id">
																			<label class="fs-5 fw-semibold mb-2"><div id="camera" style="width:50%;"></div></label>
																			<br/>
																			<button onclick="return capture()" class="capture">Photo</button>
																		</center>
																	</div>
																</div>
																<div class="row mb-5">
																	<div class="col-md-12 fv-row">
                                                                            <p>&nbsp;</p>
                                                                            <input type="hidden" name="id_angsuran[]" value="<?php echo $id;?>">
                                                                            <button class="btn btn-primary" style="width:100%;">Simpan</button>
                                                                    </div>
																</div>
																<?php echo form_close();?>
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
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="assets/js/custom/apps/ecommerce/sales/save-order.js"></script>
		<script src="assets/js/custom/utilities/modals/users-search.js"></script>
        <script src="assets/js/custom/apps/ecommerce/customers/listing/add-setupbiaya.js"></script>
        <script src="assets/js/custom/apps/ecommerce/customers/listing/listing-simpanananggota.js"></script>
		<script>
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
					$('.capture').hide();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
			return false;
        }
    </script>													
	</body>
	<!--end::Body-->
</html>