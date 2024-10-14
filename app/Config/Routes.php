<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We post a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('login', 'Auth::login');
$routes->get('signup', 'Auth::signup');
$routes->get('logout', 'Auth::logout');
$routes->post('signupsave', 'Auth::signupsave');

$routes->get('/dashboard', 'Member::index',['filter' => 'auth']);
$routes->get('/profileuser', 'Profile::user',['filter' => 'auth']);
$routes->get('/profilekoperasi', 'Profile::koperasi',['filter' => 'auth']);
$routes->post('saveprofile', 'Profile::saveprofile',['filter' => 'auth']);
$routes->post('savekoperasi', 'Profile::savekoperasi',['filter' => 'auth']);
$routes->get('detailpembayaran', 'Datapinjaman::detailpembayaran',['filter' => 'auth']);

$routes->get('/anggota', 'Anggota::index',['filter' => 'auth']);
$routes->post('/saveanggota', 'Anggota::addAnggota',['filter' => 'auth']);
$routes->post('/deleteanggota', 'Anggota::deleteanggota',['filter' => 'auth']);
$routes->get('/getdataanggota', 'Anggota::getdataanggota',['filter' => 'auth']);

$routes->get('/simpananpokok', 'Simpanan::simpananpokok',['filter' => 'auth']);
$routes->post('/savesimpananpokok', 'Simpanan::savesimpananpokok',['filter' => 'auth']);
$routes->get('/simpananwajib', 'Simpanan::simpananwajib',['filter' => 'auth']);
$routes->get('/tagihansimpananwajib', 'Simpanan::tagihansimpananwajib',['filter' => 'auth']);
$routes->post('/deletesimpananpokok', 'Simpanan::deletesimpananpokok',['filter' => 'auth']);
$routes->post('/savesimpananwajib', 'Simpanan::savesimpananwajib',['filter' => 'auth']);
$routes->get('/printtagihanwajib', 'Simpanan::printtagihanwajib',['filter' => 'auth']);

$routes->get('/dataakun', 'Akun::dataakun',['filter' => 'auth']);
$routes->get('/printakun', 'Akun::printakun',['filter' => 'auth']);
$routes->post('/simpanakun', 'Akun::simpanakun',['filter' => 'auth']);
$routes->post('/deleteakun', 'Akun::deleteakun',['filter' => 'auth']);
$routes->get('/getdataakun', 'Akun::getdataakun',['filter' => 'auth']);

$routes->get('/neracaawal', 'Akuntansi::neracaawal',['filter' => 'auth']);
$routes->post('/simpanneracaawal', 'Akuntansi::saveneracaawal',['filter' => 'auth']);
$routes->post('/deleteneracaawal', 'Akuntansi::deleteneracaawal',['filter' => 'auth']);
$routes->get('/printneracaawal', 'Akuntansi::printneracaawal',['filter' => 'auth']);

$routes->get('/setupsimpanan', 'Setupsimpanan::index',['filter' => 'auth']);
$routes->get('/getsetupsimpanan', 'Setupsimpanan::getSetupSimpanan',['filter' => 'auth']);
$routes->post('/savesetupsimpanan', 'Setupsimpanan::savesetupsimpanan',['filter' => 'auth']);
$routes->post('/deletesetupsimpanan', 'Setupsimpanan::deletesetupsimpanan',['filter' => 'auth']);

$routes->get('/setuppinjaman', 'Setuppinjaman::index',['filter' => 'auth']);
$routes->get('/getsetuppinjaman', 'Setuppinjaman::getSetup',['filter' => 'auth']);
$routes->post('/savesetuppinjaman', 'Setuppinjaman::savesetup',['filter' => 'auth']);
$routes->post('/deletesetuppinjaman', 'Setuppinjaman::deletesetup',['filter' => 'auth']);

$routes->get('/settingbiaya', 'Setuppinjaman::settingbiaya',['filter' => 'auth']);
$routes->post('/savebiayapinjaman', 'Setuppinjaman::savebiayapinjaman',['filter' => 'auth']);
$routes->post('/deletebiaya', 'Setuppinjaman::deletebiaya',['filter' => 'auth']);
$routes->post('/getsetupbiayapinjaman', 'Setuppinjaman::getsetupbiayapinjaman',['filter' => 'auth']);

$routes->get('/simpanananggota', 'Datasimpanan::index',['filter' => 'auth']);
$routes->post('/datasimpanan', 'Datasimpanan::datasimpanan');
$routes->get('/tambahsimpanananggota', 'Datasimpanan::tambahsimpanananggota',['filter' => 'auth']);
$routes->post('/dataanggota', 'Datasimpanan::dataanggota',['filter' => 'auth']);
$routes->post('/savesimpanan', 'Datasimpanan::savesimpanan',['filter' => 'auth']);
$routes->get('/getdataanggotabykode', 'Anggota::getdataanggotabykode',['filter' => 'auth']);

