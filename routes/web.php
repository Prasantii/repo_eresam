<?php
use App\Http\Controllers\WajibRetribusiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home','newController@home');
Route::get('/home/read','newController@read');
Route::get('/home/search','newController@search');
//Route::get('/home/ajax','newController@ajax')->name('cari');


/*
    Route::get('/new' , 'newController@search');
    //Route::view('/test',('test'));
    //Route::get('test' , 'Admin\TagihanWajibController@test');
    Route::get('/test' , 'testcontroller@TagihanWr');
    Route::post('/test/test_data' , 'testcontroller@data_TagihanWr');

    //Route::get('/test1/cari' , 'testcontroller@cari');
    //Route::get('/test1' , 'fixController@data1');
    //Route::get('/test1' , 'testcontroller@');
   // Route::get('/test1' , 'testcontroller@index');
 //   Route::get('/test1/cari' , 'fixController@cari');

Route::get('/coba', 'fixController@data1');
    //Route::get('/test' , [testcontroller::class,'TagihanWrKeseluruhanData']);


*/
//COBA LAGI


Route::get('/', 'LoginControllers@login');
// Route::get('/dashboard', 'LoginControllers@index');

Route::get('/devadmin/login' , 'LoginControllers@login');
Route::post('/devadmin/login/verify' , array('as' => 'Login', 'uses' => 'LoginControllers@loginverify'));

Route::get('/devadmin/register' , 'LoginControllers@register');
Route::post('/devadmin/register/verify' , array('as' => 'Register', 'uses' => 'LoginControllers@registerverify'));

