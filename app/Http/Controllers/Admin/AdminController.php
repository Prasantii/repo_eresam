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
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Http\Models\Admin;
use App\Http\Models\Role;
use App\Http\Models\Aksesmenu;
use App\Http\Models\Submenu;
use App\Http\Models\TitleMenu;
use App\Http\Models\Token;
use App\Http\Models\Datapegawai;

class AdminController extends Controller
{
    /////////////////////////////////////////// DATA PENGGUNA

    public function getHash($password)
    {
        $salt       = sha1(rand());
        $salt       = substr($salt, 0, 10);
        $encrypted  = password_hash($password.$salt, PASSWORD_DEFAULT);
        $hash       = array("salt" => $salt, "encrypted" => $encrypted);

        return $hash;
    }

    public function verifyHash($password, $hash)
    {
        return password_verify($password, $hash);
    }
    
    public function data_admin(){

      $admins = Admin::all();
      
      return view('admin.data_admin',compact('admins'))->with(["page" => "home","menu" => "home","menu2" => ""]);
    }

    public function tambah_admin(){
      return view('admin.tambah_admin')->with(["page" => "home","menu" => "home","menu2" => ""]);
    }

    public function tambahadmin(Request $request){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'username' => 'required|min:5',
                'password' => 'required|min:5',
             ),

        array(
                
                'username.required' => 'username tidak boleh kosong',
                'username.min' => 'username harus 5 karakter',                   
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'password minimal 5 karakter',
              )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/tambah-admin')->withErrors($validator);
        
        }else {
            

            $hash               = $this->getHash($request->password);
            $encrypted_password = $hash['encrypted'];
            $salt               = $hash['salt'];

            $username = $request->username;
            $nama = $request->nama;

            $admin = Admin::where('username',$username)->first();

            if($admin){
              return redirect('/devadmin/tambahadmin')->with('success','Username Sudah digunakan');
            }else{
              $admin = new Admin;

              $admin->username = $username;
              $admin->password = $encrypted_password;
              $admin->salt = $salt;
              $admin->nama = $nama;

              $admin->save();

              return redirect('/devadmin/data-admin')->with('success','Data Berhasil Di tambahkan');
            }
        }
       
    }

    public function edit_admin($id){
      $admin = Admin::findOrFail($id);
      
      return view('admin.edit_admin',compact('admin'))->with(["page" => "home","menu" => "home","menu2" => ""]);
    }

    public function editadmin(Request $request , $id){
      $validator = Validator::make($request->all(),   
        
            array(
                    
                    'username' => 'required|min:5',
                 ),

            array(
                    
                    'username.required' => 'username tidak boleh kosong',
                    'username.min' => 'username harus 5 karakter',   
                  )
        );

        //Kondisi validasi (Pesan Error yang akan terjadi)
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/edit-admin/'.$id)->withErrors($validator);
        
        }else {

          $username = $request->username;
          $nama = $request->nama;
          
          $admin = Admin::findOrFail($id);

          if($admin){
           
              $admin->username = $username;
              $admin->nama = $nama;

              $admin->save();

              return redirect('/devadmin/data-admin')->with('success','Data Berhasil di Edit');
          }

        }
    }

    public function adminhapus(Request $request){

        $id = $request->a;
        $admin = Admin::findOrFail($id);
        try{
            $admin->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil hapus Data';
        } catch(QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg']  = 'Gagal hapus Data ' . $ex->getMessage();
        }

        return response($this->response);

    }

    public function edit_adminpas($id){
      $admin = Admin::findOrFail($id);
      
      return view('admin.edit_adminpas',compact('admin'))->with(["page" => "home","menu" => "home","menu2" => ""]);
    }

    public function editadminpas(Request $request , $id){
      $validator = Validator::make($request->all(),   
        
            array(
                    
                    'konpassword' => 'required|min:5',
                    'newpassword' => 'required|min:5',
                 ),

            array(
                    
                    'konpassword.required' => 'Konfirmasi Password Wajib Diisi',
                    'konpassword.min' => 'Konfirmasi Password Minimal 5 karater',
                    'newpassword.required' => 'Password Wajib Diisi',   
                    'newpassword.min' => ' Password Minimal 5 karater',

                  )
        );

        //Kondisi validasi (Pesan Error yang akan terjadi)
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/edit-adminpas/'.$id)->withErrors($validator);
        
        }else {
          

            $newpassword = $request->newpassword;
          $konpassword = $request->konpassword;

          $hash               = $this->getHash($newpassword);
            $encrypted_password = $hash['encrypted'];
            $salt               = $hash['salt'];
          
          $admin = Admin::findOrFail($id);

          if($admin){
              if($newpassword != $konpassword){
                return redirect('/devadmin/edit-adminpas/'.$id)->with('success','Konfirmasi Password Tidak Sama');
              }else{
                $admin->salt = $salt;
                $admin->password = $encrypted_password;
                  $admin->save();

                return redirect('/devadmin/data-admin')->with('success','Password Berhasil di Ubah');
              }
              
          }

        }
    }


    
}
