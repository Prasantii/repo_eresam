<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use View;
use DB;
use Validator;
use Response;
use Hash;
use Auth;
use Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Http\Models\Admin;
use App\Http\Models\Role;
use App\Http\Models\Aksesmenu;
use App\Http\Models\Submenu;
use App\Http\Models\TitleMenu;
use App\Http\Models\Token;

class ProfileController extends Controller
{
    public function profile(Request $request){
      $sesdatanama = $request->session()->get('name');
      $sesdatausername = $request->session()->get('username');
      $sesdataid = $request->session()->get('id');
      $sesdataroleid = $request->session()->get('role_id');

      $data = Admin::where('name',$sesdatanama)->where('username',$sesdatausername)->where('id',$sesdataid)->where('role_id',$sesdataroleid)->first();

      return view('admin.profile',compact('data'))->with(["page" => "My Profile"]);
    }

    public function editprofile(Request $request,$id){
      $user = Admin::where('id', decrypt($id))->first();

      return view('admin.editprofile',compact('user'))->with(["page" => "Edit Profile"]);
    }

    public function editprofileses(Request $request){
      $user = Admin::where('id', $request->session()->get('id'))->first();

      return view('admin.editprofile',compact('user'))->with(["page" => "Edit Profile"]);
    }

    public function editprofileaksi(Request $request,$id){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
             ),

        array(
                
                'name.required' => 'name tidak boleh kosong',           
                'username.required' => 'username tidak boleh kosong',
                'email.required' => 'email tidak boleh kosong',
            )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/user/profile/edit/'.$id)->withInput($request->input())->withErrors($validator);
        
        }else {

            
              $admin = Admin::where('id',decrypt($id))->first();

              $admin->name = $request->name;
              $admin->username = $request->username;
              $admin->email = $request->email;

              if($request->email != $admin->email){

                $cektoken = Token::where('token',$token)->first();
                if($cektoken){
                  $cektoken->delete();
                }
                

                $token = new Token;

                $token->email = $request->email;
                $token->token = encrypt($request->name.$request->email);

                $token->save();
              }



              if (Input::file('image')) {
                if ($admin->image != "") {
                $path = $admin->image;
                unlink(public_path($path));
            }

              $image = $request->file('image');

              $input['imagename'] =  date('ymdhis').'.'.$image->getClientOriginalExtension();

              $destinationPath = ('uploads/profile');
              $img = Image::make($image->getRealPath());
              $img->resize(500, 500, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path($destinationPath.'/'.$input['imagename']));

              $image->move(public_path($destinationPath, '/'.$input['imagename']));

              $direktori = $destinationPath.'/'.$input['imagename'];
              $admin->image = $direktori;
            }

              $admin->save();


              $take = Admin::where('id',decrypt($id))->first();
                    session()->put('name', $take->name);
                    session()->put('username', $take->username);
                    session()->put('email', $take->email);
              return redirect('/user/profile')->with('success','Data Berhasil Di Edit');
            
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

    public function changepassword(Request $request,$id){
      $user = Admin::where('id', decrypt($id))->first();

      return view('admin.gantipassword',compact('user'))->with(["page" => "Change Password"]);
    }

    public function changepasswordses(Request $request){
      $user = Admin::where('id', $request->session()->get('id'))->first();

      return view('admin.gantipassword',compact('user'))->with(["page" => "Change Password"]);
    }


    public function changepasswordaksi(Request $request,$id){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'password1' => 'required',
                'password2' => 'required'
             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/user/profile/changepassword/'.$id)->withInput($request->input())->withErrors($validator);
        
        }else {

              if($request->password2 != $request->password1){
                return redirect('/user/profile/changepassword'.$id)->with('fail','Konfirmasi Password Tidak Sama!')->withInput($request->input());
              }else{
            $hash               = $this->getHash($request->password1);
            $encrypted_password = $hash['encrypted'];
            $salt               = $hash['salt'];

              $admin = Admin::where('id',decrypt($id))->first();

                $admin->password = $encrypted_password;
                $admin->salt = $salt;

                $admin->save();

                return redirect('/user/profile')->with('success','Password Berhasil Di Ganti!');

              }
        }
    }
}
