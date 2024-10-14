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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Rekap Penarikan</h1>
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
											<li class="breadcrumb-item text-muted">Rekap Penarikan</li>
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
																	<?php echo form_open('rekap-tabungan',array('method'=>'get'));?>
                                                                    <div class="card-toolbar">
                                                                        <!--begin::Toolbar-->
																		<!--begin::Add customer-->
																		
																		<!--end::Add customer-->
                                                                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                                                            <input  name="keyword" placeholder="Masukan Nama Nasabah" class="form-control mb-2" value=""/>&nbsp;
																			<!--begin::Input group-->
																			<div class="d-flex align-items-center flex-equal fw-row me-4 order-2" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
                                                                            
                                                                                <!--begin::Date-->
																				<div class="fs-6 fw-bold text-gray-700 text-nowrap">Dari Tanggal: &nbsp;</div>
																				<!--end::Date-->
																				<!--begin::Input-->
																				<div class="position-relative d-flex align-items-center w-150px">
																					<!--begin::Datepicker-->
																					<input id="kt_ecommerce_edit_order_date" name="start" placeholder="Pilih Tanggal" class="form-control mb-2" value="" onchange=""/>
																					<!--end::Datepicker-->
																					<!--begin::Icon-->
																					<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
																					<span class="svg-icon svg-icon-2 position-absolute ms-4 end-0">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->
																					<!--end::Icon-->
																				</div>
																				<!--end::Input-->
																			</div>
																			<!--end::Input group-->
																			<!--begin::Input group-->
																			<div class="d-flex align-items-center flex-equal fw-row me-4 order-2" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
                                                                                
                                                                                <!--begin::Date-->
																				<div class="fs-6 fw-bold text-gray-700 text-nowrap">Sampai Tanggal : &nbsp;</div>
																				<!--end::Date-->
																				<!--begin::Input-->
																				<div class="position-relative d-flex align-items-center w-150px">
																					<!--begin::Datepicker-->
																					<input id="kt_ecommerce_edit_order_date2" name="end" placeholder="Pilih Tanggal" class="form-control mb-2" value="" onchange=""/>
																					<!--end::Datepicker-->
																					<!--begin::Icon-->
																					<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
																					<span class="svg-icon svg-icon-2 position-absolute ms-4 end-0">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->
																					<!--end::Icon-->
																				</div>
																				<!--end::Input-->
																			</div>
																			<!--end::Input group-->
																			<!--begin::Input group-->
																			<div class="d-flex align-items-center flex-equal fw-row me-4 order-2" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
																				<button class="btn btn-primary">Lihat Data</button>&nbsp;&nbsp;
																			</div>
																			<!--end::Input group-->
                                                                        </div>
                                                                        <!--end::Toolbar-->
                                                                        
                                                                    </div>
                                                                    <!--end::Card toolbar-->
																	<?php echo form_close();?>
                                                                </div>
                                                                <!--end::Card header-->
                                                                <!--begin::Card body-->
                                                                <div class="card-body pt-0">
                                                                    
																	<div class="table-responsive">
																		<!--begin::Table-->
																		
																		<table class="table align-middle table-row-dashed fs-6 gy-5">
																			<!--begin::Table head-->
																			<thead>
																				<!--begin::Table row-->
																				<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																					<th class="w-125px pe-2">
																						#
																					</th>
                                                                                    <th class="min-w-125px">Tgl</th>
                                                                                    <th class="min-w-125px">No Rekening</th>
                                                                                    <th class="min-w-125px">Nama</th>
                                                                                    <th class="min-w-125px">Uraian</th>
																					<th class="min-w-125px">Kredit</th>
																					<th class="min-w-125px">Photo</th>
                                                                                    <th class="min-w-125px">Status</th>
                                                                                    <th class="min-w-125px">Action</th>
																				</tr>
																				<!--end::Table row-->
																			</thead>
																			<!--end::Table head-->
																			<!--begin::Table body-->
																			<tbody class="fw-semibold text-gray-600">
																				<?php
																					foreach($results as $row){
                                                                                        if($row['status']==0){
                                                                                            $status ='Pending';
                                                                                        }else{
                                                                                            $status = 'Approved';
                                                                                        }
																						?>
																						<tr>
																							<td>#</td>
																							<td><?php echo $row['created_at'];?></td>
																							<td><?php echo $row['no_rekening'];?></td>
																							<td><?php echo $row['nama'];?></td>
																							<td><?php echo $row['uraian'];?></td>
																							<td><?php echo number_format($row['debet']);?></td>
																							<td><a href="<?php echo $row['photo_buku'];?>" target="__blank"><img src="<?php echo $row['photo_buku'];?>" width="200"></a></td>
																							<td><?php echo $status;?></td>
                                                                                            <td>
                                                                                                <?php
                                                                                                if(session('userlevel')==3 || session('userlevel')==6){ 
                                                                                                    if($row['status']==0){
                                                                                                        echo '<a href="'.site_url('approvepenarikan?id='.$row['id']).'" class="btn btn-success">Approve</a>';
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                            </td>
																						</tr>
																						<?php
																					} 
																				?>
                                                                                <tfoot>
                                                                                    <tr>
                                                                                        <td colspan="12"><hr/></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="5">Total Saldo Awal</td>
                                                                                        <td ><?php echo number_format($totalsaldoawal);?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="5">Total Mutasi Pending</td>
                                                                                        <td ><?php echo $totalmutasi_pending;?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="5">Total Mutasi Sukses</td>
                                                                                        <td ><?php echo $totalmutasi_sukses;?></td>
                                                                                    </tr>
                                                                                </tfoot>
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
		

</html>