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
use App\Http\Models\UploadBukti;
use App\Http\Models\LokasiTugas;
use App\Http\Models\Tagihan;

use App\Transformers\ErorValidasiTransformer;
use App\Transformers\ErorrTransformer;
use App\Transformers\PetugasTransformer;
use App\Transformers\KoordinatorTransformer;
use App\Transformers\WrByVillTransformer;

use App\Transformers\WajibRetribusiTransformer;
use App\Transformers\DistrictsTransformer;
use App\Transformers\VillagesTransformer;
use App\Transformers\JenisRetribusiTransformer;
use App\Transformers\PetugasGetDataTransformer;
use App\Transformers\BuktiDataTransformer;


use Spatie\Fractalistic\ArraySerializer;

use App\Http\Models\JenisRetribusi;
use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;

use Helperss;
use Image;
use Mail;



class PetugasApiController extends Controller
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

    //Login Petugas --------------------------------------------------

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
            
            $petugas = Petugas::where('username',$username)->orWhere('email', $username)->first();
            
            if($petugas){
                $db_encrypted_password = $petugas->password;
                $salt = $petugas->salt;

                $hasil_pass = $this->verifyHash($password.$salt,$db_encrypted_password);
                if($hasil_pass) {
                    if($petugas->is_active == 1){
                        $petugas->token = Helperss::generate_token();
                        $petugas->token_expiry = Helperss::generate_expiry();
                        $petugas->save();
                        $respone =  fractal()
                            ->item($petugas)
                            ->transformWith(new PetugasTransformer)
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

    public function get_koordinator(Request $request){
        $messages = 200;
        $respone =  fractal()
            ->item($messages)
            ->transformWith(new KoordinatorTransformer)
                
            ->toArray();
        return response()->json($respone, 200);

    }

    public function register(Request $request, Petugas $petugas){

        $validator = Validator::make($request->all(), 
            
            array(  
                    'id_koordinator'         => 'required',
                    'nik'         => 'required',
                    'nama'         => 'required',
                    'username'         => 'required',
                    'password'         => 'required',
                    'email'         => 'email|unique:petugas,email,',
                    'hp'         => 'numeric|min:15|unique:petugas,hp,',
                ), 
            array(  
                    'id_koordinator.required' => 'Koordinator Tidak Boleh Kosong',
                    'nik.required' => 'NIK Tidak Boleh Kosong',
                    'nama.required' => 'Nama Tidak Boleh Kosong',
                    'username.required' => 'Username Tidak Boleh Kosong',
                    'password.required' => 'Password Tidak Boleh Kosong',
                    'hp.numeric' => 1003,
                    'hp.min' => 1004,
                    'hp.unique' => 1005,
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

            $petugas = Petugas::where('nik',$request->nik)->first();
            $petugasuseername = Petugas::where('username',$request->username)->first();

            if($petugas){
                $messages = 'NIK Sudah Digunakan!';
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)
                        
                    ->toArray();
                return response()->json($respone, 411);
            }else{
                if($petugasuseername){
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
                      
                      $token = Helperss::generate_token();
                      $token_expiry = Helperss::generate_expiry();


                      $admin = new Petugas;

                      $admin->id_koordinator = $request->id_koordinator;
                      $admin->nik = $request->nik;
                      $admin->nama = $request->nama;
                      $admin->hp = $request->hp;
                      $admin->username = $request->username;
                      $admin->email = $request->email;
                      $admin->password = $encrypted_password;
                      $admin->salt = $salt;
                      $admin->email_verify = 0;
                      $admin->is_active = 0;
                      $admin->token = $token;
                      $admin->token_expiry = $token_expiry;

                      

                       if (Input::file('image')) {
                          $image = $request->file('image');
                          $input['imagename'] =  date('ymdhis').'.'.$image->getClientOriginalExtension();
                          $destinationPath = ('uploads/petugas');
                          $img = Image::make($image->getRealPath());
                          $img->resize(200, 200, function ($constraint) {
                              $constraint->aspectRatio();
                          })->save(public_path($destinationPath.'/'.$input['imagename']));

                          $image->move(public_path($destinationPath, '/'.$input['imagename']));

                          $direktori = $destinationPath.'/'.$input['imagename'];
                          $admin->image = $direktori;
                        }

                      $admin->save();

                      $token = new PetugasEmailVer;

                      $token->email = $request->email;
                      $token->token = encrypt($request->nama.$request->email);

                      $token->save();

                      // $link = "https://dev.ho-jak.id/user/emailverify/".$tokenemail."";

                      //   $message_body = array('emailverify' => $link, 'name' => $first_name);
                      //   $subject = "Welcome to HO-JAK INDONESIA , " . $first_name . "";
                               
                      //       Mail::send('emails.emailregister', array('mail_body' => $message_body), function ($message) use ($email, $subject) {
                      //               $message->to($email)->subject($subject);
                      //           });
                                
                      //           Mail::send('emails.emailverify', array('mail_body' => $message_body), function ($message) use ($email, $subject) {
                      //               $message->to($email)->subject($subject);
                      //           });
                      $petugas = Petugas::where('id',$admin->id)->first();
                        $respone =  fractal()
                            ->item($petugas)
                            ->transformWith(new PetugasTransformer)
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

            $petugass = Petugas::where('token', '=', $token)->where('id', '=', $id)->first();

            if($petugass){

                $petugas = Petugas::where('token', '=', $token)->where('id', '=', $id)->first();
                $respone =  fractal()
                    ->item($petugas)
                    ->transformWith(new PetugasTransformer)
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

    public function editprofile(Request $request, Petugas $petugas,$id){

        $validator = Validator::make($request->all(), 
            
            array(  
                    'nama'         => 'required',
                    'username'         => 'required',
                    'email'         => 'email',
                    'hp'         => 'numeric|min:15',
                ), 
            array(  
                    'nama.required' => 'Nama Tidak Boleh Kosong',
                    'username.required' => 'Username Tidak Boleh Kosong',
                    'hp.numeric' => 1003,
                    'hp.min' => 1004,
                    // 'hp.unique' => 1005,
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

            $petugasuseername = Petugas::where('id','!=',$id)->where('username',$request->username)->first();
            $petugasemail = Petugas::where('id','!=',$id)->where('email',$request->email)->first();
            $petugashp = Petugas::where('id','!=',$id)->where('hp',$request->hp)->first();

            if($petugasuseername){
                $messages = 'Username Sudah Digunakan!';
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)
                        
                    ->toArray();
                return response()->json($respone, 411);
            }else{

              if($petugasemail){
                  $messages = 1002;
                  $respone =  fractal()
                      ->item($messages)
                      ->transformWith(new ErorrTransformer)
                          
                      ->toArray();
                  return response()->json($respone, 411);
              }else{
                if($petugashp){
                    $messages = 1005;
                    $respone =  fractal()
                        ->item($messages)
                        ->transformWith(new ErorrTransformer)
                            
                        ->toArray();
                    return response()->json($respone, 411);
                }else{
                    // $token = Helperss::generate_token();
                    // $token_expiry = Helperss::generate_expiry();


                    $admin = Petugas::where('id',$id)->first();

                    $admin->nama = $request->nama;
                    $admin->hp = $request->hp;
                    $admin->username = $request->username;
                    $admin->email = $request->email;
                    $admin->alamat = $request->alamat;

                    

                     if (Input::file('image')) {
                          if ($admin->image != "") {
                              $path = $admin->image;
                              unlink(public_path($path));
                          }

                        $image = $request->file('image');
                        $input['imagename'] =  date('ymdhis').'.'.$image->getClientOriginalExtension();
                        $destinationPath = ('uploads/petugas');
                        $img = Image::make($image->getRealPath());
                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path($destinationPath.'/'.$input['imagename']));

                        $image->move(public_path($destinationPath, '/'.$input['imagename']));

                        $direktori = $destinationPath.'/'.$input['imagename'];
                        $admin->image = $direktori;
                      }

                      $cekkemail = Petugas::where('email',$request->email)->first();

                        if(!empty($cekkemail)){
                            $admin->email_verify = 0;

                            $token = new PetugasEmailVer;

                            $token->email = $request->email;
                            $token->token = encrypt($request->nama.$request->email);

                            $token->save();

                        }

                      $admin->save();
                    

                    // $link = "https://dev.ho-jak.id/user/emailverify/".$tokenemail."";

                    //   $message_body = array('emailverify' => $link, 'name' => $first_name);
                    //   $subject = "Welcome to HO-JAK INDONESIA , " . $first_name . "";
                             
                    //       Mail::send('emails.emailregister', array('mail_body' => $message_body), function ($message) use ($email, $subject) {
                    //               $message->to($email)->subject($subject);
                    //           });
                              
                    //           Mail::send('emails.emailverify', array('mail_body' => $message_body), function ($message) use ($email, $subject) {
                    //               $message->to($email)->subject($subject);
                    //           });
                    $petugas = Petugas::where('id',$id)->first();
                      $respone =  fractal()
                          ->item($petugas)
                          ->transformWith(new PetugasTransformer)
                          ->serializeWith(new ArraySerializer)                         
                          ->toArray();
                      return response()->json($respone, 201);
                }
              } 
            }
        }
    }

    public function editprofilephoto(Request $request,$id){
      $validator = Validator::make($request->all(), 
            
            array(  

                    'image' => 'required',
                    
                ), 
            array(  
                    'image.required' => 'Photo Tidak Boleh Kosong',
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

          $admin = Petugas::where('id',$id)->first();

          if (Input::file('image')) {
              if ($admin->image != "") {
                  $path = $admin->image;
                  unlink(public_path($path));
              }

            $image = $request->file('image');
            $input['imagename'] =  date('ymdhis').'.'.$image->getClientOriginalExtension();
            $destinationPath = ('uploads/petugas');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($destinationPath.'/'.$input['imagename']));

            $image->move(public_path($destinationPath, '/'.$input['imagename']));

            $direktori = $destinationPath.'/'.$input['imagename'];
            $admin->image = $direktori;
          }

          $admin->save();

          $petugas = Petugas::where('id',$id)->first();
          $respone =  fractal()
              ->item($petugas)
              ->transformWith(new PetugasTransformer)
              ->serializeWith(new ArraySerializer)                         
              ->toArray();
          return response()->json($respone, 201);
      }
    }
    
    public function resend_email(Request $request,$id){
        $validator = Validator::make($request->all(),
                             array(
                        'token' => 'required',
                        'email' => 'required'
                            ), array(
                        'token.required' => 2111,
                        'email.required' => 1006
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
            $email = $request->email;
        
            $petugas = Petugas::where('id',$id)->first();

            if($petugas){
                $gettoken = PetugasEmailVer::where('email',$petugas->email)->first();

                if(empty($gettoken)){
                    $emailtoken = new PetugasEmailVer();
                    $emailtoken->email = $request->email;
                    $emailtoken->token = encrypt($petugas->nama.$request->email);

                    $emailtoken->save();

                    $tokenemail       = $emailtoken->token;
                }else{
                    $gettoken->email = $request->email;
                    $gettoken->save();
                    $tokenemail       = $gettoken->token;
                }
                $petugas->email = $request->email;
                $petugas->save();
                
                $link = "http://dev.ho-jak.id/user/emailverify/".$tokenemail;

                $message_body = array('emailverify' => $link, 'name' => ucwords($petugas->nama));
                $subject = "Welcome to HO-JAK INDONESIA , " . ucwords($petugas->nama) . "";
            
                Mail::send('emails.emailverify', array('mail_body' => $message_body), function ($message) use ($email, $subject) {
                    $message->to($email)->subject($subject);
                });
                

                $respone =  fractal()
                    ->item($petugas)
                    ->transformWith(new PetugasTransformer)
                    ->serializeWith(new ArraySerializer)
                    ->toArray();
                return response()->json($respone, 200);
                
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


    public function get_wajib_retribusi(Request $request,$id_gampong){

        $wrzona = WajibRetribusi::where('villages_id',$id_gampong)->get();
        $messages = 200;
        $respone =  fractal()
            ->collection($wrzona)
            ->transformWith(new WrByVillTransformer)
            ->serializeWith(new ArraySerializer)    
            ->toArray();
        return response()->json($respone, 200);

    }

    public function get_wajib_retribusidetail(Request $request,$code){

        $warr = WajibRetribusi::where('code', '=', $code)->first();
        $respone =  fractal()
            ->item($warr)
            ->transformWith(new WajibRetribusiTransformer)
            ->serializeWith(new ArraySerializer)
            ->toArray();
        return response()->json($respone, 200);

    }

    public function get_wajib_retribusidetailcode(Request $request,$code){

        $warr = WajibRetribusi::where('code', '=', $code)->first();
        $respone =  fractal()
            ->item($warr)
            ->transformWith(new WajibRetribusiTransformer)
            ->serializeWith(new ArraySerializer)
            ->toArray();
        return response()->json($respone, 200);

    }

    public function get_wr_bynik(Request $request){
        $wrzona = WajibRetribusi::whereRaw('villages_id = '.$request->id_gampong.' AND (nik LIKE "%'.$request->search.'%" OR nama LIKE "%'.$request->search.'%" OR alamat LIKE "%'.$request->search.'%")')->get();


        if(!empty($wrzona)){
          $respone =  fractal()
              ->collection($wrzona)
              ->transformWith(new WrByVillTransformer)
              ->serializeWith(new ArraySerializer)    
              ->toArray();
          return response()->json($respone, 200);
        }else{
          $messages = 'DATA TIDAK DITEMUKAN';
          $respone =  fractal()
              ->item($messages)
              ->transformWith(new ErorrTransformer)      
              ->toArray();
          return response()->json($respone, 401);
        }
        
    }

    public function search_data_gampong(Request $request){
        $lokasitgas = DB::table('lokasi_tugas as a')
                    ->select('b.id as id_kecamatan','c.id as id_gampong','b.name as nama_kecamatan','c.name as nama_gampong')
                    ->leftJoin('districts as b','a.district_id','=','b.id')
                    ->leftJoin('villages as c','a.villages_id','=','c.id')
                    ->where('a.id_petugas',$request->id)
                    ->whereRaw('a.id_petugas = '.$request->id.' AND (b.name LIKE "%'.$request->search.'%" OR c.name LIKE "%'.$request->search.'%")')
                    ->get();



        
        if(!empty($lokasitgas)){
          $respone =  fractal()
              ->collection($lokasitgas)
              ->transformWith(new PetugasGetDataTransformer)
              ->serializeWith(new ArraySerializer)    
              ->toArray();
          return response()->json($respone, 200);
        }else{
          $messages = 'DATA TIDAK DITEMUKAN';
          $respone =  fractal()
              ->item($messages)
              ->transformWith(new ErorrTransformer)      
              ->toArray();
          return response()->json($respone, 401);
        }
        
    }

    public function get_data_bukti(Request $request,$id){

        $lokasitgas = DB::table('lokasi_tugas as a')
                    ->select('b.id as id_kecamatan','c.id as id_gampong')
                    ->leftJoin('districts as b','a.district_id','=','b.id')
                    ->leftJoin('villages as c','a.villages_id','=','c.id')
                    ->where('a.id_petugas',$id)
                    ->first();


        $databukti = DB::table('upload_bukti_trs as a')
                    ->select('a.*','b.nik','b.nama','b.code')
                    ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
                    ->whereRaw('b.district_id = '.$lokasitgas->id_kecamatan.' AND status = 0')
                    // ->groupBy('a.id_wr')
                    ->get();

        if(!empty($databukti)){
            $respone =  fractal()
              ->collection($databukti)
              ->transformWith(new BuktiDataTransformer)
              ->serializeWith(new ArraySerializer)    
              ->toArray();
          return response()->json($respone, 200);
        }else{
          $messages = 'DATA TIDAK DITEMUKAN';
          $respone =  fractal()
              ->item($messages)
              ->transformWith(new ErorrTransformer)      
              ->toArray();
          return response()->json($respone, 401);
        }

        
    }

    public function verifikasi_upload(Request $request,$idbukti){
        $bukti = UploadBukti::where('id',$idbukti)->first();

        $dari = date('Y-m-d',strtotime($request->dari));
        $sampai = date('Y-m-d',strtotime($request->sampai));

        $aksi = DB::table('detail_trs_wr')
                ->whereRaw('id_wr = '.$bukti->id_wr.' AND status = 2 AND bulan between "'.$dari.'" and "'.$sampai.'"')
                ->update(['status' => '1' ]); 

        if($aksi){
            $bukti->status = 1;
            $bukti->save();
            $msg = array('success'  => true);
            // $respone =  fractal()
            //       ->item($databukti)
            //       ->transformWith(new BuktiTransformer)
            //       ->serializeWith(new ArraySerializer)
            //       ->toArray();
            return response()->json($msg, 200);
        }else{
          $messages = 'DATA TIDAK DITEMUKAN';
          $respone =  fractal()
              ->item($messages)
              ->transformWith(new ErorrTransformer)      
              ->toArray();
          return response()->json($respone, 401);
        }
        
    }
    
    public function bayartagihan_manual(Request $request,$code){
          $wr = WajibRetribusi::where('code',$code)->first();
          $tagihan = Tagihan::where('id_wr',$wr->id)
                ->where('status',0)
                ->orderBy('bulan','ASC')
                ->first();

          $dari = date('Y-m-d',strtotime($request->dari));
          $sampai = date('Y-m-d',strtotime($request->sampai));

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
          $bukti->id_wr = $wr->id;
          $bukti->dari = $dari;
          $bukti->sampai = $sampai;
          $bukti->total_bayar = $totalharga;
          $bukti->status = 2;
          $bukti->tgl_upload = date("Y-m-d H:i:s");

          $aksi = DB::table('detail_trs_wr')
                ->whereRaw('id_wr = '.$wr->id.' AND status = 0 AND bulan between "'.$dari.'" and "'.$sampai.'"')
                ->update(['status' => '1','tgl_bayar' => date("Y-m-d H:i:s") ]); 

            if($aksi){
                $bukti->save();
                $msg = array('success'  => true);
                return response()->json($msg, 200);
            }else{
              $messages = 'DATA TIDAK DITEMUKAN';
              $respone =  fractal()
                  ->item($messages)
                  ->transformWith(new ErorrTransformer)      
                  ->toArray();
              return response()->json($respone, 401);
            }
    }
}
