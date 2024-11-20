<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/landing_page', 'Login\UserController::index');
$routes->get('/signup', 'Login\UserController::signup');
$routes->post('/createuser', 'Login\UserController::createuser');
$routes->get('/edituser/(:any)', 'Login\UserController::edituser/$1');
$routes->post('/updateuser/(:any)', 'Login\UserController::updateuser/$1');
$routes->get('/deleteuser/(:any)', 'Login\UserController::deleteuser/$1');
$routes->get('/gantipass/(:any)', 'Login\UserController::gantipass/$1');
$routes->post('/simpanpass/(:any)', 'Login\UserController::simpanpass/$1');

$routes->get('/', 'Login\AuthController::index');
$routes->post('/login', 'Login\AuthController::login');
$routes->get('/logout', 'Login\AuthController::logout');
$routes->get('/daftar-izin', 'HR\IzinController::rekapHariIni');

$routes->get('/reg-maklon', 'RegistrasiController::index');
$routes->post('/registrasi/create', 'RegistrasiController::create');
$routes->post('/registrasi/store', 'RegistrasiController::store');
//$routes->get('/registrasi/edit/(:segment)', 'RegistrasiController::edit/$1');
$routes->post('/registrasi/update/(:segment)', 'RegistrasiController::update/$1');
$routes->delete('/registrasi/delete/(:segment)', 'RegistrasiController::delete/$1');

$routes->get('/prog-maklon', 'ProgressController::index');
$routes->get('/progress/create', 'ProgressController::create');
$routes->post('/progress/store', 'ProgressController::store');
$routes->get('/progress/edit/(:segment)', 'ProgressController::edit/$1');
$routes->post('/progress/update/(:segment)', 'ProgressController::update/$1');
//$routes->delete('/progress/delete/(:segment)', 'ProgressController::delete/$1');
$routes->delete('/progress/delete/(:num)', 'ProgressController::delete/$1');

$routes->get('/admin', 'AdminController::index');
$routes->post('/admin/create', 'AdminController::create');
$routes->post('/admin/update/(:any)', 'AdminController::update/$1');
// $routes->get('admin', 'AdminController::index');
$routes->get('/admin/delete/(:num)', 'AdminController::delete/$1');

$routes->get('/izin/(:any)', 'HR\IzinController::index/$1');
$routes->get('/izin_security/(:any)', 'HR\IzinController::izin_security/$1');
$routes->post('/hr/izin/create', 'HR\IzinController::create');
$routes->get('/hr/izin/history/(:any)', 'HR\IzinController::history/$1');
$routes->get('/hr/izin/batal/(:any)', 'HR\IzinController::batal/$1');

$routes->post('/hr/cuti/batal/(:any)', 'HR\CutiController::batal/$1');
$routes->get('/cuti', 'HR\CutiController::index');
$routes->get('/cuti-security/(:any)', 'HR\CutiController::cuti_security/$1');
$routes->get('/cuti/spesial', 'HR\CutiController::cuti_spesial');
$routes->get('/hr/cuti/bersama', 'HR\CutiController::cuti_bersama');
$routes->post('/hr/cuti/input_cuti_bersama', 'HR\CutiController::input_cuti_bersama');
$routes->get('/hr/cuti/hapus_cuti_bersama/(:any)', 'HR\CutiController::hapus_cuti_bersama/$1');
$routes->post('/hr/cuti_spesial/create', 'HR\CutiController::create_cuti_spesial');
$routes->post('hr/cuti/submit', 'HR\CutiController::submit');
$routes->get('/hr/cuti/history/(:any)', 'HR\CutiController::history/$1');
$routes->get('/input_hak_cuti', 'HR\CutiController::input_hak_cuti');
$routes->post('/input_hc_all', 'HR\CutiController::input_hc_all');
$routes->post('/hapus_periode', 'HR\CutiController::hapus_periode');
$routes->post('/per_nik', 'HR\InputController::per_nik');
$routes->post('user/getUserByNik', 'HR\InputController::getUserByNik'); // Route untuk request AJAX

$routes->get('/hr/input/ganti_hari', 'HR\InputController::ganti_hari');
$routes->post('/hr/input/submit_ganti_hari', 'HR\InputController::submit_ganti_hari');
$routes->post('/hr/input/reset_ganti_hari/(:any)', 'HR\InputController::reset_ganti_hari/$1');
$routes->get('/hr/input/jadwal_security', 'HR\InputController::jadwal_security');
$routes->post('/hr/input/regu_security', 'HR\InputController::regu_security');
$routes->post('/hr/input/csv_security', 'HR\InputController::csv_security');
$routes->get('/hr/input/jadwal-security-plant-2', 'HR\InputController::jadwal_security_plant2');

$routes->get('/hr/rekap/kehadiran', 'HR\RekapController::rekap');
$routes->get('/hr/rekap/hari_ini', 'HR\RekapController::hari_ini');
$routes->post('/hr/rekap/kehadiran/excel', 'HR\RekapController::excel');
$routes->post('/hr/rekap/kehadiran/filter', 'HR\RekapController::rekap');
$routes->get('/hr/rekap/departemen', 'HR\RekapController::rekap_dept');
$routes->get('/info/kehadiran', 'HR\RekapController::rekap_dept');
$routes->get('/hr/rekap/cut-off', 'HR\RekapController::cut_off');

$routes->get('/approval', 'HR\IzinController::approval');
$routes->post('/approval_satu/(:any)', 'HR\IzinController::approval_satu/$1');
$routes->post('/approval_hr/(:any)', 'HR\IzinController::approval_hr/$1');

$routes->get('/berita_acara/batal_cuti_izin', 'BeritaAcara\HRController::batal_cuti_izin');
$routes->post('/berita_acara/ajukan_batal_izin', 'BeritaAcara\HRController::ajukan_batal_izin');
$routes->post('/berita_acara/ajukan_batal_cuti', 'BeritaAcara\HRController::ajukan_batal_cuti');
$routes->get('/berita_acara/batalkan_cuti_izin', 'BeritaAcara\HRController::batalkan_cuti_izin');
$routes->post('/berita_acara/batalkan_by_hr', 'BeritaAcara\HRController::batalkan_by_hr');
$routes->get('/tolak-berita-acara', 'BeritaAcara\HRController::tolak');

$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/dashboard/form-surat-cuti', 'DashboardController::createSuratCuti');
$routes->post('/dashboard/store-surat-cuti', 'DashboardController::storeSuratCuti');

// ======================
$routes->get('rekap-kehadiran/export-excel', 'RekapController::exportExcel');
$routes->get('/karyawan-izin', 'RekapHariIni::rekapHariIniTL');
$routes->get('/info/penerimaan-paket', 'Info\LogbookController::penerimaanPaket');
$routes->post('/info/pengambilan-paket', 'Info\LogbookController::pengambilanPaket');
$routes->get('/info/history-paket', 'Info\LogbookController::historyPaket');
