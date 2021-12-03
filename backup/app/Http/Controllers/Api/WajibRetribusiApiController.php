<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use View;
use DB;
use Validator;
use Response;
use Hash;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Http\Models\Admin;
use App\Http\Models\Role;
use App\Http\Models\Aksesmenu;
use App\Http\Models\Submenu;
use App\Http\Models\TitleMenu;
use App\Http\Models\Token;
use App\Http\Models\Icons;

use App\Http\Models\Districts;
use App\Http\Models\Provinces;
use App\Http\Models\Regencies;
use App\Http\Models\Villages;
use App\Http\Models\Zona;
use App\Http\Models\Koordinator;
use App\Http\Models\Petugas;
use App\Http\Models\PetugasEmailVer;

use App\Http\Models\JenisRetribusi;
use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;
use App\Http\Models\Tagihan;
use App\Http\Models\UploadBukti;

use App\Transformers\ErorValidasiTransformer;
use App\Transformers\ErorrTransformer;
use App\Transformers\PetugasTransformer;
use App\Transformers\KoordinatorTransformer;
use App\Transformers\WajibRetribusiTransformer;
use App\Transformers\DistrictsTransformer;
use App\Transformers\VillagesTransformer;
use App\Transformers\JenisRetribusiTransformer;
use App\Transformers\TagihanTransformer;
use App\Transformers\BuktiTransformer;


use Spatie\Fractalistic\ArraySerializer;
use Helperss;
use Image;
use Mail;

use QrCode;
use Storage;

use DateTime;
use DateInterval;
use DatePeriod;



class WajibRetribusiApiController extends Controller
{
    public function getHash($password){
        $salt       = sha1(rand());
        $salt       = substr($salt, 0, 10);
        $encrypted  = password_hash($password.$salt, PASSWORD_DEFAULT);
        $hash       = array("salt" => $salt, "encrypted" => $encrypted);

        return $hash;
    }

    public function verifyHash($password, $hash){
        return password_verify($password, $hash);
    }

    //WR --------------------------------------------------


