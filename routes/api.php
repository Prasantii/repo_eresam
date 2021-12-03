<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers\Api',], function ($api) {
        
        $api->post('/get_wajib_retribusi/detailcode/{code}', 'PetugasApiController@get_wajib_retribusidetailcode');

        
        //--------------------USER-------------------------
        $api->post('/petugas/login', 'PetugasApiController@login');
        $api->post('/petugas/register', 'PetugasApiController@register');
        
        // $api->get('/petugas/sms-verify/{id}/{code}', 'UserController@sms_verify');
        // $api->get('/user/emailverify/{tokenemail}', 'UserController@token_verify');
        // $api->post('/user/resend-email/{id}', 'UserController@resend_email');
    
        $api->post('/petugas/get_koordinator', 'PetugasApiController@get_koordinator');
        $api->post('/petugas/profile/{id}', 'PetugasApiController@get_profile');
        $api->post('/petugas/editprofile/{id}', 'PetugasApiController@editprofile');
        $api->post('/petugas/editprofilephoto/{id}', 'PetugasApiController@editprofilephoto'); /// new

        $api->post('/petugas/editpasword/{id}', 'PetugasApiController@editpasword'); /// new

        $api->post('/petugas/resend_email/{id}', 'PetugasApiController@resend_email');

        $api->post('/petugas/get_wajib_retribusi/{id_gampong}', 'PetugasApiController@get_wajib_retribusi');
        $api->post('/petugas/get_wajib_retribusi/detail/{code}', 'PetugasApiController@get_wajib_retribusidetail');
        $api->post('/petugas/get_wr_bynik', 'PetugasApiController@get_wr_bynik');//new
        $api->post('/petugas/search_data_gampong', 'PetugasApiController@search_data_gampong');//new
        $api->post('/petugas/get_data_bukti/{id}', 'PetugasApiController@get_data_bukti');//new
        $api->post('/petugas/get_data_bukti_search/{id}', 'PetugasApiController@get_data_bukti_search');
        
        $api->post('/petugas/verifikasi_upload/{idbukti}', 'PetugasApiController@verifikasi_upload');//new
        $api->post('/petugas/tolak_bukti/{idbukti}', 'PetugasApiController@tolak_bukti');//new
        $api->post('/petugas/bayartagihan_manual/{code}', 'PetugasApiController@bayartagihan_manual');//new

        $api->post('/petugas/get_wr_bynik_bulan_ini', 'PetugasApiController@get_wr_bynik_bulan_ini');//new

        $api->post('/petugas/get_lokasi/{id}', 'PetugasApiController@get_lokasi');
        $api->post('/petugas/get_upah/{id}', 'PetugasApiController@get_upah');
        
        $api->post('/petugas/get_data_wr_status', 'PetugasApiController@get_data_wr_status');
        $api->post('/petugas/get_data_wr_status_search', 'PetugasApiController@get_data_wr_status_search');
        $api->post('/petugas/get_data_wr_status_bypetugas_search', 'PetugasApiController@get_data_wr_status_bypetugas_search');
        
        $api->post('/petugas/verifikasi_detail_data_wr/{id}', 'PetugasApiController@verifikasi_detail_data_wr');
        $api->post('/petugas/verifikasi_data_wr/{id}', 'PetugasApiController@verifikasi_data_wr');
        $api->post('/petugas/verifikasi_photo_rumah/{id}', 'PetugasApiController@verifikasi_photo_rumah');
        
        $api->post('/petugas/reset_password_wr/{id}', 'PetugasApiController@reset_password_wr');
        
        $api->post('/petugas/get_resi_bywr/{id}', 'PetugasApiController@get_resi_bywr');
        $api->post('/petugas/get_resi_bywr_detail/{id}', 'PetugasApiController@get_resi_bywr_detail');
        
        $api->post('/petugas/get_data_pembayaran/{id}', 'PetugasApiController@get_data_pembayaran');

    
        //--------------------WR-------------------------
        $api->post('/wajib_retribusi/login', 'WajibRetribusiApiController@login');
        $api->post('/wajib_retribusi/register', 'WajibRetribusiApiController@register');
        $api->post('/wajib_retribusi/addphotohouse/{id}', 'WajibRetribusiApiController@addphotohouse');///new
        $api->post('/wajib_retribusi/editpasword/{id}', 'WajibRetribusiApiController@editpasword'); /// new

        $api->post('/wajib_retribusi/get_district', 'WajibRetribusiApiController@get_district');
        $api->post('/wajib_retribusi/get_villages/{district_id}', 'WajibRetribusiApiController@get_villages');
        $api->post('/wajib_retribusi/jenis_retribusi/{jenis}', 'WajibRetribusiApiController@get_jenis_retribusi');

        $api->post('/wajib_retribusi/profile/{id}', 'WajibRetribusiApiController@get_profile');
        $api->post('/wajib_retribusi/editprofile/{id}', 'WajibRetribusiApiController@editprofile');///new
        $api->post('/wajib_retribusi/editprofilephoto/{id}', 'WajibRetribusiApiController@editprofilephoto');///new
        $api->post('/wajib_retribusi/editprofilephotohouse/{id}', 'WajibRetribusiApiController@editprofilephotohouse');///new
        $api->post('/wajib_retribusi/tagihan_wrbyid/{id}', 'WajibRetribusiApiController@tagihan_wrbyid');
        $api->post('/wajib_retribusi/tagihan_belumbayar/{id}', 'WajibRetribusiApiController@tagihan_belumbayar');

        $api->post('/wajib_retribusi/upload_bukti/{id}', 'WajibRetribusiApiController@upload_bukti');
        
        // $api->post('/wajib_retribusi/resend_email/{id}', 'WajibRetribusiApiController@resend_email');
        
        $api->post('/wajib_retribusi/get_resi/{id}', 'WajibRetribusiApiController@get_resi');
        $api->post('/wajib_retribusi/get_resi_detail/{id}', 'WajibRetribusiApiController@get_resi_detail');

    });
});