Route::get('/logout', 'LoginControllers@logout');
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
    //HOME----------------------------------------------------------------------------------------------------------
    Route::get('/devadmin/dashboard', 'Admin\WebController@dashboard');
    Route::get('/devadmin' , 'Admin\WebController@index');
    Route::get('/devadmin/dashboard' , 'Admin\WebController@dashboard');

    Route::post('/devadmin/data_kontrak/data' , 'Admin\WebController@data_kontrakdata');
    
    Route::get('/devadmin/datapegawai/{jenis_kelamin}' , 'Admin\WebController@datapegawaijenis');
    Route::post('/data_pegawai/{jenis_kelamin}' , 'Admin\WebController@data_pegawaijenis');


    //ROLE----------------------------------------------------------------------------------------------------------
    Route::get('/devadmin/role' , 'Admin\WebController@role');
    Route::post('/devadmin/data_role' , 'Admin\WebController@data_role');
    Route::post('/devadmin/tambahroleaksi' , array('as' => 'Tambahrole', 'uses' => 'Admin\WebController@tambahroleaksi'));
    Route::get('/devadmin/editroleview/{id}' , 'Admin\WebController@editroleview');
    Route::post('/devadmin/editroleaksi' , 'Admin\WebController@editroleaksi');
    Route::post('/devadmin/deleterole' , 'Admin\WebController@roledelete');

    Route::get('/devadmin/editroleakses/{id}' , 'Admin\WebController@editroleakses');
    Route::get('/devadmin/editroleaksesaksi' , 'Admin\WebController@editroleaksesaksi');
    Route::post('/devadmin/data_roleakses/{roleid}' , 'Admin\WebController@data_roleakses');

    //MENU MANAGEMENT-------------------------------------------------------------------------------------------------
    Route::get('/menutitle' , 'Admin\WebController@menutitle');
    Route::post('/data_menutitle' , 'Admin\WebController@data_menutitle');
    Route::post('/tambahmenutitleaksi' , array('as' => 'Tambahmenutitle', 'uses' => 'Admin\WebController@tambahmenutitleaksi'));
    Route::get('/editmenutitleview/{id}' , 'Admin\WebController@editmenutitleview');
    Route::post('/editmenutitleaksi' , 'Admin\WebController@editmenutitleaksi');
    Route::post('/deletemenutitle' , 'Admin\WebController@menutitledelete');

    Route::get('/menu' , 'Admin\WebController@menu');
    Route::post('/data_menu' , 'Admin\WebController@data_menu');
    Route::post('/tambahmenuaksi' , array('as' => 'Tambahmenu', 'uses' => 'Admin\WebController@tambahmenuaksi'));
    Route::get('/editmenuview/{id}' , 'Admin\WebController@editmenuview');
    Route::post('/editmenuaksi' , 'Admin\WebController@editmenuaksi');
    Route::post('/deletemenu' , 'Admin\WebController@menudelete');

    Route::get('/menu/submenu' , 'Admin\WebController@submenu');
    Route::post('/menu/data_submenu' , 'Admin\WebController@data_submenu');
    Route::post('/menu/tambahsubmenuaksi' , array('as' => 'Tambahsubmenu', 'uses' => 'Admin\WebController@tambahsubmenuaksi'));
    Route::get('/menu/editsubmenuview/{id}' , 'Admin\WebController@editsubmenuview');
    Route::post('/menu/editsubmenuaksi' , 'Admin\WebController@editsubmenuaksi');
    Route::post('/menu/deletesubmenu' , 'Admin\WebController@submenudelete');

    Route::post('/menu/aktifsubmenu' , 'Admin\WebController@aktifsubmenu');
    Route::post('/menu/nonaktifsubmenu' , 'Admin\WebController@nonaktifsubmenu');

    //MANAJEMENT USER------------------------------------------------------------------------------
    Route::get('/devadmin/manajement/user' , 'Admin\WebController@manajementuser');
    Route::post('/devadmin/data_manajement/user' , 'Admin\WebController@data_manajementuser');
    Route::post('/devadmin/tambahmanajement/useraksi' , array('as' => 'Tambahmanajementuser', 'uses' => 'Admin\WebController@tambahmanajementuseraksi'));
    Route::get('/devadmin/editmanajement/userview/{id}' , 'Admin\WebController@editmanajementuserview');
    Route::post('/devadmin/editmanajement/useraksi' , 'Admin\WebController@editmanajementuseraksi');
    Route::post('/devadmin/deletemanajement/user' , 'Admin\WebController@manajementuserdelete');

    Route::get('/devadmin/editpasswordmanajementview/useraksi/{id}' , 'Admin\WebController@editpassowrdmanajementuserview');
    Route::post('/devadmin/editpasswordmanajement/useraksi' , 'Admin\WebController@editpassowrdmanajementuseraksi');

    Route::post('/devadmin/aktifmanajement/user' , 'Admin\WebController@aktifmanajementuser');
    Route::post('/devadmin/nonaktifmanajement/user' , 'Admin\WebController@nonaktifmanajementuser');

    //PROFILE----------------------------------------------------------------------------------------------------------
    Route::get('/user/profile' , 'Admin\ProfileController@profile');
    Route::get('/user/profile/edit/{id}' , 'Admin\ProfileController@editprofile');
    Route::get('/user/profile/edit' , 'Admin\ProfileController@editprofileses');
    Route::post('/editprofileaksi/{id}' , array('as' => 'Editprofile', 'uses' => 'Admin\ProfileController@editprofileaksi'));

    Route::get('/user/profile/changepassword' , 'Admin\ProfileController@changepasswordses');
    Route::get('/user/profile/changepassword/{id}' , 'Admin\ProfileController@changepassword');

    Route::post('/changepasswordaksi/{id}' , array('as' => 'Editpassword', 'uses' => 'Admin\ProfileController@changepasswordaksi'));


    //DATA ZONA-----------------------------------------------------------------------------------------------
    Route::get('/devadmin/zona' , 'Admin\ZonaController@datazona');
    Route::post('/devadmin/data_zona' , 'Admin\ZonaController@data_zona');

    Route::post('/devadmin/tambahzonaaksi' , array('as' => 'Tambahzona', 'uses' => 'Admin\ZonaController@tambahzonaaksi'));
    Route::get('/devadmin/editzonaview/{id}' , 'Admin\ZonaController@editzonaview');
    Route::post('/devadmin/editzonaaksi' , 'Admin\ZonaController@editzonaaksi');
    Route::post('/devadmin/deletezona' , 'Admin\ZonaController@zonadelete');

    Route::post('/devadmin/aktifzona' , 'Admin\ZonaController@aktifzona');
    Route::post('/devadmin/nonaktifzona' , 'Admin\ZonaController@nonaktifzona');


    //DATA KECAMATAN-----------------------------------------------------------------------------------------
    Route::get('/kecamatan' , 'Admin\ZonaController@kecamatan');
    Route::post('/data_kecamatan' , 'Admin\ZonaController@data_kecamatan');
    Route::post('/tambahkecamatanaksi' , array('as' => 'Tambahkecamatan', 'uses' => 'Admin\ZonaController@tambahkecamatanaksi'));
    Route::get('/editkecamatanview/{id}' , 'Admin\ZonaController@editkecamatanview');
    Route::post('/editkecamatanaksi' , 'Admin\ZonaController@editkecamatanaksi');
    Route::post('/deletekecamatan' , 'Admin\ZonaController@kecamatandelete');

    //DATA GAMPONG-----------------------------------------------------------------------------------------
    Route::get('/devadmin/lokasi' , 'Admin\ZonaController@lokasi');
    Route::post('/data_gampong' , 'Admin\ZonaController@data_gampong');
    Route::post('/tambahgampongaksi' , array('as' => 'Tambahgampong', 'uses' => 'Admin\ZonaController@tambahgampongaksi'));
    Route::get('/editgampongview/{id}' , 'Admin\ZonaController@editgampongview');
    Route::post('/editgampongaksi' , 'Admin\ZonaController@editgampongaksi');
    Route::post('/deletegampong' , 'Admin\ZonaController@gampongdelete');

    //DATA PETUGAS-----------------------------------------------------------------------------------------------
    Route::get('/devadmin/datapetugas' , 'Admin\PetugasController@datapetugas');
    Route::post('/devadmin/data_petugas' , 'Admin\PetugasController@data_petugas');
    Route::get('/devadmin/detail/petugas/{id}' , 'Admin\PetugasController@detailpetugas');

    Route::get('/devadmin/tambahpetugas' , 'Admin\PetugasController@tambahpetugas');
    Route::post('/devadmin/tambahpetugasaksi' , array('as' => 'Tambahpetugas', 'uses' => 'Admin\PetugasController@tambahpetugasaksi'));
    Route::get('/devadmin/editpetugasview/petugas/{id}' , 'Admin\PetugasController@editpetugasview');
    Route::post('/devadmin/editpetugasaksi/{id}' , 'Admin\PetugasController@editpetugasaksi');
    Route::post('/devadmin/petugas/delete' , 'Admin\PetugasController@petugasdelete');

    Route::get('/devadmin/editlokasitugasview/{id}' , 'Admin\PetugasController@editlokasitugasview');
    Route::post('/devadmin/editlokasitugas/{id}' , 'Admin\PetugasController@editlokasitugas');

    Route::post('/devadmin/detail/petugas/aktifpetugas' , 'Admin\PetugasController@aktifpetugas');
    Route::post('/devadmin/detail/petugas/nonaktifpetugas' , 'Admin\PetugasController@nonaktifpetugas');

    Route::post('/devadmin/detail/petugas/aktifpetugas_komersil' , 'Admin\PetugasController@aktifpetugas_komersil');
    Route::post('/devadmin/detail/petugas/aktifpetugas_gampong' , 'Admin\PetugasController@aktifpetugas_gampong');
    
    Route::get('/devadmin/editpasswordpetugasview/{id}' , 'Admin\PetugasController@editpasswordpetugasview');
    Route::post('/devadmin/editpasswordpetugasaksi' , 'Admin\PetugasController@editpasswordpetugasaksi');


    //DATA KOORDINATOR-----------------------------------------------------------------------------------------------
    Route::get('/devadmin/koordinator' , 'Admin\PetugasController@datakoordinator');
    Route::post('/devadmin/data_koordinator' , 'Admin\PetugasController@data_koordinator');
    Route::get('/devadmin/detail/koordinator/{id}' , 'Admin\PetugasController@detailkoordinator');

    Route::get('/devadmin/tambahkoordinator' , 'Admin\PetugasController@tambahkoordinator');
    Route::post('/devadmin/tambahkoordinatoraksi' , array('as' => 'Tambahkoordinator', 'uses' => 'Admin\PetugasController@tambahkoordinatoraksi'));
    Route::get('/devadmin/editkoordinatorview/koordinator/{id}' , 'Admin\PetugasController@editkoordinatorview');
    Route::post('/devadmin/editkoordinatoraksi/{id}' , 'Admin\PetugasController@editkoordinatoraksi');
    Route::post('/devadmin/koordinator/delete' , 'Admin\PetugasController@koordinatordelete');

    Route::post('/devadmin/detail/koordinator/aktifkoordinator' , 'Admin\PetugasController@aktifkoordinator');
    Route::post('/devadmin/detail/koordinator/nonaktifkoordinator' , 'Admin\PetugasController@nonaktifkoordinator');



    //DATA JENIS RETRIBUSI----------------------------------------------------------------------------------
    Route::get('/devadmin/jenis_retribusi' , 'Admin\JenisRetribusiController@jenis_retribusi');
    Route::post('/devadmin/data_jenis_retribusi' , 'Admin\JenisRetribusiController@data_jenis_retribusi');
    Route::get('/devadmin/detail/jenis_retribusi/{id}' , 'Admin\JenisRetribusiController@detailjenis_retribusi');

    Route::get('/devadmin/tambahjenis_retribusi' , 'Admin\JenisRetribusiController@tambahjenis_retribusi');
    Route::post('/devadmin/tambahjenis_retribusiaksi' , array('as' => 'Tambahjenis_retribusi', 'uses' => 'Admin\JenisRetribusiController@tambahjenis_retribusiaksi'));
    Route::get('/devadmin/editjenis_retribusiview/jenis_retribusi/{id}' , 'Admin\JenisRetribusiController@editjenis_retribusiview');
    Route::post('/devadmin/editjenis_retribusiaksi/{id}' , 'Admin\JenisRetribusiController@editjenis_retribusiaksi');
    Route::post('/devadmin/jenis_retribusi/delete' , 'Admin\JenisRetribusiController@jenis_retribusidelete');

    Route::post('/devadmin/detail/jenis_retribusi/aktifjenis_retribusi' , 'Admin\JenisRetribusiController@aktifjenis_retribusi');
    Route::post('/devadmin/detail/jenis_retribusi/nonaktifjenis_retribusi' , 'Admin\JenisRetribusiController@nonaktifjenis_retribusi');

    //DATA WAJIB RETRIBUSI----------------------------------------------------------------------------------
    Route::get('/devadmin/wajib_retribusi' , 'Admin\WajibRetribusiController@WajibRetribusi');
    Route::post('/devadmin/data_wajib_retribusi' , 'Admin\WajibRetribusiController@data_WajibRetribusi');
    Route::post('/devadmin/data_wajib_retribusi_gampong' , 'Admin\WajibRetribusiController@data_WajibRetribusigampong');
    Route::post('/devadmin/data_WajibRetribusinotverifikasi' , 'Admin\WajibRetribusiController@data_WajibRetribusinotverifikasi');
    Route::get('/devadmin/detail/wajib_retribusi/{id}' , 'Admin\WajibRetribusiController@detailWajibRetribusi');

    Route::get('/devadmin/tambahwajib_retribusi' , 'Admin\WajibRetribusiController@tambahWajibRetribusi');
    Route::post('/devadmin/tambahwajib_retribusiaksi' , array('as' => 'Tambahwajib_retribusi', 'uses' => 'Admin\WajibRetribusiController@tambahWajibRetribusiaksi'));
    Route::get('/devadmin/editwajib_retribusiview/wajib_retribusi/{id}' , 'Admin\WajibRetribusiController@editWajibRetribusiview');
    Route::post('/devadmin/editwajib_retribusiaksi/{id}' , 'Admin\WajibRetribusiController@editWajibRetribusiaksi');
    Route::post('/devadmin/wajib_retribusi/delete' , 'Admin\WajibRetribusiController@WajibRetribusidelete');

    Route::post('/devadmin/detail/wajib_retribusi/aktifwajib_retribusi' , 'Admin\WajibRetribusiController@aktifWajibRetribusi');
    Route::post('/devadmin/detail/wajib_retribusi/nonaktifwajib_retribusi' , 'Admin\WajibRetribusiController@nonaktifWajibRetribusi');

    Route::get('/devadmin/editpasswordwrview/{id}' , 'Admin\WajibRetribusiController@editpasswordwrview');
    Route::post('/devadmin/editpasswordwraksi' , 'Admin\WajibRetribusiController@editpasswordwraksi');

    route::get('/devadmin/wajib_retribusiPrint1','WajibRetribusiController@wrPrint1');

    //new
    Route::get('/devadmin/wajib_retribusi/cetakWr', 'Admin\WajibRetribusiController@cetak')->name('cetak');
    Route::get('/devadmin/wajib_retribusi/cetakWr2', 'Admin\WajibRetribusiController@cetak_2');
    Route::get('/devadmin/wajib_retribusi/cetakWr3', 'Admin\WajibRetribusiController@cetak_3');

    //===========================================import======================================
    Route::post('/devadmin/wajib_retribusi/importGampong','Admin\WajibRetribusiController@importGampong')->name('import.gampong');
    
    //Route::get('/devadmin/wajib_retribusi/download','Admin\WajibRetribusiController@downloadFile');

    Route::get('/devadmin/wajib_retribusi/download',
     function(){
         $file =public_path()."\uploads\import\Format.xlsx";
         $headers =array('Content-Type' => 'application/xlsx',); 
        return Response::download($file,"Format.xlsx",$headers);
     });


    //DATA TAGIHAN WAJIB RETRIBUSI-----------------------------------------------------
   Route::get('/devadmin/tagihan_wr', 'Admin\TagihanWajibController@TagihanWr');
    Route::post('/devadmin/data_tagihan_wr', 'Admin\TagihanWajibController@data_TagihanWr');
    Route::get('/devadmin/detail/tagihan_wr/keseluruhan/{id}', 'Admin\TagihanWajibController@TagihanWrKeseluruhan');
    Route::post('/devadmin/data_tagihan_wr/keseluruhandata/{id}', 'Admin\TagihanWajibController@TagihanWrKeseluruhanData');

    Route::get('/devadmin/tambahtagihan_wr', 'Admin\TagihanWajibController@tambahTagihanWr');
    Route::post('/devadmin/tambahtagihan_wraksi', array('as' => 'Tambahtagihan_wr', 'uses' => 'Admin\TagihanWajibController@tambahTagihanWraksi'));
    Route::get('/devadmin/edittagihan_wrview/tagihan_wr/{id}', 'Admin\TagihanWajibController@editTagihanWrview');
    Route::post('/devadmin/edittagihan_wraksi/{id}', 'Admin\TagihanWajibController@editTagihanWraksi');
    Route::post('/devadmin/tagihan_wr/delete', 'Admin\TagihanWajibController@TagihanWrdelete');

    Route::post('/devadmin/detail/tagihan_wr/aktiftagihan_wr', 'Admin\TagihanWajibController@aktifTagihanWr');
    Route::post('/devadmin/detail/tagihan_wr/nonaktiftagihan_wr', 'Admin\TagihanWajibController@nonaktifTagihanWr');

    

    
    //DATA BUKTI WAJIB RETRIBUSI-----------------------------------------------------
    Route::get('/devadmin/bukti_pembayaran' , 'Admin\DataBukti@DataBukti');
    Route::post('/devadmin/data_bukti_pembayaran' , 'Admin\DataBukti@data_DataBukti');
    Route::get('/devadmin/detail/bukti_pembayaran/keseluruhan/{id}' , 'Admin\DataBukti@DataBuktiKeseluruhan');
    Route::post('/devadmin/data_bukti_pembayaran/keseluruhandata/{id}' , 'Admin\DataBukti@DataBuktiKeseluruhanData');

    Route::get('/devadmin/tambahbukti_pembayaran' , 'Admin\DataBukti@tambahDataBukti');
    Route::post('/devadmin/tambahbukti_pembayaranaksi' , array('as' => 'Tambahbukti_pembayaran', 'uses' => 'Admin\DataBukti@tambahDataBuktiaksi'));
    Route::get('/devadmin/editbukti_pembayaranview/bukti_pembayaran/{id}' , 'Admin\DataBukti@editDataBuktiview');
    Route::post('/devadmin/editbukti_pembayaranaksi/{id}' , 'Admin\DataBukti@editDataBuktiaksi');
    Route::post('/devadmin/bukti_pembayaran/delete' , 'Admin\DataBukti@DataBuktidelete');

    Route::post('/devadmin/detail/bukti_pembayaran/aktifbukti_pembayaran' , 'Admin\DataBukti@aktifDataBukti');
    Route::post('/devadmin/detail/bukti_pembayaran/nonaktifbukti_pembayaran' , 'Admin\DataBukti@nonaktifDataBukti');


    //DATA TAGIHAN WAJIB RETRIBUSI-----------------------------------------------------
    Route::get('/devadmin/upah_pungut' , 'Admin\DataBukti@UpahPungut');
    Route::post('/devadmin/data_upah_pungut' , 'Admin\DataBukti@data_UpahPungut');
    Route::get('/devadmin/detail/upah_pungut/keseluruhan/{id}' , 'Admin\DataBukti@UpahPungutKeseluruhan');
    Route::post('/devadmin/data_upah_pungut/keseluruhandata/{id}' , 'Admin\DataBukti@UpahPungutKeseluruhanData');

    Route::get('/devadmin/tambahupah_pungut' , 'Admin\DataBukti@tambahUpahPungut');
    Route::post('/devadmin/tambahupah_pungutaksi' , array('as' => 'Tambahupah_pungut', 'uses' => 'Admin\DataBukti@tambahUpahPungutaksi'));
    Route::get('/devadmin/editupah_pungutview/upah_pungut/{id}' , 'Admin\DataBukti@editUpahPungutview');
    Route::post('/devadmin/editupah_pungutaksi/{id}' , 'Admin\DataBukti@editUpahPungutaksi');
    Route::post('/devadmin/upah_pungut/delete' , 'Admin\DataBukti@UpahPungutdelete');

    Route::post('/devadmin/detail/upah_pungut/aktifupah_pungut' , 'Admin\DataBukti@aktifUpahPungut');
    Route::post('/devadmin/detail/upah_pungut/nonaktifupah_pungut' , 'Admin\DataBukti@nonaktifUpahPungut');
    
    //LAPORAN KEUANGAN-----------------------
    Route::get('/devadmin/laporan/keuangan' , 'Admin\LaporanController@LaporanKeuangan');
    Route::post('/devadmin/laporan/keuangan/data' , 'Admin\LaporanController@LaporanKeuanganData');

    Route::get('/devadmin/laporan/keuangan/print', 'Admin\LaporanController@LaporanKeuanganPrint');
    Route::get('/devadmin/laporan/keuangan/export', 'Admin\LaporanController@LaporanKeuanganExport');
    
    //LOKASI PETUGAS----------------------------------------------------------------------------------
    Route::get('/devadmin/lokasi_petugas' , 'Admin\LaporanController@lokasi_petugas');
    
    Route::get('/devadmin/cetak_qrcode' , 'Admin\WajibRetribusiController@cetak_qrcode');
    Route::get('/devadmin/cetak_qrcode/print' , 'Admin\WajibRetribusiController@cetak_qrcodePrint');
    
    //PROGRESS BY DATA VERIFIKASI-----------------------
    Route::get('/devadmin/laporan/verifikasidata' , 'Admin\LaporanController@Laporanverifikasidata');
    Route::post('/devadmin/laporan/verifikasidata/data' , 'Admin\LaporanController@LaporanverifikasidataData');

    Route::get('/devadmin/laporan/verifikasidata/print', 'Admin\LaporanController@LaporanverifikasidataPrint');
    Route::get('/devadmin/laporan/verifikasidata/export', 'Admin\LaporanController@LaporanverifikasidataExport');

    //PROGRESS DATA SUDAH DI VERIFIKASI PETUGAS-----------------------
    Route::get('/devadmin/laporan/sudahverifikasidata' , 'Admin\LaporanController@Laporansudahverifikasidata');
    Route::post('/devadmin/laporan/sudahverifikasidata/data' , 'Admin\LaporanController@LaporansudahverifikasidataData');

    Route::get('/devadmin/laporan/sudahverifikasidata/print', 'Admin\LaporanController@LaporansudahverifikasidataPrint');
    Route::get('/devadmin/laporan/sudahverifikasidata/export', 'Admin\LaporanController@LaporansudahverifikasidataExport');

    //newtesexport
    Route::get('/devadmin/laporan/sudahverifikasidataExcel', 'Admin\LaporanController@LaporansudahverifikasidataExport')->name('export');

    Route::get('/export/excel', 'LaporanController@exportExcel');
    
});


Route::post('/get_reg' , 'Admin\WajibRetribusiController@get_reg');
Route::post('/get_dist' , 'Admin\WajibRetribusiController@get_dist');
Route::post('/get_vill' , 'Admin\WajibRetribusiController@get_vill');

Route::post('/get_dist_edit' , 'Admin\WajibRetribusiController@get_dist_edit');
Route::post('/get_vill_edit' , 'Admin\WajibRetribusiController@get_vill_edit');

Route::post('/get_koordinator' , 'Admin\PetugasController@get_koordinator');
Route::post('/get_dist_koordinator' , 'Admin\PetugasController@get_dist_koordinator');
Route::post('/get_vill_koordinator' , 'Admin\PetugasController@get_vill_koordinator');