    public function login(Request $request){
        $validator = Validator::make($request->all(), 
            
            array(  'username'         => 'required',
                    'password'         => 'required',
                ), 
            array(  
                    'username.required' => 'Username / Email Wajib Diisi!',
                    'password.required' => 'Password Wajib Diisi!',
                )
        );

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response = fractal()
                ->item($error_messages)
                ->transformWith(new ErorValidasiTransformer)
                ->toArray();

            return response()->json($response, 401);

                 
        }else{
            $username = $request->username;
            $password = $request->password;
            
            $warr = WajibRetribusi::where('username',$username)->orWhere('email', $username)->first();
            
            if($warr){
                $db_encrypted_password = $warr->password;
                $salt = $warr->salt;

                $hasil_pass = $this->verifyHash($password.$salt,$db_encrypted_password);
                if($hasil_pass) {
                    if($warr->is_active == 1){
                        $warr->token = Helperss::generate_token();
                        $warr->token_expiry = Helperss::generate_expiry();
                        $warr->save();
                        $respone =  fractal()
                            ->item($warr)
                            ->transformWith(new WajibRetribusiTransformer)
                            ->serializeWith(new ArraySerializer)
                            ->toArray();

                        return response()->json($respone, 200);
                    }else{
                        $messages = 1013;
                        $respone =  fractal()
                            ->item($messages)
                            ->transformWith(new ErorrTransformer)
                                
                            ->toArray();
                        return response()->json($respone, 411);
                    }
                }else{
                    $messages = 1007;
                    $respone =  fractal()
                        ->item($messages)
                        ->transformWith(new ErorrTransformer)
                            
                        ->toArray();
                    return response()->json($respone, 411);
                }
                
                $message['owner']['success'] = true;
                return response()->json($message, 200);   
                
            }else{
                $messages = 1006;
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)
                        
                    ->toArray();
                return response()->json($respone, 411);    
            }
        }
    }

    public function get_district(Request $request){
      $districts = Districts::where('regency_id', '=', '1171')->get();

      if($districts){
          $respone =  fractal()
              ->collection($districts)
              ->transformWith(new DistrictsTransformer)
              ->serializeWith(new ArraySerializer)
              ->toArray();
          return response()->json($respone, 200);
      }else{
          $messages = 'errors server!';
          $respone =  fractal()
              ->item($messages)
              ->transformWith(new ErorrTransformer)      
              ->toArray();
          return response()->json($respone, 401);
      }
    }

    public function get_villages(Request $request,$district_id){
      $villages = Villages::where('district_id', '=', $district_id)->get();

      if($villages){
          $respone =  fractal()
              ->collection($villages)
              ->transformWith(new VillagesTransformer)
              ->serializeWith(new ArraySerializer)
              ->toArray();
          return response()->json($respone, 200);
      }else{
          $messages = 'errors server!';
          $respone =  fractal()
              ->item($messages)
              ->transformWith(new ErorrTransformer)      
              ->toArray();
          return response()->json($respone, 401);
      }
    }

    public function get_jenis_retribusi(Request $request){
      $jenis_retribusi = JenisRetribusi::get();

      if($jenis_retribusi){
          $respone =  fractal()
              ->collection($jenis_retribusi)
              ->transformWith(new JenisRetribusiTransformer)
              ->serializeWith(new ArraySerializer)
              ->toArray();
          return response()->json($respone, 200);
      }else{
          $messages = 'errors server!';
          $respone =  fractal()
              ->item($messages)
              ->transformWith(new ErorrTransformer)      
              ->toArray();
          return response()->json($respone, 401);
      }
    }

    public function register(Request $request, WajibRetribusi $warr){

        $validator = Validator::make($request->all(), 
            
            array(  

                    'nik' => 'required',
                    'nama' => 'required',
                    'hp'         => 'numeric|min:15|unique:petugas,hp,',
                    'district_id' => 'required',
                    'villages_id' => 'required',
                    'alamat' => 'required',
                    'jenis_lokasi' => 'required',
                    'jenis_retribusi' => 'required',
                    'username'         => 'required',
                    'password'         => 'required',
                    'email'         => 'email|unique:petugas,email,',
                    
                ), 
            array(  
                    'nik.required' => 'NIK Tidak Boleh Kosong',
                    'nama.required' => 'Nama Tidak Boleh Kosong',
                    'hp.numeric' => 1003,
                    'hp.min' => 1004,
                    'hp.unique' => 1005,
                    'district_id.required' => 'Kecamatan Tidak Boleh Kosong',
                    'villages_id.required' => 'Gampong Tidak Boleh Kosong',
                    'alamat.required' => 'Alamat Tidak Boleh Kosong',
                    'jenis_lokasi.required' => 'Silahkan Pilih Jenis Lokasi',
                    'jenis_retribusi.required' => 'Silahkan Pilih Jenis Retribusi',
                    'username.required' => 'Username Tidak Boleh Kosong',
                    'password.required' => 'Password Tidak Boleh Kosong',
                    'email.email' => 1001,
                    'email.unique' => 1002,
                )
        );

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response = fractal()
                ->item($error_messages)
                ->transformWith(new ErorValidasiTransformer)
                    
                ->toArray();

            return response()->json($response, 401);

                 
        }else{

            $warr = WajibRetribusi::where('nik',$request->nik)->first();
            $warruseername = WajibRetribusi::where('username',$request->username)->first();

            if($warr){
                $messages = 'NIK Sudah Digunakan!';
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)
                        
                    ->toArray();
                return response()->json($respone, 411);
            }else{
                if($warruseername){
                    $messages = 'Username Sudah Digunakan!';
                    $respone =  fractal()
                        ->item($messages)
                        ->transformWith(new ErorrTransformer)
                            
                        ->toArray();
                    return response()->json($respone, 411);
                }else{
                    $hash               = $this->getHash($request->password);
                      $encrypted_password = $hash['encrypted'];
                      $salt               = $hash['salt'];

                      

                      $admin = new WajibRetribusi;

                      $admin->regency_id = '1171';
                      $admin->district_id = $request->district_id;
                      $admin->villages_id = $request->villages_id;
                      $admin->jenis_id = $request->jenis_retribusi;
                      $admin->nik = $request->nik;
                      $admin->nama = $request->nama;
                      $admin->alamat = $request->alamat;
                      $admin->hp = $request->hp;
                      $admin->username = $request->username;
                      $admin->email = $request->email;
                      $admin->password = $encrypted_password;
                      $admin->salt = $salt;
                      $admin->is_active = 1;
                      $admin->email_verify = 0;
                      $admin->lat = $request->lat;
                      $admin->lng = $request->lng;


                      if($request->jenis_lokasi == 'kota'){
                        $admin->kota = 1;
                        $admin->gampong = 0;
                      }elseif($request->jenis_lokasi == 'gampong'){
                        $admin->kota = 0;
                        $admin->gampong = 1;
                      }

                      $kode = WajibRetribusi::where('district_id',$request->district_id)->where('villages_id',$request->villages_id)->orderBy('code', 'desc')->first();
                      if($kode){
                          $kodebrg1 = substr($kode->code, 20,27)+1;
                          if($kodebrg1 < 10){
                              $kodebrg = '1171'.$request->district_id.$request->villages_id."000000".$kodebrg1;
                          }else if($kodebrg1 > 9 && $kodebrg1 < 99){
                              $kodebrg = '1171'.$request->district_id.$request->villages_id."00000".$kodebrg1;
                          }else if($kodebrg1 > 100){
                              $kodebrg = '1171'.$request->district_id.$request->villages_id."0000".$kodebrg1;
                          }else if($kodebrg1 > 1000){
                              $kodebrg = '1171'.$request->district_id.$request->villages_id."000".$kodebrg1;
                          }else if($kodebrg1 > 10000){
                              $kodebrg = '1171'.$request->district_id.$request->villages_id."00".$kodebrg1;
                          }else if($kodebrg1 > 100000){
                              $kodebrg = '1171'.$request->district_id.$request->villages_id."0".$kodebrg1;
                          }else if($kodebrg1 > 1000000){
                              $kodebrg = '1171'.$request->district_id.$request->villages_id.$kodebrg1;
                          }
                      }else{
                          $kodebrg = '1171'.$request->district_id.$request->villages_id.'0000001';
                      }

                      $admin->code = $kodebrg;

                      // $url = url('/api/get_wajib_retribusi/detailcode');
                      $destinationPathqr = 'uploads/qrcode';
                      $imageqr = QrCode::format('png')
                               ->size(300)->errorCorrection('H')
                               ->generate($kodebrg);
                      $output_file = $kodebrg . '.png';
                      Storage::disk('public_uploadsqrcode')->put($output_file, $imageqr);
                      $direktoriqr = $destinationPathqr.'/'.$output_file;
                      $admin->qrcode = $direktoriqr;

                      $admin->token = Helperss::generate_token();
                      $admin->token_expiry = Helperss::generate_expiry();

                      if (Input::file('photo')) {
                        $image = $request->file('photo');
                        $input['imagename'] =  date('ymdhis').'.'.$image->getClientOriginalExtension();
                        $destinationPath = ('uploads/wr');
                        $img = Image::make($image->getRealPath());
                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path($destinationPath.'/'.$input['imagename']));

                        $image->move(public_path($destinationPath, '/'.$input['imagename']));

                        $direktori = $destinationPath.'/'.$input['imagename'];
                        $admin->photo = $direktori;
                      }

                      $admin->save();

                      $begin = new DateTime();
                      $begin->modify( 'first day of this month' );
                      $end = new DateTime(); 
                      $end->modify( 'first day of +2 year' );

                      $interval = DateInterval::createFromDateString('1 month');
                      $period = new DatePeriod($begin, $interval, $end);


                      $getjenis = JenisRetribusi::where('id',$admin->jenis_id)->first();
                      if($admin->kota == 1){
                        $trff = $getjenis->tarif_kota;
                      }elseif($admin->gampong == 1){
                        $trff = $getjenis->tarif_gampong;
                      }
                      
                      foreach ($period as $dt) {

                        $data = array(
                            'id_wr' => $admin->id,
                            'bulan' => $dt->format("Y-m-d"),
                            'tarif' => $trff,
                            'status' => 0
                        );

                        $insertData[] = $data;
                      }
                      Tagihan::insert($insertData);

                      $warr = WajibRetribusi::where('id',$admin->id)->first();
                        $respone =  fractal()
                            ->item($warr)
                            ->transformWith(new WajibRetribusiTransformer)
                            ->serializeWith(new ArraySerializer)                         
                            ->toArray();
                        return response()->json($respone, 201);
                }
            }
        }
    }


    public function get_profile(Request $request,$id){
        
        $validator = Validator::make($request->all(),
                             array(
                        'token' => 'required'
                            ), array(
                        'token.required' => 2111
                            )
            );


        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response = fractal()
                ->item($error_messages)
                ->transformWith(new ErorValidasiTransformer)
                    
                ->toArray();

            return response()->json($response, 401);

        }else{
            $token = $request->token;

            $wrs = WajibRetribusi::where('token', '=', $token)->where('id', '=', $id)->first();

            if($wrs){

                $warr = WajibRetribusi::where('token', '=', $token)->where('id', '=', $id)->first();
                $respone =  fractal()
                    ->item($warr)
                    ->transformWith(new WajibRetribusiTransformer)
                    ->serializeWith(new ArraySerializer)
                    ->toArray();
                return response()->json($respone, 200);
            }else{
                $messages = 2001;
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)      
                    ->toArray();
                return response()->json($respone, 401);
            }
        }
    }

    public function editprofile(Request $request,$id){
      $validator = Validator::make($request->all(), 
            
            array(  

                    'nik' => 'required',
                    'nama' => 'required',
                    'hp'         => 'numeric|min:15',
                    'username'         => 'required',
                    'email'         => 'email',
                    
                ), 
            array(  
                    'nik.required' => 'NIK Tidak Boleh Kosong',
                    'nama.required' => 'Nama Tidak Boleh Kosong',
                    'hp.numeric' => 1003,
                    'hp.min' => 1004,
                    // 'hp.unique' => 1005,
                    'username.required' => 'Username Tidak Boleh Kosong',
                    'email.email' => 1001,
                    // 'email.unique' => 1002,
                )
        );

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response = fractal()
                ->item($error_messages)
                ->transformWith(new ErorValidasiTransformer)
                    
                ->toArray();

            return response()->json($response, 401);

                 
        }else{

          $warr = WajibRetribusi::where('nik',$request->nik)->where('id','!=',$id)->first();
          $warruseername = WajibRetribusi::where('username',$request->username)->where('id','!=',$id)->first();
          $warrhp = WajibRetribusi::where('hp',$request->hp)->where('id','!=',$id)->first();
          $warremail = WajibRetribusi::where('email',$request->email)->where('id','!=',$id)->first();

          if($warr){
              $messages = 'NIK Sudah Digunakan!';
              $respone =  fractal()
                  ->item($messages)
                  ->transformWith(new ErorrTransformer)
                      
                  ->toArray();
              return response()->json($respone, 411);
          }else{
            if($warruseername){
                  $messages = 'Username Sudah Digunakan!';
                  $respone =  fractal()
                      ->item($messages)
                      ->transformWith(new ErorrTransformer)
                          
                      ->toArray();
                  return response()->json($respone, 411);
            }else{
              if($warrhp){
                    $messages = 1005;
                    $respone =  fractal()
                        ->item($messages)
                        ->transformWith(new ErorrTransformer)
                            
                        ->toArray();
                    return response()->json($respone, 411);
              }else{
                if($warremail){
                      $messages = 1002;
                      $respone =  fractal()
                          ->item($messages)
                          ->transformWith(new ErorrTransformer)
                              
                          ->toArray();
                      return response()->json($respone, 411);
                }else{
                  
                    $admin = WajibRetribusi::where('id',$id)->first();

                    $admin->nik = $request->nik;
                    $admin->nama = $request->nama;
                    $admin->hp = $request->hp;
                    $admin->username = $request->username;
                    $admin->email = $request->email;
                    $admin->lat = $request->lat;
                    $admin->lng = $request->lng;

                    $admin->save();

                    $warr = WajibRetribusi::where('id',$id)->first();
                    $respone =  fractal()
                        ->item($warr)
                        ->transformWith(new WajibRetribusiTransformer)
                        ->serializeWith(new ArraySerializer)                         
                        ->toArray();
                    return response()->json($respone, 201);

                }
              }
            }
          }
        }
    }

    public function editprofilephoto(Request $request,$id){
      $validator = Validator::make($request->all(), 
            
            array(  

                    'photo' => 'required',
                    
                ), 
            array(  
                    'photo.required' => 'Photo Tidak Boleh Kosong',
                )
        );

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response = fractal()
                ->item($error_messages)
                ->transformWith(new ErorValidasiTransformer)
                    
                ->toArray();

            return response()->json($response, 401);

                 
        }else{

          $admin = WajibRetribusi::where('id',$id)->first();

          if (Input::file('photo')) {

            if ($admin->photo != "") {
                $path = $admin->photo;
                unlink(public_path($path));
            }

            $image = $request->file('photo');
            $input['imagename'] =  date('ymdhis').'.'.$image->getClientOriginalExtension();
            $destinationPath = ('uploads/wr');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($destinationPath.'/'.$input['imagename']));

            $image->move(public_path($destinationPath, '/'.$input['imagename']));

            $direktori = $destinationPath.'/'.$input['imagename'];
            $admin->photo = $direktori;
          }

          $admin->save();

          $warr = WajibRetribusi::where('id',$admin->id)->first();
          $respone =  fractal()
              ->item($warr)
              ->transformWith(new WajibRetribusiTransformer)
              ->serializeWith(new ArraySerializer)                         
              ->toArray();
          return response()->json($respone, 201);

        }
    }

    public function addphotohouse(Request $request,$id){
      $validator = Validator::make($request->all(), 
            
            array(  

                    'image' => 'required',
                    'imagedua' => 'required',
                    'imagetiga' => 'required',
                    
                ), 
            array(  
                    'image.required' => 'Photo Rumah Pertama Tidak Boleh Kosong',
                    'imagedua.required' => 'Photo Rumah Kedua Tidak Boleh Kosong',
                    'imagetiga.required' => 'Photo Rumah Ketiga Tidak Boleh Kosong',
                )
        );

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response = fractal()
                ->item($error_messages)
                ->transformWith(new ErorValidasiTransformer)
                    
                ->toArray();

            return response()->json($response, 401);

                 
        }else{

          $admin = WajibRetribusi::where('id',$id)->first();
          $imagee = new DetailImage;
          $imagee->id_wr = $admin->id;
          if (Input::file('image')) {
            $image = $request->file('image');
            $input['imagename'] =  'image'.date('ymdhis').'.'.$image->getClientOriginalExtension();
            $destinationPath = ('uploads/wrdetail');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($destinationPath.'/'.$input['imagename']));

            $image->move(public_path($destinationPath, '/'.$input['imagename']));

            $direktori = $destinationPath.'/'.$input['imagename'];
            $imagee->image = $direktori;
          }

          if (Input::file('imagedua')) {
            $image = $request->file('imagedua');
            $input['imagename'] =  'image2'.date('ymdhis').'.'.$image->getClientOriginalExtension();
            $destinationPath = ('uploads/wrdetail');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($destinationPath.'/'.$input['imagename']));

            $image->move(public_path($destinationPath, '/'.$input['imagename']));

            $direktori = $destinationPath.'/'.$input['imagename'];
            $imagee->imagedua = $direktori;
          }

          if (Input::file('imagetiga')) {
            $image = $request->file('imagetiga');
            $input['imagename'] =  'image3'.date('ymdhis').'.'.$image->getClientOriginalExtension();
            $destinationPath = ('uploads/wrdetail');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($destinationPath.'/'.$input['imagename']));

            $image->move(public_path($destinationPath, '/'.$input['imagename']));

            $direktori = $destinationPath.'/'.$input['imagename'];
            $imagee->imagetiga = $direktori;
          }

          $imagee->save();

          $warr = WajibRetribusi::where('id',$admin->id)->first();
          $respone =  fractal()
              ->item($warr)
              ->transformWith(new WajibRetribusiTransformer)
              ->serializeWith(new ArraySerializer)                         
              ->toArray();
          return response()->json($respone, 201);

          
        }
    }

    public function editprofilephotohouse(Request $request,$id){
      $validator = Validator::make($request->all(), 
            
            array(  

                    'image' => 'required',
                    'imagedua' => 'required',
                    'imagetiga' => 'required',
                    
                ), 
            array(  
                    'image.required' => 'Photo Rumah Pertama Tidak Boleh Kosong',
                    'imagedua.required' => 'Photo Rumah Kedua Tidak Boleh Kosong',
                    'imagetiga.required' => 'Photo Rumah Ketiga Tidak Boleh Kosong',
                )
        );

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response = fractal()
                ->item($error_messages)
                ->transformWith(new ErorValidasiTransformer)
                    
                ->toArray();

            return response()->json($response, 401);

                 
        }else{

          $admin = WajibRetribusi::where('id',$id)->first();
          $imagee = DetailImage::where('id_wr',$id)->first();
          $imagee->id_wr = $admin->id;
          if (Input::file('image')) {
            if ($imagee->image != "") {
                $path = $imagee->image;
                unlink(public_path($path));
            }
            $image = $request->file('image');
            $input['imagename'] =  'image'.date('ymdhis').'.'.$image->getClientOriginalExtension();
            $destinationPath = ('uploads/wrdetail');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($destinationPath.'/'.$input['imagename']));

            $image->move(public_path($destinationPath, '/'.$input['imagename']));

            $direktori = $destinationPath.'/'.$input['imagename'];
            $imagee->image = $direktori;
          }

          if (Input::file('image2')) {
            if ($imagee->image2 != "") {
                $path = $imagee->image2;
                unlink(public_path($path));
            }
            $image = $request->file('image2');
            $input['imagename'] =  'image2'.date('ymdhis').'.'.$image->getClientOriginalExtension();
            $destinationPath = ('uploads/wrdetail');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($destinationPath.'/'.$input['imagename']));

            $image->move(public_path($destinationPath, '/'.$input['imagename']));

            $direktori = $destinationPath.'/'.$input['imagename'];
            $imagee->imagedua = $direktori;
          }

          if (Input::file('image3')) {
            if ($imagee->image3 != "") {
                $path = $imagee->image3;
                unlink(public_path($path));
            }
            $image = $request->file('image3');
            $input['imagename'] =  'image3'.date('ymdhis').'.'.$image->getClientOriginalExtension();
            $destinationPath = ('uploads/wrdetail');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($destinationPath.'/'.$input['imagename']));

            $image->move(public_path($destinationPath, '/'.$input['imagename']));

            $direktori = $destinationPath.'/'.$input['imagename'];
            $imagee->imagetiga = $direktori;
          }

          $imagee->save();

          $warr = WajibRetribusi::where('id',$admin->id)->first();
          $respone =  fractal()
              ->item($warr)
              ->transformWith(new WajibRetribusiTransformer)
              ->serializeWith(new ArraySerializer)                         
              ->toArray();
          return response()->json($respone, 201);

          
        }
    }

    public function tagihan_wrbyid(Request $request,$id){
      $tagihan = Tagihan::where('id_wr',$id)
                ->limit(20)
                ->get();

      $respone =  fractal()
          ->collection($tagihan)
          ->transformWith(new TagihanTransformer)
          ->serializeWith(new ArraySerializer)
          ->toArray();
      return response()->json($respone, 200);
    }


    public function tagihan_belumbayar(Request $request,$id){
      $tagihan = Tagihan::where('id_wr',$id)
                ->where('status',0)
                ->orderBy('bulan','ASC')
                ->limit(20)
                ->get();

      $respone =  fractal()
          ->collection($tagihan)
          ->transformWith(new TagihanTransformer)
          ->serializeWith(new ArraySerializer)
          ->toArray();
      return response()->json($respone, 200);
    }

    public function upload_bukti(Request $request,$id){
      $validator = Validator::make($request->all(), 
            
            array(  
                    'dari' => 'required',
                    'sampai' => 'required',
                    // 'total_bayar' => 'required',
                    'bukti' => 'required',
                    
                ), 
            array(  
                    'dari.required' => 'Tidak Boleh Kosong',
                    'sampai.required' => 'Tidak Boleh Kosong',
                    // 'total_bayar.required' => 'Tidak Boleh Kosong',
                    'bukti.required' => 'Tidak Boleh Kosong',
                )
        );

        if ($validator->fails()) {
            $error_messages = $validator->messages()->all();
            $response = fractal()
                ->item($error_messages)
                ->transformWith(new ErorValidasiTransformer)
                    
                ->toArray();

            return response()->json($response, 401);

                 
        }else{
          $wr = WajibRetribusi::where('id',$id)->first();
          $tagihan = Tagihan::where('id_wr',$id)
                ->where('status',0)
                ->orderBy('bulan','ASC')
                ->first();

          $dari = date('Y-m-d',strtotime($request->dari));
          $sampai = date('Y-m-d',strtotime($request->sampai));

          // $date1 = new DateTime($dari);
          // $date2 = new DateTime($sampai);
          // $interval = $date1->diff($date2);
          // $hasil_bulan =  $interval->m;
          $date1 = $request->dari;
          $date2 = $request->sampai;
          $ts1 = strtotime($date1);
          $ts2 = strtotime($date2);
          $year1 = date('Y', $ts1);
          $year2 = date('Y', $ts2);
          $month1 = date('m', $ts1);
          $month2 = date('m', $ts2);
          $diff = (($year2 - $year1) * 12) + ($month2 - $month1)+1;

          $totalharga = $tagihan->tarif*$diff;

          $bukti = new UploadBukti;
          $bukti->id_wr = $id;
          $bukti->dari = $dari;
          $bukti->sampai = $sampai;
          $bukti->total_bayar = $totalharga;
          $bukti->status = 0;
          $bukti->tgl_upload = date("Y-m-d H:i:s");

          if (Input::file('bukti')) {
            $image = $request->file('bukti');
            $input['imagename'] =  'bukti'.date('ymdhis').'.'.$image->getClientOriginalExtension();
            $destinationPath = ('uploads/bukti');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($destinationPath.'/'.$input['imagename']));

            $image->move(public_path($destinationPath, '/'.$input['imagename']));

            $direktori = $destinationPath.'/'.$input['imagename'];
            $bukti->bukti = $direktori;
          }

          $bukti->save();

          DB::table('detail_trs_wr')
                ->whereRaw('id_wr = '.$id.' AND status = 0 AND bulan between "'.$dari.'" and "'.$sampai.'"')
                ->update(['status' => '2','tgl_bayar' => date("Y-m-d H:i:s") ]); 

          $databukti = UploadBukti::where('id_wr',$id)->where('id',$bukti->id)->first();
          $respone =  fractal()
              ->item($databukti)
              ->transformWith(new BuktiTransformer)
              ->serializeWith(new ArraySerializer)
              ->toArray();
          return response()->json($respone, 200);
        }
    }
    
}
