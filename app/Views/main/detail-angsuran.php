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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Data Pengajuan Pinjaman</h1>
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
											<li class="breadcrumb-item text-muted">Pengajuan Pinjaman</li>
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
																
																<div class="row mb-5">
																	<div class="col-md-12 fv-row">
																		<h4>Informasi Pengajuan</h4>
																	</div>
																</div>
																<div class="row mb-5">
																	<div class="col-md-6 fv-row">
																		<label class="fs-5 fw-semibold mb-2">Nama</label>
																		<input class="form-control form-control-solid" placeholder="" name="nama" value="<?php echo $detail->nama;?>" id="nama" readonly/>
																	</div>
																	<div class="col-md-6 fv-row">
																		<label class="fs-5 fw-semibold mb-2">Alamat</label>
																		<input class="form-control form-control-solid" placeholder="" name="alamat" value="<?php echo $detail->alamat;?>" id="alamat" readonly/>
																	</div>
																</div>
																<div class="row mb-5">
																	<div class="col-md-6 fv-row">
																		<label class="fs-5 fw-semibold mb-2">No Telp</label>
																		<input class="form-control form-control-solid" placeholder="" name="no_telp" value="<?php echo $detail->no_telp;?>" id="no_telp" readonly/>
																	</div>
																	<div class="col-md-6 fv-row">
																		<label class="fs-5 fw-semibold mb-2">Koordinat Alamat</label>
																		<input class="form-control form-control-solid" placeholder="" name="koordinat" value="<?php echo $detail->koordinat;?>" id="koordinat" readonly/>
																		<a href="https://www.google.com/maps/@<?php echo $detail->koordinat;?>" target="__blank">Lihat di Maps</a>
																	</div>
																</div>
																<hr/>
																<div class="row mb-5">
                                                                    <div class="col-md-12 fv-row">
                                                                    <?php 
                                                                        echo form_open('simpanangsuran',array('method'=>'post'));
                                                                    ?>
                                                                    <table width="100%" align="center" cellpadding="5" cellspacing="0">
                                                                        <tr>
                                                                            <td colspan="7" align="center"><b>INFORMASI ANGSURAN</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="20" style="border:1px solid #333;" align="center"><b>#</b></td>
                                                                            <td width="50" style="border:1px solid #333;" align="center"><b>Tgl</b></td>
                                                                            <td style="border:1px solid #333;" align="center"><b>Jumlah Pokok</b></td>
                                                                            <td style="border:1px solid #333;" align="center"><b>Bunga</b></td>
                                                                            <td style="border:1px solid #333;" align="center"><b>Total Angsuran</b></td>
                                                                            <td style="border:1px solid #333;" align="center"><b>Status</b></td>
                                                                            <td style="border:1px solid #333;" align="center"><b>Tgl Bayar</b></td>
                                                                        </tr>
                                                                        <?php 
                                                                            $no=0;
																			//$n = date('Y-m-d');
																			//$b =0;
																			if($n>1 && $n<3){
																				$bg='#ffd700';
																			}else if($n>2){
																				$bg='#e32b2b';
																			}else{
																				$bg='#fff';
																			}

                                                                            foreach($results_angsuran as $angsuran){
                                                                                $no++;
																				if($angsuran->status){
																					$bg='#fff';
																				}
                                                                                ?>
                                                                                <tr style="background-color:<?php echo $bg;?>">
                                                                                    <td width="20" style="border:1px solid #333;" align="center">
                                                                                        <input type="checkbox" name="id_angsuran[]" value="<?php echo $angsuran->id;?>">
                                                                                    </td>
                                                                                    <td width="20%" style="border:1px solid #333;" align="center"><?php echo date('d F Y', strtotime($angsuran->tgl));?></td>
                                                                                    <td style="border:1px solid #333;" align="right">Rp. <?php echo number_format($angsuran->jumlah_pokok);?></td>
                                                                                    <td style="border:1px solid #333;" align="right">Rp. <?php echo number_format($angsuran->jumlah_bunga);?></td>
                                                                                    <td style="border:1px solid #333;" align="right">Rp. <?php echo number_format($angsuran->jumlah_pokok+$angsuran->jumlah_bunga);?></td>
                                                                                    <td style="border:1px solid #333;" align="center">
                                                                                        <?php echo $angsuran->status?'Sudah Bayar':'Belum Bayar';?>
                                                                                    </td>
                                                                                    <td style="border:1px solid #333;" align="center">
                                                                                        <?php 
																							date_default_timezone_set('Asia/Singapore');
                                                                                            if($angsuran->tgl_bayar || $angsuran->status==1){
                                                                                                echo $angsuran->tgl_bayar;
                                                                                            }else{
                                                                                            	//echo date("H");
																								if(date("H")<19){
                                                                                                	echo '<a href="'.site_url('bayarangsuran?id='.$angsuran->id).'" title="Bayar Angsuran"><i class="bi bi-credit-card" style="font-size:20px;">&nbsp;&nbsp;</i></a>';
                                                                                            	}
																							}
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                        <tr>
                                                                            <td colspan="7" align="left">
																				<p>Total Angsuran Jatuh Tempo : <?php echo $n;?> Kali</p>
                                                                                <button class="btn btn-warning"><i class="bi bi-wallet2" style="font-size:20px;"></i>Bayar yang dipilih</button>
																				<button class="btn btn-danger"><i class="bi bi-wallet2" style="font-size:20px;"></i>Bayar Angsuran Jatuh Tempo</button>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <?php echo form_close();?>
                                                                    </div>
                                                                </div>
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
		<!--begin::Modal - Customers - Add-->
        <div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Form-->
                    <form class="form" method="post" action="<?php echo site_url('simpantolakpengajuan');?>" id="kt_modal_add_customer_form" data-kt-redirect="<?php echo site_url('anggota');?>">
                        <input type="hidden" name="id_data" value="<?php echo $id;?>">
						<!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_add_customer_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">Tolak Pengajuan</h2>
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
                                    <label class="required fs-6 fw-semibold mb-2">Alasan Penolakan</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Alasan Penlokan" name="alasan" value=""  id="alasan"/>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer flex-center">
                            <!--begin::Button-->
                            <input type="hidden" name="id" id="id_data" value="">
                            
                            <!--end::Button-->
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
       
	</body>
	<!--end::Body-->
</html>