<!DOCTYPE html>
<html lang="en">
    <?php 
        include('header.php');
    ?>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <style type="text/css">
        data-tagihan{

        }
    </style>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Laporan Kas</h1>
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
											<li class="breadcrumb-item text-muted">Data Module</li>
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
																
																<!--begin::Card body-->
                                                                <div class="card-body pt-0">
																	<div class="table-responsive">
																		<!--begin::Table-->
																		<table class="table align-middle table-row-dashed fs-6 gy-5" id="data-tagihan" border="1">
                                                                        <tr>
                                                                            <td><strong>URAIAN</strong></td>
                                                                            <td><strong>DEBET</strong></td>
                                                                            <td><strong>KREDIT</strong></td>
                                                                            <td><strong>BALANCE</strong></td>
                                                                        </tr>
                                                                        <?php
                                                                            $totalsaldo = 0; 
                                                                            $total_tagihan_hari_ini =0;
                                                                            $total_balance = array();
                                                                            $akun_akhir = $data_akun;
                                                                            foreach($data_akun as $akun){
                                                                                //check saldo last
                                                                                $balance = $model->where('kode_akun',$akun['no_akun'])->orderby('id','DESC')->first();
                                                                                if($balance){
                                                                                    $totalsaldo=$totalsaldo+$balance['debet'];
                                                                                }
                                                                            ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <?php echo $akun['no_akun'].' '.$akun['account_name'];?>
                                                                                </td>
                                                                                <td align="right">
                                                                                    <?php 
                                                                                        if($balance){
                                                                                            echo number_format($balance['debet'],2,",",".");
                                                                                            $debet = $balance['debet'];
                                                                                        }else{
                                                                                            echo number_format(0,2,",",".");
                                                                                            $debet = 0;
                                                                                        }
                                                                                        
                                                                                    ?>
                                                                                </td>
                                                                                <td align="right">
                                                                                    <?php 
                                                                                        if($balance){
                                                                                            echo number_format($balance['kredit'],2,",",".");
                                                                                            $kredit = $balance['kredit'];
                                                                                        }else{
                                                                                            echo number_format(0,2,",",".");
                                                                                            $kredit=0;
                                                                                        }
                                                                                        
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php 
                                                                                        $balance = $debet-$kredit;
                                                                                        $total_balance[$akun['id']]=$balance;
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <tr style="background:#ccc;">
                                                                            <td>
                                                                                <strong>TOTAL KAS AWAL</strong>
                                                                            </td>
                                                                            <td align="right"><strong><?php echo number_format($totalsaldo,2,",",".");?></strong></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3"><strong>DATA SETORAN</strong></td>
                                                                        </tr>
                                                                        <?php 
                                                                            //kolektors checks 
                                                                            foreach($kolektors as $kolektor){
                                                                                ?>
                                                                                <tr style="background:#ccc;">
                                                                                    <td>KOLEKTOR</td>
                                                                                    <td colspan="3"><strong><?php echo $kolektor['username'];?></strong></td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td colspan="4">TITIPAN</td>
                                                                                </tr>
                                                                                <?php
                                                                                $total_titipan_kredit =array();
                                                                                $_total_tunai_kolektor = array();
                                                                                $_balance_titipan = array();
                                                                                $_balance_tagihan = array();
                                                                                foreach($data_akun as $akun){
                                                                                    //tagihan per account 
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td style="padding-left:20px;">-<?php echo $akun['account_name'];?></td>
                                                                                        <td style="padding-left:20px;" align="right">
                                                                                            <?php 
                                                                                                $titipan_debet = $model->getTitipanByAkun($kolektor['username'],$akun['no_akun'],date('Y-m-d'),date('Y-m-d'),'debet')->debet;
                                                                                                $titipan_kredit = $model->getTitipanByAkun($kolektor['username'],$akun['no_akun'],date('Y-m-d'),date('Y-m-d'),'kredit')->kredit;
                                                                                                if($titipan_debet!=NULL){
                                                                                                    echo number_format($titipan_debet,2,",",".");
                                                                                                    if(in_array($akun['id'],$_total_tunai_kolektor)){
                                                                                                        $_total_tunai_kolektor[$akun['id']]=$_total_tunai_kolektor[$akun['id']]+$titipan_debet;
                                                                                                    }else{
                                                                                                        $_total_tunai_kolektor[$akun['id']]=$titipan_debet;
                                                                                                    }
                                                                                                
                                                                                                }else{
                                                                                                    echo number_format(0,2,",",".");
                                                                                                } 
                                                                                            ?>
                                                                                        </td>
                                                                                        <td align="right">
                                                                                                <?php 
                                                                                                    if($titipan_kredit!=NULL){
                                                                                                        if(in_array($akun['id'],$total_titipan_kredit)){
                                                                                                            $total_titipan_kredit[$akun['id']]=$total_titipan_kredit[$akun['id']]+$titipan_kredit;
                                                                                                        }else{
                                                                                                            $total_titipan_kredit[$akun['id']]=$titipan_kredit;
                                                                                                        }
                                                                                                        echo number_format($titipan_kredit,2,",",".");
                                                                                                    }else{
                                                                                                        echo number_format(0,2,",",".");
                                                                                                    } 
                                                                                                ?>
                                                                                        </td>
                                                                                        <td align="right">
                                                                                            <?php 
                                                                                            if($titipan_debet!=NULL){
                                                                                                echo number_format($titipan_debet,2,",",".");
                                                                                                $_balance_titipan[$akun['id']]=$titipan_debet;
                                                                                                //$total_balance[$akun['id']]=$total_balance[$akun['id']]+$titipan_debet;
                                                                                            }else{
                                                                                                echo number_format(0,2,",",".");
                                                                                                $_balance_titipan[$akun['id']]=0;
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                <tr>
                                                                                    <td colspan="3">TAGIHAN</td>
                                                                                </tr>
                                                                                <?php
                                                                                
                                                                                foreach($data_akun as $akun){
                                                                                    //tagihan per account 
                                                                                    $tagihan_kolektor = $model->getTagihanByAkun($kolektor['username'],$akun['no_akun'],date('Y-m-d'),date('Y-m-d'));
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td style="padding-left:20px;">-<?php echo $akun['account_name'];?></td>
                                                                                        <td align="right">
                                                                                            <?php
                                                                                                if($tagihan_kolektor->totaltagihan!=NULL){
                                                                                                    echo number_format($tagihan_kolektor->totaltagihan,2,",",".");
                                                                                                    $b =$tagihan_kolektor->totaltagihan;
                                                                                                }else{
                                                                                                    echo number_format(0,2,",",".");
                                                                                                    $b =0;
                                                                                                } 
                                                                                            ?>
                                                                                        </td>
                                                                                        <td align="right">
                                                                                            <?php 
                                                                                                //echo $akun['id'];
                                                                                                if(isset($total_titipan_kredit[$akun['id']])){
                                                                                                    echo number_format($total_titipan_kredit[$akun['id']],2,",",".");
                                                                                                }else{
                                                                                                    echo number_format(0,2,",",".");
                                                                                                }
                                                                                            ?>
                                                                                        </td>
                                                                                        <td align="right">
                                                                                            <?php 
                                                                                                if(isset($total_titipan_kredit[$akun['id']])){
                                                                                                    $b = $tagihan_kolektor->totaltagihan-$total_titipan_kredit[$akun['id']];
                                                                                                }
                                                                                                $b = $b+$_balance_titipan[$akun['id']];
                                                                                                $total_balance[$akun['id']]=$total_balance[$akun['id']]+$b;
                                                                                                echo '<b>'.number_format($b,2,",",".").'</b>';
                                                                                            ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                        <tr style="background:#ccc;">
                                                                            <td>
                                                                                <strong>TOTAL TAGIHAN HARI INI</strong>
                                                                            </td>
                                                                            <td align="right" colspan="3">
                                                                                <?php 
                                                                                    $totaltaghian_harian = $model->getTotalTagihanHarian();
                                                                                ?>
                                                                                <strong><?php echo number_format($totaltaghian_harian->totaltagihan,2,",",".");?></strong>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr style="background:#ccc;">
                                                                            <td>
                                                                                <strong>TOTAL TAGIHAN BULAN INI</strong>
                                                                            </td>
                                                                            <td align="right" colspan="3">
                                                                                <?php 
                                                                                    $totaltaghian = $model->getTotalTagihanBulan();
                                                                                ?>
                                                                                <strong><?php echo number_format($totaltaghian->totaltagihan,2,",",".");?></strong>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <strong>PENDAPATAN SISA ANGSURAN PENCAIRAN</strong>
                                                                            </td>
                                                                            <td align="right">
                                                                                <?PHP 
                                                                                    $start = date("Y-m-d");
                                                                                    $end = date("Y-m-d 23:59:59");
                                                                                    $totalpendapatan = $model->getTotalTagihanHarianPelunasan();
                                                                                    if($totalpendapatan->totaltagihan!=NULL){
                                                                                        echo number_format($totalpendapatan->totaltagihan,2,",",".");
                                                                                    }else{
                                                                                        echo number_format(0,2,",",".");
                                                                                    }
                                                                                    $pendapatan_cair = $totalpendapatan->totaltagihan;
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <strong>PENDAPATAN</strong>
                                                                            </td>
                                                                            <td align="right">
                                                                                <?PHP 
                                                                                    $start = date("Y-m-d");
                                                                                    $end = date("Y-m-d 23:59:59");
                                                                                    $totalpendapatan = $model->getTotalPendapatan($start,$end);
                                                                                    if($totalpendapatan->total!=NULL){
                                                                                        echo number_format($totalpendapatan->total,2,",",".");
                                                                                    }else{
                                                                                        echo number_format(0,2,",",".");
                                                                                    }
                                                                                    
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <strong>PENGELUARAN</strong>
                                                                            </td>
                                                                            <td>
                                                                                
                                                                            </td>
                                                                            <td align="right">
                                                                                <?PHP 
                                                                                    $start = date("Y-m-d");
                                                                                    $end = date("Y-m-d 23:59:59");
                                                                                    $totalpengeluaran = $model->getTotalPenngeluaran($start,$end);
                                                                                    if($totalpengeluaran->total!=NULL){
                                                                                        echo number_format($totalpengeluaran->total,2,",",".");
                                                                                    }else{
                                                                                        echo number_format(0,2,",",".");
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3">
                                                                                <strong>DATA PENCAIRAN</strong>
                                                                            </td>
                                                                        </tr>
                                                                        <?PHP 
                                                                            $start = date("Y-m-d");
                                                                            $end = date("Y-m-d 23:59:59");
                                                                            $datas = $model->getPencairan($start,$end);
                                                                            $totalpencairan = 0;
                                                                            foreach($datas as $row){
                                                                                $totalpencairan=$totalpencairan+$row->jumlah;
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php echo $row->id_anggota;?>
                                                                            </td>
                                                                            <td></td>
                                                                            <td><?php echo number_format($row->jumlah,2,",",".");?></td>
                                                                        </tr>
                                                                        <?php 
                                                                            }
                                                                        ?>
                                                                            <tr>
                                                                            <td colspan="3">
                                                                                <strong>SALDO AKHIR</strong>
                                                                            </td>
                                                                        </tr>
                                                                        <form method="post" action="simpankasharian" id="simpankasharian">
                                                                        <input type="hidden" name="akun[]" value="totaltagihanbulan">
                                                                        <input type="hidden" name="balance[]" value="<?=$totaltaghian->totaltagihan;?>">
                                                                        <?PHP 
                                                                            
                                                                            foreach($akun_akhir as $_akun){
                                                                                if($_akun['no_akun']=='01.01.110-40'){
                                                                                    $total_balance[$_akun['id']] = $total_balance[$_akun['id']]-$totalpencairan-$totalpengeluaran->total+$totalpendapatan->total+$pendapatan_cair;
                                                                                }
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                    <?php echo $_akun['no_akun'].' - '.$_akun['account_name'];?>
                                                                            </td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td><?php echo number_format($total_balance[$_akun['id']]);?></td>
                                                                        </tr>
                                                                        
                                                                            <input type="hidden" name="akun[]" value="<?=$_akun['no_akun'];?>">
                                                                            <input type="hidden" name="balance[]" value="<?=$total_balance[$_akun['id']];?>">
                                                                        
                                                                        <?php 
                                                                            }
                                                                        ?>
                                                                        </form>
                                                                    </table>
                                                                    <!--end::Table-->
                                                                </table>
                                                                </div>
                                                                <!--end::Card body-->
                                                            </div>
                                                            <!--end::Card-->
															<?php 
                                                                if($saldo_akhir){
                                                                    ?>
                                                                    <a href="<?php echo site_url('printlaporankas');?>" target="__blank" class="btn btn-warning">PRINT</a>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <a href="javascript:simpandata();" class="btn btn-warning">SIMPAN DATA</a>
                                                                    <?php
                                                                }
                                                            ?>
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
		<script>
            function simpandata(){
                $('#simpankasharian').submit();
            }
        </script>
	</body>
	
	<!--end::Body-->
</html>