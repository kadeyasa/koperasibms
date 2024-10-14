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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Data Tabungan</h1>
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
											<li class="breadcrumb-item text-muted">Data Tabungan</li>
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
                                                                    <!--begin::Card title-->
                                                                    <!--begin::Card toolbar-->
																	
                                                                    <div class="card-toolbar">
                                                                        <!--begin::Toolbar-->
																		<!--begin::Add customer-->
																		<div class="d-flex align-items-center flex-equal fw-row me-4 order-2" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
																			<a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">Tambah</a>&nbsp;&nbsp;
																		</div>
																		<!--end::Add customer-->
                                                                    </div>
                                                                    <!--end::Card toolbar-->
																	
                                                                </div>
                                                                <!--end::Card header-->
                                                                <!--begin::Card body-->
                                                                <div class="card-body pt-0">
                                                                    <div class="justify-content-end" data-kt-customer-table-toolbar="base">
                                                                        
                                                                        <?php echo form_open('data-tabungan',array('method'=>'get'));?>
                                                                        
                                                                        <div class="align-items-center flex-equal fw-row me-4 order-2" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
                                                                            
                                                                            <div class="fs-6 fw-bold text-gray-700 text-nowrap">Nama Nasabah: &nbsp;</div>
                                                                            
                                                                            <div class="position-relative d-flex align-items-center w-300px">
                                                                                
                                                                                <input  name="keyword" placeholder="Masukan Nama Nasabah" class="form-control mb-2" value=""/>
                                                                                <button class="btn btn-primary">Lihat Data</button>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        <?php echo form_close();?>
                                                                    </div>
                                                                    
																	<div class="table-responsive">
																		<!--begin::Table-->
																		<h3>Data Kunjungan Wajib</h3>
																		<table class="table align-middle table-row-dashed fs-6 gy-5">
																			<!--begin::Table head-->
																			<thead>
																				<!--begin::Table row-->
																				<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																					<th class="w-125px pe-2">
																						#
																					</th>
                                                                                    <th class="min-w-125px">No Rek</th>
                                                                                    <th class="min-w-125px">NIK</th>
                                                                                    <th class="min-w-125px">Nama</th>
                                                                                    <th class="min-w-125px">Alamat</th>
																					<th class="min-w-125px">No Hp</th>
																					<th class="min-w-125px">Saldo</th>
                                                                                    <th class="min-w-125px">Action</th>
																				</tr>
																				<!--end::Table row-->
																			</thead>
																			<!--end::Table head-->
																			<!--begin::Table body-->
																			<tbody class="fw-semibold text-gray-600">
																				<?php
																					foreach($results as $row){
																				
																						?>
																						<tr>
																							<td>#</td>
																							<td><?php echo $row['no_rekening'];?></td>
																							<td><?php echo $row['nik'];?></td>
																							<td><?php echo $row['nama'];?></td>
																							<td><?php echo $row['alamat'];?></td>
																							<td><?php echo $row['no_hp'];?></td>
                                                                                            <td><?php echo number_format($row['saldo']);?></td>
																							<td>
                                                                                                <a href="javascript:tambahtabungan(<?php echo $row['id'];?>);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-tabungan">Tambah Tabungan</a>
                                                                                            </td>
																						</tr>
																						<?php
																					} 
																				?>
																			</tbody>
																			<!--end::Table body-->
																		</table>
																		<!--end::Table-->
																	</table>
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
		<!--begin::Modal - Customers - Add-->
		<div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Form-->
					<form class="form" method="post" action="<?php echo site_url('tambahnasabahtabungan');?>" id="kt_modal_add_customer_form" data-kt-redirect="<?php echo site_url('anggota');?>">
						<!--begin::Modal header-->
						<div class="modal-header" id="kt_modal_add_customer_header">
							<!--begin::Modal title-->
							<h2 class="fw-bold">Tambah Nasabah</h2>
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
								<!--begin::Input group-->
								<div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">No Rekening</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" placeholder="No Rekening" name="norek" value=""  id="norek"/>
									<!--end::Input-->
								</div>
                                <div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">NIK</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" placeholder="NIK" name="nik" value=""  id="nik"/>
									<!--end::Input-->
								</div>
								<div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">Nama</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" placeholder="Nama" name="nama" value=""  id="nama"/>
									<!--end::Input-->
								</div>
								<div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">Alamat</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" placeholder="Nama" name="alamat" value=""  id="alamat"/>
									<!--end::Input-->
								</div>
								<div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">No HP</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" placeholder="No HP" name="no_hp" id="no_hp"/>
									<!--end::Input-->
								</div>
                                <div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">Saldo</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" placeholder="Saldo" name="saldo" id="saldo"/>
									<!--end::Input-->
								</div>
								
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
							<button type="submit" class="btn btn-primary">
								<span class="indicator-label">Submit</span>
								
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



        <!--begin::Modal - Customers - Add-->
		<div class="modal fade" id="modal-tambah-tabungan" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Form-->
					<form class="form" method="post" action="<?php echo site_url('tambahtabungan');?>" id="kt_modal_add_customer_form" data-kt-redirect="<?php echo site_url('anggota');?>">
						
                        <!--begin::Modal header-->
						<div class="modal-header" id="kt_modal_add_customer_header">
							<!--begin::Modal title-->
							<h2 class="fw-bold">Tambah Nasabah</h2>
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
								<!--begin::Input group-->
								<div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">ID Nasabah</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" placeholder="ID nasabah" name="idnasabah" value=""  id="idnasabahsearc"/>
									<!--end::Input-->
								</div>
                                <div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">Uraian</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" placeholder="Uraian" name="uraian" value="Tabungan Tgl <?php echo date('d-m-Y');?>"  id="uraian"/>
									<!--end::Input-->
								</div>
                                <div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">Debet</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" placeholder="Debet" name="debet" value=""  id="debet"/>
									<!--end::Input-->
								</div>
								<div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold mb-2">Photo</label>
									<!--end::Label-->
									<!--begin::Input-->
									<div class="fv-row mb-7">
                                        <input type="hidden" name="photo" value="" id="img_id">
                                        <label class="fs-5 fw-semibold mb-2"><div id="camera" style="width:50%;"></div></label>
                                        <br/>
                                        <button onclick="return capture()" class="capture btn btn-warning" >PHOTO</button>
                                    </div>
									<!--end::Input-->
								</div>
								
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
							<button type="submit" class="btn btn-primary">
								<span class="indicator-label">Submit</span>
								
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
            function tambahtabungan(id){
                $('#idnasabahsearc').val(id);
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
</html>