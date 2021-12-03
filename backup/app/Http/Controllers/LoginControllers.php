<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;
use DB;
use Validator;
use Response;
use Hash;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

use App\Http\Models\Admin;
use App\Http\Models\Token;


class LoginControllers extends Controller
{
    public function index(Request $request){
  	  	if($request->session()->has('is_active')){
          
            return redirect('/devadmin/dashboard');
            
        }else{
            return redirect('/devadmin/login');
        }
  	}

  	public function logout(Request $request){

	      $request->session()->flush();
	      
	      return redirect('/devadmin/login');

	  }

	public function login(Request $request){
  	  	
  	   return view('login');
  	}

    public function emails(Request $request){
        
       return view('emails.email_notif');
    }

    public function resetpassword(Request $request){
        
       return view('resetpassword');
    }

    public function resetpasswordaksi(Request $request){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'email' => 'required'
             ),

        array(
                           
                'email.required' => 'email tidak boleh kosong',
            )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/reset-password')->withInput($request->input())->withErrors($validator);
        
        }else {

            $admin = Admin::where('email',$request->email)->first();

            if($admin){
              $token = Token::where('email',$request->email)->first();
              $email = $token->email;
              $tokenemail = $token->token;

              $url = url('/reset-password');
              $link = $url.'/'.$tokenemail;

              $message_body = array('emailreset' => $link, 'nama' => $admin->nama);
              $subject = "SIMAUN - Sistem Manajemen ASN Untuk Negeri - Reset Password";
      
              Mail::send('emails.email_admin', array('mail_body' => $message_body), function ($message) use ($email, $subject) {
                    $message->to($email)->subject($subject);
                });

              return redirect('/reset-password')->with('success','Email Berhasil Dikirimkan');
            }else{
              return redirect('/reset-password')->with('fail','Username Atau Email Tidak Ditemukan!.');
            }
        }
       
    }

    public function resetpasswordtoken(Request $request,$token){
        
      $cek = Token::where('token',$token)->first();
      if($cek){

        return view('resetpasswordnew',compact('cek'));
      }else{
        return view('resetpasswordnot');
      }
    }

    public function resetpasswordtokenaksi(Request $request,$token){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'password' => 'required',
                'password2' => 'required'
             ),

        array(
                           
                'password.required' => 'password tidak boleh kosong',
                'password2.required' => 'password2 tidak boleh kosong'
            )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('reset-password/'.$token)->withInput($request->input())->withErrors($validator);
        
        }else {

            $cektoken = Token::where('token',$token)->first();
            if($request->password2 != $request->password){
                return redirect('reset-password/'.$token)->with('fail','Konfirmasi Password Tidak Sama!')->withInput($request->input());
            }else{

              $admin = Admin::where('email',$cektoken->email)->first();

              $hash               = $this->getHash($request->password);
              $encrypted_password = $hash['encrypted'];
              $salt               = $hash['salt'];

              $admin->password = $encrypted_password;
              $admin->salt = $salt;

              $admin->save();


              $cektoken = Token::where('token',$token)->first();
              $cektoken->delete();
              return redirect('/devadmin/login')->with('success','Password Berhasil Diganti!');
            }
        }
    }


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


    public function register(Request $request){
  		return view('registrasi');
  	}


  	public function registerverify(Request $request){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'name' => 'required',
                'email' => 'required',
                'username' => 'required',
                'password1' => 'required',
                'password2' => 'required'
             ),

        array(
                
                'name.required' => 'name tidak boleh kosong',             
                'email.required' => 'email tidak boleh kosong',             
                'username.required' => 'username tidak boleh kosong',
                'password1.required' => 'password1 tidak boleh kosong',
                'password2.required' => 'password2 tidak boleh kosong'
            )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/register')->withInput($request->input())->withErrors($validator);
        
        }else {

            $admin = Admin::where('username',$request->username)->first();

            if($admin){
              return redirect('/devadmin/register')->with('fail','Username Sudah digunakan')->withInput($request->input());
            }else{
            	if($request->password2 != $request->password1){
            		return redirect('/devadmin/register')->with('fail','Konfirmasi Password Tidak Sama!')->withInput($request->input());
            	}else{
            		$hash               = $this->getHash($request->password1);
		        	$encrypted_password = $hash['encrypted'];
		        	$salt               = $hash['salt'];
	            	
	              $admin = new Admin;

	              $admin->name = $request->name;
	              $admin->email = $request->email;
	              $admin->username = $request->username;
	              $admin->password = $encrypted_password;
	              $admin->salt = $salt;
	              $admin->role_id = 2;
	              $admin->is_active = 1;

	              $admin->save();

	              $token = new Token;

	              $token->email = $request->email;
	              $token->token = encrypt($request->name.$request->email);

	              $token->save();

	              return redirect('/devadmin/login')->with('success','Anda Berhasil Mendaftar! Silahkan Login.');
            	}
            }
        }
       
    }

    public function loginverify(Request $request){
    	$validator = Validator::make($request->all(),   
        
            array(
                    
                    'username' => 'required',
                    'password' => 'required',
                 ),

            array(
                    
                    'username.required' => 'username tidak boleh kosong',              
                    'password.required' => 'Password tidak boleh kosong',
                  )
        );

        //Kondisi validasi (Pesan Error yang akan terjadi)
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/login')->withInput($request->input())->withErrors($validator);
        
        }else {

            $username = $request->username;
            $password = $request->password;

            $admin = Admin::where('username',$username)->orWhere('email', $username)->first();

            if($admin){
                if($admin->is_active == 0){
                  return redirect('/devadmin/login')->with('fail','Akun Anda Tidak Aktif!');
                }else{
                  $db_encrypted_password = $admin->password;
                  $salt = $admin->salt;

                  //Pengecekan Password
                  $hasil_pass = $this->verifyHash($password.$salt,$db_encrypted_password);

                  if($hasil_pass) {
                   $take = Admin::where('username',$username)->orWhere('email', $username)->first();
                         session()->put('name', $take->name);
                         session()->put('email', $take->email);
                         session()->put('id', $take->id);
                         session()->put('username', $take->username);
                         session()->put('role_id', $take->role_id);
                         session()->put('is_active', $take->is_active);
                    if($take->role_id == 1){
                         session()->put('is_admin', 1);
                           
                         return redirect('/devadmin/dashboard');
                    }else{
                         session()->put('is_user', 1);
                           
                         return redirect('/devadmin/dashboard');
                    }
                         
                  }else {
                    return redirect('/devadmin/login')->with('fail','Password anda Salah!');
                  }
                }
                
            }else {
	      		 return redirect('/devadmin/login?error=1')->with('fail','Username Atau Email Tidak Ditemukan!');
            }
        }
    }

}
