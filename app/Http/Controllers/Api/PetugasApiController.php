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
use App\Http\Models\UpahPetugas;

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
use App\Transformers\WrByVillBulTransformer;
use App\Transformers\UpahPetugasTransformer;
use App\Transformers\WajibRetribusiGetDataTransformer;
use App\Transformers\WajibRetribusiAkunTransformer;
use App\Transformers\WajibRetribusiDetailTransformer;
use App\Transformers\WajibRetribusiAktifTransformer;
use App\Transformers\WajibRetribusiAktiPasswordfTransformer;

use App\Transformers\BuktiPerWrTransformer;
use App\Transformers\BuktiPerWrDetailTransformer;
use App\Transformers\DataPembayaranTransformer;


use Spatie\Fractalistic\ArraySerializer;
use Spatie\Fractalistic\ArraySerializerV2;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Http\Models\JenisRetribusi;
use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;

use Helperss;
use Image;
use Mail;

use QrCode;
use Storage;

use DateTime;
use DateInterval;
use DatePeriod;



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
                    'hp'         => 'numeric|min:11|unique:petugas,hp,',
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
                    'hp'         => 'numeric|min:11',
                ), 
            array(  
                    'nama.required' => 'Nama Tidak Boleh Kosong',
                    'username.required' => 'Username Tidak Boleh Kosong',
                    'hp.numeric' => 'No Hp Harus Berisi Angka',
                    'hp.min' => 'No Hp Minimal 11 Angka',
                    // 'hp.unique' => 1005,
                    'email.email' => 'Email Tidak Valid',
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
                  $messages = 'Email Sudah Digunakan!';
                  $respone =  fractal()
                      ->item($messages)
                      ->transformWith(new ErorrTransformer)
                          
                      ->toArray();
                  return response()->json($respone, 411);
              }else{
                if($petugashp){
                    $messages = 'No Hp Sudah Digunakan!';
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

    public function editpasword(Request $request,$id){
        $validator = Validator::make($request->all(), 
            
            array(  
                    'password'         => 'required',
                ), 
            array(  
                    'password.required' => 'Password Tidak Boleh Kosong',
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
            $hash               = $this->getHash($request->password);
              $encrypted_password = $hash['encrypted'];
              $salt               = $hash['salt'];

            $petugas = Petugas::where('id',$id)->first();

            $petugas->password = $encrypted_password;
            $petugas->salt = $salt;

            $petugas->save();

            $respone =  fractal()
                ->item($petugas)
                ->transformWith(new PetugasTransformer)
                ->serializeWith(new ArraySerializer)
                ->toArray();
            return response()->json($respone, 200);
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
        try {

            $wrzonapaging = DB::table('wajib_retribusi as a')
            ->select('a.*','b.name as namedistricts','c.name as namevillages','d.gampong as stat_petugas')
            ->leftJoin('districts as b','a.district_id','=','b.id')
            ->leftJoin('villages as c','a.villages_id','=','c.id')
            ->leftJoin('petugas as d','a.id_petugas','=','d.id')
            // ->when('d.gampong= 0', function($query) {
            //     return $query->->whereRaw('d.gampong !=1 AND a.kota=0 AND a.is_active=1');
            // })
            
            ->whereRaw('a.kota='.$request->stat_pet.' AND (d.gampong =0 AND a.is_active=1)')
           // ->whereRaw('gampong = '.$request->stat_petugas.' AND (a.nik LIKE "%'.$request->search.'%" OR a.nama LIKE "%'.$request->search.'%" OR a.alamat LIKE "%'.$request->search.'%" OR b.name LIKE "%'.$request->search'" OR c.name LIKE "%'.$request->search.'%")')

           //->whereRaw('a.villages_id = '.$request->id_gampong.' AND (a.nik LIKE "%'.$request->search.'%" OR a.nama LIKE "%'.$request->search.'%" OR a.alamat LIKE "%'.$request->search.'%" OR b.name LIKE "%'.$request->search.'%" OR c.name LIKE "%'.$request->search.'%")')


            ->whereRaw('a.villages_id = '.$request->id_gampong.' AND (a.nik LIKE "%'.$request->search.'%" OR a.nama LIKE "%'.$request->search.'%" OR a.alamat LIKE "%'.$request->search.'%" OR b.name LIKE "%'.$request->search.'%" OR c.name LIKE "%'.$request->search.'%")')
            ->orderBy('a.nama', 'ASC')
            ->paginate(10);
                                            
                                            
            $wrzona = $wrzonapaging->getCollection();

            if(!empty($wrzona)){
              $respone =  fractal()
                  ->collection($wrzona, new WrByVillTransformer(), 'data')
                  // ->transformWith(new WrByVillTransformer)
                  ->serializeWith(new ArraySerializerV2())
                    ->paginateWith(new IlluminatePaginatorAdapter($wrzonapaging))
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

        } catch (QueryException $ex) {
            throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
        }
        
    }
//==========BELUM LUNAS========
    public function get_wr_bynik_bulan_ini(Request $request){

        try {
            $begin = new DateTime();
            $begin->modify( 'first day of this month' );

            $wrzonapaging = DB::table('wajib_retribusi as a')
                    ->select('a.*','b.bulan','b.status','d.gampong')
                    ->leftJoin('detail_trs_wr as b','a.id','=','b.id_wr')
                    ->leftJoin('petugas as d','a.id_petugas','=','d.id')
                    //->where('a.is_active',1)

                    ->whereRaw('a.kota='.$request->stat_pet.' AND (d.gampong =0 AND a.is_active=1)')
                    ->where('a.villages_id',$request->id_gampong)
                    ->where('b.bulan',$begin->format("Y-m-d"))
                    ->where('b.status',0)
                    ->whereRaw('(a.nik LIKE "%'.$request->search.'%" OR a.nama LIKE "%'.$request->search.'%" OR a.alamat LIKE "%'.$request->search.'%")')
                    ->orderBy('a.nama', 'ASC')
                    ->distinct('a.id')
                    ->paginate(10);

            $wrzona = $wrzonapaging->getCollection();


            if($wrzona){
              $respone =  fractal()
                  ->collection($wrzona, new WrByVillBulTransformer(), 'data')
                  // ->transformWith(new WrByVillBulTransformer)
                  ->serializeWith(new ArraySerializerV2())
                    ->paginateWith(new IlluminatePaginatorAdapter($wrzonapaging))
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
        } catch (QueryException $ex) {
            throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
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

        try {
            // $lokasitgas = DB::table('lokasi_tugas as a')
            //             ->select('b.id as id_kecamatan','c.id as id_gampong')
            //             ->leftJoin('districts as b','a.district_id','=','b.id')
            //             ->leftJoin('villages as c','a.villages_id','=','c.id')
            //             ->where('a.id_petugas',$id)
            //             ->first();


            $databuktipaging = DB::table('upload_bukti_trs as a')
                        ->select('a.*','b.nik','b.nama','b.code')
                        ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
                        ->leftJoin('lokasi_tugas as e','e.district_id','=','b.district_id')
                        ->where('e.id_petugas',$id)
                        ->where('a.status',0)
                        // ->whereRaw('(b.code LIKE "%'.$request->search.'%" OR b.nama LIKE "%'.$request->search.'%")')
                        ->orderBy('b.nama', 'ASC')
                        ->distinct('a.id')
                        ->paginate(10);

            $databukti = $databuktipaging->getCollection();

            if(!empty($databukti)){
                $respone =  fractal()
                  ->collection($databukti, new BuktiDataTransformer(), 'data')
                  // ->transformWith(new BuktiDataTransformer)
                  ->serializeWith(new ArraySerializerV2())
                  ->paginateWith(new IlluminatePaginatorAdapter($databuktipaging))
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

        } catch (QueryException $ex) {
            throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
        }

        
    }
    
    public function get_data_bukti_search(Request $request,$id){
        try {
            
            $databuktipaging = DB::table('upload_bukti_trs as a')
                        ->select('a.*','b.nik','b.nama','b.code')
                        ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
                        ->leftJoin('lokasi_tugas as e','e.district_id','=','b.district_id')
                        ->where('e.id_petugas',$id)
                        ->where('a.status',0)
                        ->whereRaw('(b.code LIKE "%'.$request->search.'%" OR b.nama LIKE "%'.$request->search.'%")')
                        ->orderBy('b.nama', 'ASC')
                        ->distinct('a.id')
                        ->paginate(10);

            $databukti = $databuktipaging->getCollection();

            if(!empty($databukti)){
                $respone =  fractal()
                  ->collection($databukti, new BuktiDataTransformer(), 'data')
                  // ->transformWith(new BuktiDataTransformer)
                  ->serializeWith(new ArraySerializerV2())
                  ->paginateWith(new IlluminatePaginatorAdapter($databuktipaging))
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

        } catch (QueryException $ex) {
            throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
        }
    }

    public function verifikasi_upload(Request $request,$idbukti){
        $bukti = UploadBukti::where('id',$idbukti)->first();

        $dari = date('Y-m-d',strtotime($request->dari));
        $sampai = date('Y-m-d',strtotime($request->sampai));
        
        $date1 = $bukti->dari;
        $date2 = $bukti->sampai;

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1) +1;

        if($request->id_petugas == ''){
            $messages = 'PETUGAS TIDAK DI TEMUKAN!';
              $respone =  fractal()
                  ->item($messages)
                  ->transformWith(new ErorrTransformer)      
                  ->toArray();
              return response()->json($respone, 401);
        }else{
            $aksi = DB::table('detail_trs_wr')
                ->whereRaw('id_wr = '.$bukti->id_wr.' AND status = 2 AND bulan between "'.$dari.'" and "'.$sampai.'"')
                ->update(['status' => '1']); 

            if($aksi){
                
                

                $upah = UpahPetugas::where('id_petugas',$request->id_petugas)->where('status',0)->first();
                if($upah){
                    $upahgo = UpahPetugas::where('id_petugas',$request->id_petugas)->where('status',0)->first();
                    $upahgo->total_pungut =  $upahgo->total_pungut+$diff;
                    $upahgo->save();
                }else{
                    $upahgo = new UpahPetugas;
                    $upahgo->id_petugas = $request->id_petugas;
                    $upahgo->total_pungut = $diff;
                    $upahgo->status = 0;
                    $upahgo->status_upah = 0;
                    $upahgo->save();
                }


                $bukti->status = 1;
                $bukti->id_petugas = $request->id_petugas;
                $bukti->id_upah = $upahgo->id;

                $kode = UploadBukti::orderBy('id_pembayaran', 'desc')->first();
                if($kode){
                    if($kode->id_pembayaran == ''){
                      $kodebrg = '00000001';
                    }else{
                        $kodebrg1 = substr($kode->id_pembayaran, 0,8)+1;
                        if($kodebrg1 < 10){
                              $kodebrg = "0000000".$kodebrg1;
                        }else if($kodebrg1 > 9 && $kodebrg1 < 100){
                              $kodebrg = "000000".$kodebrg1;
                        }else if($kodebrg1 == 100){
                              $kodebrg = "0000100";
                        }else if($kodebrg1 > 100 && $kodebrg1 < 1000){
                              $kodebrg = "00000".$kodebrg1;
                        }else if($kodebrg1 == 1000){
                              $kodebrg = "0001000";
                        }else if($kodebrg1 > 1000 && $kodebrg1 < 10000){
                              $kodebrg = "0000".$kodebrg1;
                        }else if($kodebrg1 == 10000){
                              $kodebrg = "0010000";
                        }else if($kodebrg1 > 10000 && $kodebrg1 < 100000){
                              $kodebrg = "000".$kodebrg1;
                        }else if($kodebrg1 == 100000){
                              $kodebrg = "0100000";
                        }else if($kodebrg1 > 100000 && $kodebrg1 < 1000000){
                              $kodebrg = "00".$kodebrg1;
                        }else if($kodebrg1 == 1000000){
                              $kodebrg = "1000000";
                        }else if($kodebrg1 > 1000000){
                              $kodebrg = $kodebrg1;
                        }
                    }
                }else{
                    $kodebrg = '00000001';
                }
                $bukti->id_pembayaran = $kodebrg;
                $bukti->tgl_resi = date('Y-m-d H:i:s');

                $wajibb = WajibRetribusi::where('id',$bukti->id_wr)->first();
                if($wajibb->district_id == '01'){
                    $singk = "BT";
                }elseif($wajibb->district_id == '02'){
                    $singk = "KA";
                }elseif($wajibb->district_id == '03'){
                    $singk = "MR";
                }elseif($wajibb->district_id == '04'){
                    $singk = "SK";
                }elseif($wajibb->district_id == '05'){
                    $singk = "LB";
                }elseif($wajibb->district_id == '06'){
                    $singk = "KR";
                }elseif($wajibb->district_id == '07'){
                    $singk = "BR";
                }elseif($wajibb->district_id == '08'){
                    $singk = "JB";
                }elseif($wajibb->district_id == '09'){
                    $singk = "UK";
                }


                // $kohir = UploadBukti::orderBy('no_kohir', 'desc')->first();
                // if($kohir){
                //     if($kohir->no_kohir == ''){
                //       $nokohir = '0001/'.$singk.'/'.date('Y');
                //     }else{
                //         $nokohir1 = substr($kohir->no_kohir, 0,-8)+1;
                //         if($nokohir1 < 10){
                //               $nokohir = "000".$nokohir1."/".$singk."/".date('Y');
                //         }else if($nokohir1 > 9 && $nokohir1 < 100){
                //               $nokohir = "00".$nokohir1."/".$singk."/".date('Y');
                //         }else if($nokohir1 == 100){
                //               $nokohir = "0100/".$singk."/".date('Y');
                //         }else if($nokohir1 > 100 && $nokohir1 < 1000){
                //               $nokohir = "0".$nokohir1."/".$singk."/".date('Y');
                //         }else if($nokohir1 == 1000){
                //               $nokohir = "1000/".$singk."/".date('Y');
                //         }else if($nokohir1 > 1000 && $nokohir1 < 10000){
                //               $nokohir = $nokohir1."/".$singk."/".date('Y');
                //         }
                //     }
                // }else{
                //     $nokohir = '0001/'.$singk.'/'.date('Y');
                // }

                // $bukti->no_kohir = $nokohir;
                $bukti->save();

                

                

                $warrr = WajibRetribusi::where('id',$bukti->id_wr)->first();
                $tagihann = Tagihan::where('id_wr',$warrr->id)
                        ->where('status',0)
                        ->orderBy('bulan','ASC')
                        ->first();

                $totalhargaa = $tagihann->tarif*$diff;

                $ambilpetugas = Petugas::where('id',$bukti->id_petugas)->first();
                $msg = array('success'  => true,
                                'tgl_resi'  => date('d M Y, H:i',strtotime($bukti->tgl_resi)),
                                'id_pembayaran'  => $kodebrg,
                                'no_kohir'  => "",
                                'code'  => $warrr->code,
                                'nama'  => $warrr->nama,
                                'metode'  => 'Pembayaran Melalui Aplikasi (Transfer Tunai)',
                                'pembayaran'  => date('F/Y',strtotime($bukti->dari)).' - '.date('F/Y',strtotime($bukti->sampai)),
                                'banyak_bulan'  => $diff." Bulan",
                                'tarif'  => $tagihann->tarif,
                                'total'  => ''.$totalhargaa.'',
                                'penanggung_jawab'  => $ambilpetugas->nama,
                                'hp'  => $ambilpetugas->hp,
                            );
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
          $bukti->id_petugas = $request->id_petugas;
          $bukti->tgl_upload = date("Y-m-d H:i:s");

          

            if($request->id_petugas == ''){
                $messages = 'PETUGAS TIDAK DI TEMUKAN!';
                  $respone =  fractal()
                      ->item($messages)
                      ->transformWith(new ErorrTransformer)      
                      ->toArray();
                  return response()->json($respone, 401);
            }else{
                $aksi = DB::table('detail_trs_wr')
                        ->whereRaw('id_wr = '.$wr->id.' AND status = 0 AND bulan between "'.$dari.'" and "'.$sampai.'"')
                        ->update(['status' => '1','tgl_bayar' => date("Y-m-d H:i:s") ]); 
                if($aksi){
                    
                     $upah = UpahPetugas::where('id_petugas',$request->id_petugas)->where('status',0)->first();
                    if($upah){
                        $upahgo = UpahPetugas::where('id_petugas',$request->id_petugas)->where('status',0)->first();
                        $upahgo->total_pungut =  $upahgo->total_pungut+$diff;
                        $upahgo->save();
                    }else{
                        $upahgo = new UpahPetugas;
                        $upahgo->id_petugas = $request->id_petugas;
                        $upahgo->total_pungut = $diff;
                        $upahgo->status = 0;
                        $upahgo->status_upah = 0;
                        $upahgo->save();
                    }


                    $bukti->id_upah = $upahgo->id;
                    $kode = UploadBukti::orderBy('id_pembayaran', 'desc')->first();
                    if($kode){
                        if($kode->id_pembayaran == ''){
                          $kodebrg = '00000001';
                        }else{
                            $kodebrg1 = substr($kode->id_pembayaran, 0,8)+1;
                            if($kodebrg1 < 10){
                                  $kodebrg = "0000000".$kodebrg1;
                            }else if($kodebrg1 > 9 && $kodebrg1 < 100){
                                  $kodebrg = "000000".$kodebrg1;
                            }else if($kodebrg1 == 100){
                                  $kodebrg = "00000100";
                            }else if($kodebrg1 > 100 && $kodebrg1 < 1000){
                                  $kodebrg = "00000".$kodebrg1;
                            }else if($kodebrg1 == 1000){
                                  $kodebrg = "00001000";
                            }else if($kodebrg1 > 1000 && $kodebrg1 < 10000){
                                  $kodebrg = "0000".$kodebrg1;
                            }else if($kodebrg1 == 10000){
                                  $kodebrg = "00010000";
                            }else if($kodebrg1 > 10000 && $kodebrg1 < 100000){
                                  $kodebrg = "000".$kodebrg1;
                            }else if($kodebrg1 == 100000){
                                  $kodebrg = "00100000";
                            }else if($kodebrg1 > 100000 && $kodebrg1 < 1000000){
                                  $kodebrg = "00".$kodebrg1;
                            }else if($kodebrg1 == 1000000){
                                  $kodebrg = "10000000";
                            }else if($kodebrg1 > 1000000){
                                  $kodebrg = $kodebrg1;
                            }
                        }
                    }else{
                        $kodebrg = '00000001';
                    }
                    $bukti->id_pembayaran = $kodebrg;
                    $bukti->tgl_resi = date('Y-m-d H:i:s');

                    $wajibb = WajibRetribusi::where('id',$bukti->id_wr)->first();
                    if($wajibb->district_id == '01'){
                        $singk = "BT";
                    }elseif($wajibb->district_id == '02'){
                        $singk = "KA";
                    }elseif($wajibb->district_id == '03'){
                        $singk = "MR";
                    }elseif($wajibb->district_id == '04'){
                        $singk = "SK";
                    }elseif($wajibb->district_id == '05'){
                        $singk = "LB";
                    }elseif($wajibb->district_id == '06'){
                        $singk = "KR";
                    }elseif($wajibb->district_id == '07'){
                        $singk = "BR";
                    }elseif($wajibb->district_id == '08'){
                        $singk = "JB";
                    }elseif($wajibb->district_id == '09'){
                        $singk = "UK";
                    }


                    // $kohir = UploadBukti::orderBy('no_kohir', 'desc')->first();
                    // if($kohir){
                    //     if($kohir->no_kohir == ''){
                    //       $nokohir = '0001/'.$singk.'/'.date('Y');
                    //     }else{
                    //         $nokohir1 = substr($kohir->no_kohir, 0,-8)+1;
                    //         if($nokohir1 < 10){
                    //               $nokohir = "000".$nokohir1."/".$singk."/".date('Y');
                    //         }else if($nokohir1 > 9 && $nokohir1 < 100){
                    //               $nokohir = "00".$nokohir1."/".$singk."/".date('Y');
                    //         }else if($nokohir1 == 100){
                    //               $nokohir = "0100/".$singk."/".date('Y');
                    //         }else if($nokohir1 > 100 && $nokohir1 < 1000){
                    //               $nokohir = "0".$nokohir1."/".$singk."/".date('Y');
                    //         }else if($nokohir1 == 1000){
                    //               $nokohir = "1000/".$singk."/".date('Y');
                    //         }else if($nokohir1 > 1000 && $nokohir1 < 10000){
                    //               $nokohir = $nokohir1."/".$singk."/".date('Y');
                    //         }
                    //     }
                    // }else{
                    //     $nokohir = '0001/'.$singk.'/'.date('Y');
                    // }

                    // $bukti->no_kohir = $nokohir;

                    $bukti->save();

                   
                    
                   
                    $warrr = WajibRetribusi::where('id',$bukti->id_wr)->first();
                    $tagihann = Tagihan::where('id_wr',$warrr->id)
                            ->where('status',0)
                            ->orderBy('bulan','ASC')
                            ->first();
                    $totalhargaa = $tagihann->tarif*$diff;
                    $ambilpetugas = Petugas::where('id',$bukti->id_petugas)->first();

                    $msg = array('success'  => true,
                                'tgl_resi'  => date('d M Y, H:i',strtotime($bukti->tgl_resi)),
                                'id_pembayaran'  => $kodebrg,
                                'no_kohir'  => "",
                                'code'  => $warrr->code,
                                'nama'  => $warrr->nama,
                                'metode'  => 'Pembayaran Manual Ke Petugas',
                                'pembayaran'  => date('F/Y',strtotime($bukti->dari)).' - '.date('F/Y',strtotime($bukti->sampai)),
                                'banyak_bulan'  => $diff." Bulan",
                                'tarif'  => $tagihann->tarif,
                                'total'  => ''.$totalhargaa.'',
                                'penanggung_jawab'  => $ambilpetugas->nama,
                                'hp'  => $ambilpetugas->hp,
                            );
                    return response()->json($msg, 200);
                }else{
                  $messages = 'DATA TIDAK DITEMUKANnnn';
                  $respone =  fractal()
                      ->item($messages)
                      ->transformWith(new ErorrTransformer)      
                      ->toArray();
                  return response()->json($respone, 401);
                }
            }
            
    }
    
    public function tolak_bukti(Request $request,$idbukti){
        $bukti = UploadBukti::where('id',$idbukti)->first();

        $dari = date('Y-m-d',strtotime($request->dari));
        $sampai = date('Y-m-d',strtotime($request->sampai));

        if($request->id_petugas == ''){
            $messages = 'PETUGAS TIDAK DI TEMUKAN!';
              $respone =  fractal()
                  ->item($messages)
                  ->transformWith(new ErorrTransformer)      
                  ->toArray();
              return response()->json($respone, 401);
        }else{
            $aksi = DB::table('detail_trs_wr')
                ->whereRaw('id_wr = '.$bukti->id_wr.' AND status = 2 AND bulan between "'.$dari.'" and "'.$sampai.'"')
                ->update(['status' => '0','tgl_bayar' => 'NULL' ]); 

            if($aksi){

                $bukti->status = 3;
                $bukti->id_petugas = $request->id_petugas;
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

    public function get_lokasi(Request $request,$id){
        $validator = Validator::make($request->all(),
                             array(
                        'lat' => 'required',
                        'lng' => 'required'
                            ), array(
                        'lat.required' => 'Lokasi Tidak Ditemukan!',
                        'lng.required' => 'Lokasi Tidak Ditemukan!',
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

            $petugass = Petugas::where('id', '=', $id)->first();

            if($petugass){

                $petugass->lat = $request->lat;
                $petugass->lng = $request->lng;
                $petugass->save();

                $petugas = Petugas::where('id', '=', $id)->first();
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

    public function get_upah(Request $request,$id){
        // $upah = DB::table('upah_petugas as a')
        //         ->select('a.*', DB::raw('SUM(b.total_bayar) as total_bayar'))
        //         ->leftJoin('upload_bukti_trs as b','a.id_petugas','=','b.id_petugas')
        //         ->groupBy('a.id_petugas')
        //         ->first();
        $upah = Petugas::where('id',$id)->first();

        if($upah){
            $respone =  fractal()
                ->item($upah)
                ->transformWith(new UpahPetugasTransformer)
                ->serializeWith(new ArraySerializer)
                ->toArray();
            return response()->json($respone, 200);
        }else{
            $messages = 'DATA TIDAK DITEMUKAN!';
            $respone =  fractal()
                ->item($messages)
                ->transformWith(new ErorrTransformer)      
                ->toArray();
            return response()->json($respone, 401);
        }
    }
    
    
    public function get_data_wr_status(Request $request){
        try {
            $warrpaging = WajibRetribusi::where('is_active',0)
                        ->orderBy('nama', 'ASC')
                        ->paginate(10);

            $warr = $warrpaging->getCollection();

            if($warr){
                $respone =  fractal()
                    ->collection($warr, new WajibRetribusiGetDataTransformer(), 'data')
                    // ->transformWith(new WajibRetribusiGetDataTransformer)
                    ->serializeWith(new ArraySerializerV2())
                    ->paginateWith(new IlluminatePaginatorAdapter($warrpaging))
                    ->toArray();
                return response()->json($respone, 200);
            }else{
                $messages = 'DATA TIDAK DITEMUKAN!';
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)      
                    ->toArray();
                return response()->json($respone, 401);
            }
        } catch (QueryException $ex) {
            throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
        }
    }
    
    public function get_data_wr_status_search(Request $request){
        try {
            $warrpaging = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->where('a.is_active',0)
                ->whereRaw('a.villages_id = '.$request->id_gampong.' AND (a.code LIKE "%'.$request->search.'%" OR a.nama LIKE "%'.$request->search.'%" OR a.alamat LIKE "%'.$request->search.'%" OR b.name LIKE "%'.$request->search.'%" OR c.name LIKE "%'.$request->search.'%")')
                ->orderBy('a.nama', 'ASC')
                ->paginate(10);

            $warr = $warrpaging->getCollection();
            
            if($warr){
                $respone =  fractal()
                    ->collection($warr, new WajibRetribusiGetDataTransformer(), 'data')
                    // ->transformWith(new WajibRetribusiGetDataTransformer)
                    ->serializeWith(new ArraySerializerV2())
                    ->paginateWith(new IlluminatePaginatorAdapter($warrpaging))
                    ->toArray();
                return response()->json($respone, 200);
            }else{
                $messages = 'DATA TIDAK DITEMUKAN!';
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)      
                    ->toArray();
                return response()->json($respone, 401);
            }
        } catch (QueryException $ex) {
            throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
        }
    }
    
    public function get_data_wr_status_bypetugas_search(Request $request){
        try {
            
            $warrpaging = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->where('a.is_active',0)
                ->whereRaw('a.villages_id = '.$request->id_gampong.' AND (a.code LIKE "%'.$request->search.'%" OR a.nama LIKE "%'.$request->search.'%" OR a.alamat LIKE "%'.$request->search.'%" OR b.name LIKE "%'.$request->search.'%" OR c.name LIKE "%'.$request->search.'%")')
                ->orderBy('a.nama', 'ASC')
                ->paginate(10);

            $warr = $warrpaging->getCollection();

            if($warr){
                $respone =  fractal()
                    ->collection($warr, new WajibRetribusiGetDataTransformer(), 'data')
                    // ->transformWith(new WajibRetribusiGetDataTransformer)
                    ->serializeWith(new ArraySerializerV2())
                    ->paginateWith(new IlluminatePaginatorAdapter($warrpaging))
                    ->toArray();
                return response()->json($respone, 200);
            }else{
                $messages = 'DATA TIDAK DITEMUKAN!';
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)      
                    ->toArray();
                return response()->json($respone, 401);
            }
        } catch (QueryException $ex) {
            throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
        }
    }
    
    public function verifikasi_detail_data_wr(Request $request,$id){
        $warr = WajibRetribusi::where('id',$id)->where('is_active',0)->first();

        if($warr){
            $respone =  fractal()
                ->item($warr)
                ->transformWith(new WajibRetribusiDetailTransformer)
                ->serializeWith(new ArraySerializer)
                ->toArray();
            return response()->json($respone, 200);
        }else{
            $messages = 'DATA TIDAK DITEMUKAN!';
            $respone =  fractal()
                ->item($messages)
                ->transformWith(new ErorrTransformer)      
                ->toArray();
            return response()->json($respone, 401);
        }
    }

    public function verifikasi_data_wr(Request $request,$id){

        $validator = Validator::make($request->all(), 
            
            array(  

                    // 'nik' => 'required',
                    'nama' => 'required',
                    // 'hp'         => 'numeric|min:15|required',
                    // 'district_id' => 'required',
                    // 'villages_id' => 'required',
                    'alamat' => 'required',
                    // 'jenis_lokasi' => 'required',
                    // 'jenis_retribusi' => 'required',
                    'username'         => 'required',
                    'password'         => 'required',
                    // 'email'         => 'email|required',
                    
                ), 
            array(  
                    // 'nik.required' => 'NIK Tidak Boleh Kosong',
                    'nama.required' => 'Nama Tidak Boleh Kosong',
                    // 'hp.numeric' => 1003,
                    // 'hp.min' => 1004,
                    // 'hp.required' => 'No Hp Tidak Boleh Kosong',
                    // 'district_id.required' => 'Kecamatan Tidak Boleh Kosong',
                    // 'villages_id.required' => 'Gampong Tidak Boleh Kosong',
                    // 'alamat.required' => 'Alamat Tidak Boleh Kosong',
                    // 'jenis_lokasi.required' => 'Silahkan Pilih Jenis Lokasi',
                    // 'jenis_retribusi.required' => 'Silahkan Pilih Jenis Retribusi',
                    'username.required' => 'Username Tidak Boleh Kosong',
                    'password.required' => 'Password Tidak Boleh Kosong',
                    // 'email.email' => 1001,
                    // 'email.required' => 'Email Tidak Boleh Kosong',
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
              $warrdata = WajibRetribusi::where('id',$id)->first();
              if($request->hp != ''){
                  $warrhp = WajibRetribusi::where('id','!=',$id)->where('hp',$request->hp)->first();
              }else{
                  $warrhp = '';
              }
              
              $warruseername = WajibRetribusi::where('id','!=',$id)->where('username',$request->username)->first();
              
              
              if($request->email != ''){
                  $warremail = WajibRetribusi::where('id','!=',$id)->where('email',$request->email)->first();
              }else{
                  $warremail = '';
              }
              

            if($warrdata){
                if($warruseername){
                        $messages = 'Username Sudah Digunakan!';
                        $respone =  fractal()
                            ->item($messages)
                            ->transformWith(new ErorrTransformer)
                              
                            ->toArray();
                        return response()->json($respone, 411);
                }else{
                    if($warrhp != ''){
                        $messages = 'No Hp Sudah Digunakan!';
                        $respone =  fractal()
                            ->item($messages)
                            ->transformWith(new ErorrTransformer)
                                
                            ->toArray();
                        return response()->json($respone, 411);
                    }else{
                        if($warremail != ''){
                            $messages = 'Alamat Email Sudah Digunakan!';
                            $respone =  fractal()
                                ->item($messages)
                                ->transformWith(new ErorrTransformer)
                                  
                                ->toArray();
                            return response()->json($respone, 411);
                        }else{
                            $hash               = $this->getHash('123456');
                              $encrypted_password = $hash['encrypted'];
                              $salt               = $hash['salt'];


                              $warrdata->regency_id = '71';
                              $warrdata->district_id = $request->district_id;
                              $warrdata->villages_id = $request->villages_id;
                              $warrdata->jenis_id = $request->jenis_retribusi;
                              $warrdata->nik = $request->nik;
                              $warrdata->nama = $request->nama;
                              $warrdata->alamat = $request->alamat;
                              $warrdata->hp = $request->hp;
                              $warrdata->username = $request->username;
                              $warrdata->email = $request->email;
                              $warrdata->password = $encrypted_password;
                              $warrdata->salt = $salt;
                              $warrdata->is_active = 0;
                              $warrdata->email_verify = 0;
                              $warrdata->lat = $request->lat;
                              $warrdata->lng = $request->lng;
                              
                              
                              $kode = WajibRetribusi::where('district_id',$request->district_id)->where('villages_id',$request->villages_id)->orderBy('code', 'desc')->first();
                              if($kode){
                                  $kodebrg1 = substr($kode->code, 10,15)+1;
                                  if($kodebrg1 < 10){
                                      $kodebrg = $request->villages_id."0000".$kodebrg1;
                                  }else if($kodebrg1 > 9 && $kodebrg1 < 100){
                                      $kodebrg = $request->villages_id."000".$kodebrg1;
                                  }else if($kodebrg1 == 100){
                                      $kodebrg = $request->villages_id."00100";
                                    }else if($kodebrg1 > 100 && $kodebrg1 < 1000){
                                      $kodebrg = $request->villages_id."00".$kodebrg1;
                                  }else if($kodebrg1 == 1000){
                                      $kodebrg = $request->villages_id."01000";
                                    }else if($kodebrg1 > 1000 && $kodebrg1 < 10000){
                                      $kodebrg = $request->villages_id."0".$kodebrg1;
                                  }else if($kodebrg1 == 10000){
                                      $kodebrg = $request->villages_id."10000";
                                    }else if($kodebrg1 > 10000){
                                      $kodebrg = $request->villages_id.$kodebrg1;
                                  }
                              }else{
                                  $kodebrg = $request->villages_id.'00001';
                              }
        
                              $warrdata->code = $kodebrg;
        
                              // $url = url('/api/get_wajib_retribusi/detailcode');
                              $destinationPathqr = 'uploads/qrcode';
                              $imageqr = QrCode::format('png')
                                       ->size(300)->errorCorrection('H')
                                       ->generate($kodebrg);
                              $output_file = $kodebrg . '.png';
                              Storage::disk('public_uploadsqrcode')->put($output_file, $imageqr);
                              $direktoriqr = $destinationPathqr.'/'.$output_file;
                              $warrdata->qrcode = $direktoriqr;
                              
                                
                                if (Input::file('ktp')) {
                                    if ($warrdata->ktp != "") {
                                          $path = $warrdata->ktp;
                                          unlink(public_path($path));
                                      }
                                    $image = $request->file('ktp');
                                    $input['imagename'] =  'ktp'.date('ymdhis').'.'.$image->getClientOriginalExtension();
                                    $destinationPath = ('uploads/wr/ktp');
                                    $img = Image::make($image->getRealPath());
                                    $img->save(public_path($destinationPath.'/'.$input['imagename']));
            
                                    $image->move(public_path($destinationPath, '/'.$input['imagename']));
            
                                    $direktori = $destinationPath.'/'.$input['imagename'];
                                    $warrdata->ktp = $direktori;
                                  }
                              $warrdata->save();

                              $warr = WajibRetribusi::where('id',$id)->first();
                            $respone =  fractal()
                                ->item($warr)
                                ->transformWith(new WajibRetribusiAktifTransformer)
                                ->serializeWith(new ArraySerializer)
                                ->toArray();
                            return response()->json($respone, 200);
                        

                        }
                    }
                }
            }else{
                $messages = 'DATA TIDAK DITEMUKAN!';
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)      
                    ->toArray();
                return response()->json($respone, 401);
            }

        }
    }


    public function verifikasi_photo_rumah(Request $request,$id){
      $validator = Validator::make($request->all(), 
            
            array(  

                    // 'image' => 'required',
                    // 'imagedua' => 'required',
                    // 'imagetiga' => 'required',
                    'jenis_lokasi' => 'required',
                    'jenis_retribusi' => 'required',
                    'alamat' => 'required',
                    'district_id' => 'required',
                    'villages_id' => 'required',
                    
                ), 
            array(  
                    // 'image.required' => 'Photo Rumah Pertama Tidak Boleh Kosong',
                    // 'imagedua.required' => 'Photo Rumah Kedua Tidak Boleh Kosong',
                    // 'imagetiga.required' => 'Photo Rumah Ketiga Tidak Boleh Kosong',
                    'jenis_lokasi.required' => 'Silahkan Pilih Jenis Lokasi',
                    'jenis_retribusi.required' => 'Silahkan Pilih Jenis Retribusi',
                    'alamat.required' => 'Alamat Tidak Boleh Kosong',
                    'district_id.required' => 'Kecamatan Tidak Boleh Kosong',
                    'villages_id.required' => 'Gampong Tidak Boleh Kosong',
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

            $imagee = DetailImage::where('id_wr',$admin->id)->first();

            if($admin){
                $datawr = WajibRetribusi::where('id',$id)->first();

                if($request->jenis_lokasi == 'kota'){
                    $datawr->kota = 1;
                    $datawr->gampong = 0;
                }elseif($request->jenis_lokasi == 'gampong'){
                    $datawr->kota = 0;
                    $datawr->gampong = 1;
                }

                $datawr->alamat = $request->alamat;
                $datawr->district_id = $request->district_id;
                $datawr->villages_id = $request->villages_id;
                $datawr->jenis_id = $request->jenis_retribusi;
                $datawr->lat = $request->lat;
                $datawr->lng = $request->lng;
                $datawr->is_active = 1;
                $datawr->email_verify = 1;
                $datawr->id_petugas = $request->id_petugas;
                $datawr->wkt_verifikasi_data = date('Y-m-d H:i:s');
                $datawr->save();

                $begin = new DateTime();
                $begin->modify( 'first day of this month' );
                $end = new DateTime(); 
                $end->modify( 'first day of +2 year' );

                $interval = DateInterval::createFromDateString('1 month');
                $period = new DatePeriod($begin, $interval, $end);


                $getjenis = JenisRetribusi::where('id',$datawr->jenis_id)->first();
                if($datawr->kota == 1){
                    $trff = $getjenis->tarif_kota;
                }elseif($datawr->gampong == 1){
                    $trff = $getjenis->tarif_gampong;
                }
              
                foreach ($period as $dt) {

                $data = array(
                    'id_wr' => $datawr->id,
                    'bulan' => $dt->format("Y-m-d"),
                    'tarif' => $trff,
                    'status' => 0
                );

                $insertData[] = $data;
                }
                Tagihan::insert($insertData);

                if($imagee){
                    $pwbr       = sha1(rand());
                    $pwbr       = substr($pwbr, 0, 5);
                    $imagee->id_wr = $admin->id;
                    if (Input::file('image')) {
                        if ($imagee->image != "") {
                            $path = $imagee->image;
                            unlink(public_path($path));
                        }
                        $image = $request->file('image');
                        $input['imagename'] =  $pwbr.'image'.date('ymdhis').'.'.$image->getClientOriginalExtension();
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
                        if ($imagee->imagedua != "") {
                            $path = $imagee->imagedua;
                            unlink(public_path($path));
                        }
                        $image = $request->file('imagedua');
                        $input['imagename'] =  $pwbr.'image2'.date('ymdhis').'.'.$image->getClientOriginalExtension();
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
                        if ($imagee->imagetiga != "") {
                            $path = $imagee->imagetiga;
                            unlink(public_path($path));
                        }
                        $image = $request->file('imagetiga');
                        $input['imagename'] =  $pwbr.'image3'.date('ymdhis').'.'.$image->getClientOriginalExtension();
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
                }else{
                    $pwbr       = sha1(rand());
                    $pwbr       = substr($pwbr, 0, 5);
                    $imageenew = new DetailImage;
                    $imageenew->id_wr = $admin->id;
                    if (Input::file('image')) {
                        $image = $request->file('image');
                        $input['imagename'] =  $pwbr.'image'.date('ymdhis').'.'.$image->getClientOriginalExtension();
                        $destinationPath = ('uploads/wrdetail');
                        $img = Image::make($image->getRealPath());
                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path($destinationPath.'/'.$input['imagename']));

                        $image->move(public_path($destinationPath, '/'.$input['imagename']));

                        $direktori = $destinationPath.'/'.$input['imagename'];
                        $imageenew->image = $direktori;
                    }

                    if (Input::file('imagedua')) {
                        $image = $request->file('imagedua');
                        $input['imagename'] =  $pwbr.'image2'.date('ymdhis').'.'.$image->getClientOriginalExtension();
                        $destinationPath = ('uploads/wrdetail');
                        $img = Image::make($image->getRealPath());
                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path($destinationPath.'/'.$input['imagename']));

                        $image->move(public_path($destinationPath, '/'.$input['imagename']));

                        $direktori = $destinationPath.'/'.$input['imagename'];
                        $imageenew->imagedua = $direktori;
                    }

                    if (Input::file('imagetiga')) {
                        $image = $request->file('imagetiga');
                        $input['imagename'] =  $pwbr.'image3'.date('ymdhis').'.'.$image->getClientOriginalExtension();
                        $destinationPath = ('uploads/wrdetail');
                        $img = Image::make($image->getRealPath());
                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path($destinationPath.'/'.$input['imagename']));

                        $image->move(public_path($destinationPath, '/'.$input['imagename']));

                        $direktori = $destinationPath.'/'.$input['imagename'];
                        $imageenew->imagetiga = $direktori;
                    }

                    $imageenew->save();
                }

                $warr = WajibRetribusi::where('id',$admin->id)->first();
                $respone =  fractal()
                      ->item($warr)
                      ->transformWith(new WajibRetribusiAktifTransformer)
                      ->serializeWith(new ArraySerializer)                         
                      ->toArray();
                return response()->json($respone, 201);
            }else{
                $messages = 'DATA TIDAK DITEMUKAN!';
                $respone =  fractal()
                    ->item($messages)
                    ->transformWith(new ErorrTransformer)      
                    ->toArray();
                return response()->json($respone, 401);
            }
        }
    }
    
    public function reset_password_wr(Request $request,$id){

        $warr = WajibRetribusi::where('id',$id)->first();

        if($warr){

            $respone =  fractal()
                ->item($warr)
                ->transformWith(new WajibRetribusiAktiPasswordfTransformer)
                ->serializeWith(new ArraySerializer)
                ->toArray();
            return response()->json($respone, 200);
        }else{
            $messages = 'DATA TIDAK DITEMUKAN!';
            $respone =  fractal()
                ->item($messages)
                ->transformWith(new ErorrTransformer)      
                ->toArray();
            return response()->json($respone, 401);
        }
    }
    
    public function get_resi_bywr(Request $request,$id){
     
      try {

        $wrs = WajibRetribusi::where('id', '=', $id)->first();

        if($wrs){

            $buktipaging = UploadBukti::where('id_wr',$wrs->id)
                    ->where('status','!=',0)
                    ->where('status','!=',3)
                    ->orderBy('tgl_resi', 'DESC')
                    ->paginate(10);

            $bukti = $buktipaging->getCollection();

            if($bukti){
              $respone =  fractal()
                  ->collection($bukti, new BuktiPerWrTransformer(), 'data')
                  ->serializeWith(new ArraySerializerV2())
                    ->paginateWith(new IlluminatePaginatorAdapter($buktipaging))
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
        }else{
            $messages = 2001;
            $respone =  fractal()
                ->item($messages)
                ->transformWith(new ErorrTransformer)      
                ->toArray();
            return response()->json($respone, 401);
        }
      } catch (QueryException $ex) {
        throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
      }
    }
    
    public function get_resi_bywr_detail(Request $request,$id_pembayaran){
      try {

        $bukti = UploadBukti::where('id',$id_pembayaran)->first();

        if($bukti){
          $respone =  fractal()
              ->item($bukti)
              ->transformWith(new BuktiPerWrDetailTransformer)
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
        
      } catch (QueryException $ex) {
        throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
      }
    }
    
    public function get_data_pembayaran(Request $request,$id){
        
        try {

        $buktipaging = UploadBukti::where('id_petugas',$id)
                    ->where('status','!=',0)
                    ->where('status','!=',3)
                    ->orderBy('tgl_resi', 'DESC')
                    ->paginate(10);

            $bukti = $buktipaging->getCollection();

            if($bukti){
              $respone =  fractal()
                  ->collection($bukti, new DataPembayaranTransformer(), 'data')
                  ->serializeWith(new ArraySerializerV2())
                    ->paginateWith(new IlluminatePaginatorAdapter($buktipaging))
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
      } catch (QueryException $ex) {
        throw new HttpException(500, "Gagal menampilkan data, coba lagi!");
      }
        
    }
    
}