$routes->get('/datapengajuan', 'Pengajuanpinjaman::datapengajuan',['filter' => 'auth']);
$routes->get('/getdatapengajuan', 'Pengajuanpinjaman::getDataPengajuan',['filter' => 'auth']);
$routes->get('/pengajuanpinjaman', 'Pengajuanpinjaman::ajukanpinjaman',['filter' => 'auth']);
$routes->post('/savepengajuan', 'Pengajuanpinjaman::savepengajuan');
$routes->post('/getdatapengajuan', 'Pengajuanpinjaman::getDataPengajuan',['filter' => 'auth']);
$routes->get('/editstatuspengajuan', 'Pengajuanpinjaman::editstatuspengajuan',['filter' => 'auth']);
$routes->post('/simpantolakpengajuan', 'Pengajuanpinjaman::simpantolakpengajuan',['filter' => 'auth']);
$routes->get('/terimapengajuan', 'Pengajuanpinjaman::terimapengajuan',['filter' => 'auth']);
$routes->get('/ceksaldo', 'Pengajuanpinjaman::ceksaldo',['filter' => 'auth']);

$routes->post('/simpanpinjaman', 'Datapinjaman::simpanpinjaman',['filter' => 'auth']);
$routes->get('/pencairanpinjaman', 'Datapinjaman::datapencairan',['filter' => 'auth']);
$routes->post('/getdatapencairan', 'Datapinjaman::getdatapencairan');
$routes->post('/cancelpencairan', 'Datapinjaman::cancelpencairan');
$routes->get('/setujuipencairan', 'Datapinjaman::setujuipencairan',['filter' => 'auth']);
$routes->get('/datapinjaman', 'Datapinjaman::datapinjaman',['filter' => 'auth']);
$routes->post('/getlistpinjaman', 'Datapinjaman::getlistpinjaman');
$routes->get('/lihatdetailpinjaman', 'Datapinjaman::detailpinjaman',['filter' => 'auth']);
$routes->get('/printpinjaman', 'Datapinjaman::printpinjaman',['filter' => 'auth']);
$routes->get('/detailangsuran', 'Datapinjaman::detailangsuran',['filter' => 'auth']);
$routes->get('/bayarangsuran', 'Datapinjaman::bayarangsuran',['filter' => 'auth']);
$routes->post('/saveangsuran', 'Datapinjaman::saveangsuran',['filter' => 'auth']);

$routes->get('/pinjamanawal', 'Pengajuanpinjaman::pinjamanawal',['filter' => 'auth']);
$routes->get('/laptagihan', 'Laporan::laporantagihan',['filter' => 'auth']);
$routes->post('/savekolektor', 'Datapinjaman::savekolektor',['filter' => 'auth']);
$routes->get('/printtagihan', 'Laporan::printtagihan',['filter' => 'auth']);
$routes->get('/lappembayaran', 'Laporan::lappembayaran',['filter' => 'auth']);
$routes->get('/jurnalumum', 'Laporan::jurnalumum',['filter' => 'auth']);
$routes->get('/printlappembayaran', 'Laporan::printlappembayaran',['filter' => 'auth']);
$routes->get('/printjurnal', 'Laporan::printjurnal',['filter' => 'auth']);
$routes->get('/pendapatan', 'Pendapatan::index',['filter' => 'auth']);
$routes->post('/savependapatan', 'Pendapatan::savependapatan',['filter' => 'auth']);
$routes->get('/updatejurnalpinjaman', 'Laporan::updatejurnalpinjaman',['filter' => 'auth']);
$routes->get('/savependapatan', 'Pendapatan::savependapatan',['filter' => 'auth']);
$routes->post('/deletependapatan', 'Pendapatan::deletependapatan',['filter' => 'auth']);
$routes->get('/printpendapatan', 'Pendapatan::printpendapatan',['filter' => 'auth']);
$routes->get('/approvestatus', 'Datapinjaman::approvestatus',['filter' => 'auth']);

$routes->get('/pengeluaran', 'Pengeluaran::index',['filter' => 'auth']);
$routes->post('/savepengeluaran', 'Pengeluaran::save');
$routes->post('/deletepengeluaran', 'Pengeluaran::delete');
$routes->get('/printpengeluaran', 'Pengeluaran::print',['filter' => 'auth']);
$routes->get('/printkelengkapanpinjaman', 'Datapinjaman::printkelengkapanpinjaman',['filter' => 'auth']);
$routes->get('/lapsimpanan', 'Laporan::report_simpanan',['filter' => 'auth']);
$routes->get('/addbungadeposito', 'Datasimpanan::addbungadeposito');
$routes->get('/listsimpanan', 'Datasimpanan::listsimpanan');
$routes->get('/tarikbunga', 'Datasimpanan::tarikbunga');
$routes->post('/tariktabungan', 'Datasimpanan::tarikbunga');
$routes->get('/printdataangsuran', 'Pengajuanpinjaman::buktiangsuran');
//$routes->get('/tagihanmingguan', 'Datatagihan::getTagihanMingguan',['filter' => 'auth']);
$routes->post('/capture', 'Webcam::capture');
$routes->get('/show/(:segment)', 'Webcam::show/$1');
$routes->get('/tagihanbulanan', 'Tagihan::bulanan',['filter' => 'auth']);
$routes->get('/printtagihanbulanan', 'Tagihan::printbulanan',['filter' => 'auth']);
$routes->get('/tagihanmingguan', 'Tagihan::mingguan',['filter' => 'auth']);
$routes->get('/printtagihanmingguan', 'Tagihan::printmingguan',['filter' => 'auth']);
$routes->get('/submitreport', 'Tagihan::submitreport',['filter' => 'auth']);
$routes->get('/printpembayaran', 'Printtext::printpembayaran',['filter' => 'auth']);
$routes->post('/savekunjungan', 'Tagihan::savekunjungan',['filter' => 'auth']);
$routes->get('/neraca', 'Laporan::neraca');
$routes->get('/lock', 'Home::lock');
$routes->get('/unlock', 'Home::unlock');

