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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Data Pinjaman</h1>
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
											<li class="breadcrumb-item text-muted">Data Pinjaman</li>
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
																		<div class="row">
																			
																			<!--begin::Search-->
																			<div class="col-sm">
																				<!--begin::Select2-->
                                                                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Cari Data" data-kt-ecommerce-order-filter="status" id="cari_data">
																					<option></option>
																					<option value="nama">Nama</option>
																					<option value="id_anggota">No Anggota</option>
                                                                                </select>
                                                                                <!--end::Select2-->
																			</div>&nbsp;
																			<div class="col-sm">
																				<input type="text" class="form-control" placeholder="Search" id="keyword"/>
																			</div>&nbsp;
																			<div class="col-sm">
																				<!--begin::Select2-->
                                                                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Kolektor" id="kolektor" data-kt-ecommerce-order-filter="status">
																					<option></option>
																					<option value="0">Tanpa Kolektor</option>
																					<?php foreach($kolektors as $row_kolektor){?>
																						<option value="<?php echo $row_kolektor['id'];?>" <?php if($kolektor==$row_kolektor['id']){ echo 'selected';}?>><?php echo $row_kolektor['username'];?></option>
																					<?php }?>
                                                                                </select>
                                                                                <!--end::Select2-->
																			</div>&nbsp;
																			<div class="col-sm">
																				<button class="btn btn-primary" id="cari_pinjaman" style="width:100%;">Cari</button>
																			</div>
																			<!--end::Search-->
																			
																		</div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <!--end::Card header-->
                                                                <!--begin::Card body-->
                                                                <div class="card-body pt-0">
																	<div class="table-responsive">
																		<!--begin::Table-->
																		<table class="table align-middle table-row-dashed fs-6 gy-5" id="data_anggota">
																			<!--begin::Table head-->
																			<thead>
																				<!--begin::Table row-->
																				<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																					<th class="w-125px pe-2">
																						#
																					</th>
                                                                                    <th class="min-w-125px">Tgl</th>
                                                                                    <th class="min-w-125px">No Rek Pinjaman</th>
																					<th class="min-w-125px">Kolektor</th>
																					<th class="min-w-125px">No Anggota</th>
																					<th class="min-w-125px">Nama Anggota</th>
																					<th class="min-w-125px">Jenis Pinjaman</th>
																					<th class="min-w-125px">Jumlah</th>
                                                                                    <th class="min-w-125px">Jangka Waktu</th>
                                                                                    <th class="min-w-125px">Angsuran Pokok</th>
                                                                                    <th class="min-w-125px">Bunga</th>
                                                                                    <th class="min-w-125px">Sisa Pinjaman</th>
																					
																					<th class="min-w-125px">Status</th>
																					<th class="min-w-125px">Action</th>
																				</tr>
																				<!--end::Table row-->
																			</thead>
																			<!--end::Table head-->
																			<!--begin::Table body-->
																			<tbody class="fw-semibold text-gray-600">
																				<?php 
																					$no=0;
																					foreach ($results as $lists) {
																						$no++;
																						if($lists['status']==1){
																							$status='Sukses';
																						}else if($lists['status']==-1){
																							$status='Cancel';
																						}else if($lists['status']==0){
																							$status='Pending';
																						}
																						?>
																						<tr>
																							<td><?php echo $no;?></td>
																							<td><?php echo $lists['tgl'];?></td>
																							<td><?php echo $lists['rek_pinjaman'];?></td>
																							<td><?php echo $lists['debt_colector'];?></td>
																							<td><?php echo $lists['no_anggota'];?></td>
																							<td><?php echo $lists['nama'];?></td>
																							<td><?php echo $lists['nama_simpanan'];?></td>
																							<td><?php echo number_format($lists['jumlah']);?></td>
																							<td><?php echo $lists['lama_pinjaman'];?></td>
																							<td><?php echo number_format($lists['jumlah_pokok']);?></td>
																							<td><?php echo number_format($lists['jumlah_bunga']);?></td>
																							<td><?php echo number_format($lists['sisa_pinjaman']);?></td>
																							
																							<td><?php echo $status;?></td>
																							<td><?php echo '<a href="javascript:edit_kolektor('.$lists['id'].');"><i class="bi bi-clipboard2-plus" style="font-size:22px;"></i></a><a href="'.site_url('lihatdetailpinjaman?id='.$lists['id']).'" class="" title="Lihat Detail"><i class="bi bi-box-arrow-in-right" style="font-size:25px;"></i></a>&nbsp;<a href="'.site_url('detailangsuran?id='.$lists['id']).'" class="" title="Lihat Angsuran"><i class="bi bi-box-arrow-in-up-right" style="font-size:25px;"></i></a>';?></td>
																							
																						</tr>
																						<?php
																					}
																				?>
																			</tbody>
																			<tfoot>
																					<tr><td colspan="10"><?= $pager->links('btcorona', 'bootstrap_pagination') ?></td></tr>
																			</tfoot>
																			<!--end::Table body-->
																		</table>
																		<!--end::Table-->
																	</table>
                                                                </div>
                                                                <!--end::Card body-->
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
        <script src="assets/js/custom/apps/ecommerce/customers/listing/listing-setupbiaya.js"></script>
		<script type="text/javascript">
			<?php 
				if(isset($_GET['kolektor'])){
					$kolektor=$_GET['kolektor'];
				}else{
					$kolektor=-1;
				}
			?>
			function gantikolektor(id){
				location.href='datapinjaman?kolektor='+id;
			}
			$('#cari_pinjaman').click(function(){
				var kolektor=$('#kolektor').val();
				var keyword = $('#keyword').val();
				var cari_data = $('#cari_data').val();
				location.href='datapinjaman?kolektor='+kolektor+'&keyword='+keyword+'&cari_data='+cari_data;
			})
		</script>
	</body>
	<!--begin::Modal - Customers - Add-->
	<div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-650px">
			<!--begin::Modal content-->
			<div class="modal-content">
				<!--begin::Form-->
				<form class="form" action="savekolektor" method="post">
					<!--begin::Modal header-->
					<div class="modal-header" id="kt_modal_add_customer_header">
						<!--begin::Modal title-->
						<h2 class="fw-bold">Setting Kolektor</h2>
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
							<div class="fv-row mb-7">
								<!--begin::Label-->
								<label class="fs-6 fw-semibold mb-2">
									<span class="required">Kolektor</span>
								</label>
								<!--end::Label-->
								<!--begin::Input-->
								<select class="form-select form-select-solid" name="kolektor" data-control="select2" data-placeholder="Pilih Kolektor">
									<option value=""></option>
									<?php 
										foreach($kolektors as $row){
											?>
											<option value="<?php echo $row['id'];?>"><?php echo $row['username'];?></option>
											<?php
										}
									?>
								</select>
								<!--end::Input-->
							</div>
						</div>
						<!--end::Scroll-->
					</div>
					<!--end::Modal body-->
					<!--begin::Modal footer-->
					<div class="modal-footer flex-center">
						<!--begin::Button-->
						
						<button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3">Discard</button>
						<!--end::Button-->
						<input type="hidden" name="id_data" value="" id="id_data">
						<!--begin::Button-->
						<button type="submit" class="btn btn-primary">
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
	<!--end::Body-->
</html>