$routes->post('/approvedata', 'Datapinjaman::approvedata',['filter' => 'auth']);
$routes->post('/simpankartuhilang', 'Datapinjaman::simpankartuhilang',['filter' => 'auth']);
$routes->get('/dataselisih', 'Datapinjaman::dataselisih',['filter' => 'auth']);
$routes->post('/simpanselisih', 'Datapinjaman::simpanselisih',['filter' => 'auth']);
$routes->post('/hapusselisih', 'Datapinjaman::hapusselisih',['filter' => 'auth']);
$routes->post('/submitselisih', 'Datapinjaman::submitselisih',['filter' => 'auth']);
$routes->post('/simpanabsen', 'Absensi::save',['filter' => 'auth']);
$routes->get('/takephoto', 'Pengajuanpinjaman::takephoto',['filter' => 'auth']);
$routes->post('/savedetailpengajuan', 'Pengajuanpinjaman::savedetail',['filter' => 'auth']);
$routes->get('/modules', 'Member::modules',['filter' => 'auth']);
$routes->post('/tambahmodule', 'Member::tambahmodule',['filter' => 'auth']);
$routes->get('/usermodules', 'Member::usermodules',['filter' => 'auth']);
$routes->post('/saveusermodules', 'Member::saveusermodules',['filter' => 'auth']);
$routes->post('/deleteusermodule', 'Member::deleteusermodule',['filter' => 'auth']);
$routes->get('/datauser', 'Member::datauser',['filter' => 'auth']);
$routes->post('/tambahuser', 'Member::tambahuser',['filter' => 'auth']);
$routes->post('/deleteuser', 'Member::deleteuser',['filter' => 'auth']);
$routes->get('/dataabsensi', 'Absensi::dataabsensi',['filter' => 'auth']);
$routes->get('/getdataabsensi', 'Absensi::getdataabsensi',['filter' => 'auth']);
$routes->get('/getdatatitipan', 'Titipan::getdatatitipan',['filter' => 'auth']);
$routes->get('/datatitipan', 'Titipan::datatitipan',['filter' => 'auth']);
$routes->post('/savetitipan', 'Titipan::savetitipan',['filter' => 'auth']);
$routes->get('/getsaldouser', 'Titipan::getsaldouser',['filter' => 'auth']);
$routes->post('/savepelunasan', 'Titipan::savepelunasan',['filter' => 'auth']);
$routes->get('/laporankas', 'Laporan::laporankas',['filter' => 'auth']);
$routes->get('/printlaporankas', 'Laporan::printlaporankas',['filter' => 'auth']);
$routes->post('/simpankasharian', 'Laporan::simpankasharian',['filter' => 'auth']);

//tabungan 
$routes->get('/data-tabungan', 'Tabungan::datatabungan',['filter' => 'auth']);
$routes->post('/tambahnasabahtabungan', 'Tabungan::tambahnasabah',['filter' => 'auth']);
$routes->post('/tambahtabungan', 'Tabungan::tambahtabungan',['filter' => 'auth']);
$routes->get('/rekap-tabungan', 'Tabungan::rekaptabungan',['filter' => 'auth']);
$routes->get('/rekap-penarikan', 'Tabungan::rekapwithdraw',['filter' => 'auth']);
$routes->get('/approvetabungan', 'Tabungan::approvetabungan',['filter' => 'auth']);
//module kunjungawajib
$routes->get('/kunjunganwajib', 'Kunjunganwajib::index',['filter' => 'auth']);
$routes->get('/carianggotawajib', 'Kunjunganwajib::carianggota',['filter' => 'auth']);
$routes->post('/tambahkunjunganwajib', 'Kunjunganwajib::addkunjungan',['filter' => 'auth']);
$routes->get('/tanganiwajib', 'Kunjunganwajib::tangani',['filter' => 'auth']);
$routes->post('/savekunjunganwajib', 'Kunjunganwajib::savetangani',['filter' => 'auth']);
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
