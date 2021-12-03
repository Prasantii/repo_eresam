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
use App\Http\Models\Icons;

use App\Http\Models\Districts;
use App\Http\Models\Provinces;
use App\Http\Models\Regencies;
use App\Http\Models\Villages;
use App\Http\Models\Zona;
use App\Http\Models\Koordinator;
use App\Http\Models\Petugas;
use App\Http\Models\PetugasEmailVer;
use App\Http\Models\LokasiTugas;

use App\Http\Models\JenisRetribusi;
use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;

use Helperss;

class PetugasController extends Controller
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

    //Data Petugas --------------------------------------------------

    public function datapetugas(Request $request){

    	return view('admin.pegawai.petugas')->with(["page" => "Petugas"]);
    }

    public function data_petugas(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'id_koordinator',
            2 => 'nik',
            3 => 'nama',
            4 => 'hp',
            5 => 'username',
            6 => 'email',
            7 => 'image',
            8 => 'created_at',
            9 => 'updated_at',
            10 => 'is_active',
            11 => 'gampong'
        );

        $totalData = Petugas::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('petugas as a')
                ->select('a.*','b.nama as namakoordinator','c.nama as namazona')
                ->leftJoin('koordinator as b','a.id_koordinator','=','b.id')
                ->leftJoin('zona as c','b.id_zona','=','c.id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('petugas as a')
                ->select('a.*','b.nama as namakoordinator','c.nama as namazona')
                ->leftJoin('koordinator as b','a.id_koordinator','=','b.id')
                ->leftJoin('zona as c','b.id_zona','=','c.id')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.email', 'LIKE', "%{$search}%")
                ->orWhere('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('c.nama', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('petugas as a')
                ->select('a.*','b.nama as namakoordinator','c.nama as namazona')
                ->leftJoin('koordinator as b','a.id_koordinator','=','b.id')
                ->leftJoin('zona as c','b.id_zona','=','c.id')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.email', 'LIKE', "%{$search}%")
                ->orWhere('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('c.nama', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {
                $stat_petugas='';

                if($service->is_active != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-mr-1' a='".encrypt($service->id)."' b='$service->nama' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Aktifkan'><i class='icon-power-switch'></i> Tidak Aktif</button>";
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-lg' a='".encrypt($service->id)."' b='$service->nama' data-container='body' data-toggle='tooltip' data-placement='left' data-content='NonAktifkan'><i class='fa fa-check'></i> Aktif</button>";
                }
                
                if($service->gampong != 1){
                    $stat_petugas = "<button class='btn btn-success btn-shadowed popover-hover activee1 btn-mr-1' a='".encrypt($service->id)."' b='$service->nama' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Aktifkan'><i class='icon-power-switch'></i> Gampong</button>";
                }else{
                    $stat_petugas = "<button class='btn btn-info btn-shadowed popover-hover shutt1 btn-mr-1' a='".encrypt($service->id)."' b='$service->nama' data-container='body' data-toggle='tooltip' data-placement='left' data-content='NonAktifkan'><i class='fa fa-check'></i> Komersil</button>";
                }

                $je=$je.'<br>'.$stat_petugas;


                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['nik'] = $service->nik;
                $nestedData['nama'] = $service->nama;
                $nestedData['email'] = $service->email;
                $nestedData['namazona'] = $service->namazona;
                $nestedData['namakoordinator'] = $service->namakoordinator;
                $nestedData['url'] = encrypt($service->id);
                $nestedData['is_active'] = $je;
                
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        echo json_encode($json_data);
    }

    public function tambahpetugas(Request $request){
        $koordinator = DB::table('koordinator as a')
                ->select('a.id', 'a.id_zona','a.nik','a.nama','a.hp','a.username','a.email','a.image','a.created_at','a.updated_at','c.nama as namazona')
                ->leftJoin('zona as c','a.id_zona','=','c.id')
                ->get();
        return view('admin.pegawai.tambahpetugas',compact('koordinator'))->with(["page" => "Petugas"]);
    }

    public function tambahpetugasaksi(Request $request){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'id_koordinator' => 'required',
                'nik' => 'required',
                'nama' => 'required',
                'hp' => 'required',
                'username' => 'required',
                'email' => 'required',
                'password' => 'required',
                'password2' => 'required'
             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/tambahpetugas')->withInput($request->input())->withErrors($validator);
        
        }else {

            $admin = Petugas::where('username',$request->username)->first();

            if($admin){
              return redirect('/devadmin/tambahpetugas')->with('fail','Username Sudah digunakan')->withInput($request->input());
            }else{
                if($request->password2 != $request->password){
                    return redirect('/devadmin/tambahpetugas')->with('fail','Konfirmasi Password Tidak Sama!')->withInput($request->input());
                }else{
                    $hash               = $this->getHash($request->password);
                    $encrypted_password = $hash['encrypted'];
                    $salt               = $hash['salt'];
                    
                  $admin = new Petugas;

                  $admin->id_koordinator = $request->id_koordinator;
                  $admin->nik = $request->nik;
                  $admin->nama = $request->nama;
                  $admin->hp = $request->hp;
                  $admin->alamat = $request->alamat;
                  $admin->username = $request->username;
                  $admin->email = $request->email;
                  $admin->password = $encrypted_password;
                  $admin->salt = $salt;

                    if($request->is_active == ""){
                       $admin->is_active = 0;
                    }else{
                       $admin->is_active = $request->is_active; 
                    }

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

                    $admin->token = Helperss::generate_token();
                    $admin->token_expiry = Helperss::generate_expiry();


                  $admin->save();

                  $villages_id = $request->input('villages_id');
                    foreach($villages_id as $tag){
                      $comics = new LokasiTugas();
                      $comics->id_petugas = $admin->id;
                      $comics->id_koordinator = $request->id_koordinator;
                      $comics->district_id = $request->district_id;
                      $comics->villages_id = $tag;
                      $comics->save();
                   }
                   
                   $villages_id2 = $request->input('villages_id2');
                   if($villages_id2 != ''){
                      foreach($villages_id2 as $tagg){
                        $comicsgo = new LokasiTugas();
                        $comicsgo->id_petugas = $admin->id;
                        $comicsgo->id_koordinator = $request->id_koordinator;
                        $comicsgo->district_id = $request->district_id2;
                        $comicsgo->villages_id = $tagg;
                        $comicsgo->save();
                     }
                   }

                   $villages_id3 = $request->input('villages_id3');
                   if($villages_id3 != ''){
                      foreach($villages_id3 as $taggg){
                        $comicsgonew = new LokasiTugas();
                        $comicsgonew->id_petugas = $admin->id;
                        $comicsgonew->id_koordinator = $request->id_koordinator;
                        $comicsgonew->district_id = $request->district_id3;
                        $comicsgonew->villages_id = $taggg;
                        $comicsgonew->save();
                     }
                   }

                  $token = new PetugasEmailVer;

                  $token->email = $request->email;
                  $token->token = encrypt($request->name.$request->email);

                  $token->save();

                  return redirect('/devadmin/datapetugas')->with('success','Data Petugas Berhasil Di tambahkan');
                }
            }
        }
       
    }

    public function editpetugasview(Request $request,$id){
        try{
            $petugas = Petugas::where('id',decrypt($id))->first();
            

            if($petugas)
            {
                $koordinator = DB::table('koordinator as a')
                    ->select('a.id', 'a.id_zona','a.nik','a.nama','a.hp','a.username','a.email','a.image','a.created_at','a.updated_at','c.nama as namazona')
                    ->leftJoin('zona as c','a.id_zona','=','c.id')
                    ->where('a.id',$petugas->id_koordinator)
                    ->first();

                return view('admin.pegawai.editpetugas', compact('petugas','koordinator'))->with(["page" => "PETUGAS"]);
            }
            else
            {
                return view('errors.404');
            }
        } catch (DecryptException $ex) {
            return view('errors.404');
        }
    }

    public function editpetugasaksi(Request $request, $id){
        $validator = Validator::make($request->all(),   
    
        array(
                
                // 'id_koordinator' => 'required',
                'nik' => 'required',
                'nama' => 'required',
                'hp' => 'required',
                'username' => 'required',
                'email' => 'required'
             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/editpetugasview/petugas/'.$id)->withInput($request->input())->withErrors($validator);
        
        }else {

            $admin = Petugas::where('id',decrypt($id))->first();

              // $admin->id_koordinator = $request->id_koordinator;
              $admin->nik = $request->nik;
              $admin->nama = $request->nama;
              $admin->hp = $request->hp;
              $admin->alamat = $request->alamat;
              $admin->username = $request->username;
              $admin->email = $request->email;

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

              return redirect('/devadmin/datapetugas')->with('success','Data Petugas Berhasil Di Edit');
        }
    }

    public function editlokasitugasview(Request $request,$id){
        try{
            $petugas = Petugas::where('id',decrypt($id))->first();
            

            if($petugas)
            {
                return view('admin.pegawai.editlokasi_tugas', compact('petugas'))->with(["page" => "PETUGAS"]);
            }
            else
            {
                return view('errors.404');
            }
        } catch (DecryptException $ex) {
            return view('errors.404');
        }
    }

    public function editlokasitugas(Request $request,$id){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'id_koordinator' => 'required',
                'district_id' => 'required',
                'villages_id' => 'required'             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/editlokasitugasview/'.$id)->withInput($request->input())->withErrors($validator);
        
        }else {

            $cek = LokasiTugas::where('id_petugas',decrypt($id))->first();
            if(!empty($cek)){
                $hpus = LokasiTugas::where('id_petugas',decrypt($id))->delete();

                $villages_id = $request->input('villages_id');
                foreach($villages_id as $tag){
                  $comics = new LokasiTugas();
                  $comics->id_petugas = decrypt($id);
                  $comics->id_koordinator = $request->id_koordinator;
                  $comics->district_id = $request->district_id;
                  $comics->villages_id = $tag;
                  $comics->save();
               }

                $villages_id2 = $request->input('villages_id2');
                 if($villages_id2 != ''){
                    foreach($villages_id2 as $tagg){
                      $comicsgo = new LokasiTugas();
                      $comicsgo->id_petugas = decrypt($id);
                      $comicsgo->id_koordinator = $request->id_koordinator;
                      $comicsgo->district_id = $request->district_id2;
                      $comicsgo->villages_id = $tagg;
                      $comicsgo->save();
                   }
                 }

                 $villages_id3 = $request->input('villages_id3');
                   if($villages_id3 != ''){
                      foreach($villages_id3 as $taggg){
                        $comicsgonew = new LokasiTugas();
                        $comicsgonew->id_petugas = decrypt($id);
                        $comicsgonew->id_koordinator = $request->id_koordinator;
                        $comicsgonew->district_id = $request->district_id3;
                        $comicsgonew->villages_id = $taggg;
                        $comicsgonew->save();
                     }
                   }

            }else{
                $villages_id = $request->input('villages_id');
                foreach($villages_id as $tag){
                  $comics = new LokasiTugas();
                  $comics->id_petugas = decrypt($id);
                  $comics->id_koordinator = $request->id_koordinator;
                  $comics->district_id = $request->district_id;
                  $comics->villages_id = $tag;
                  $comics->save();
               }

               $villages_id2 = $request->input('villages_id2');
                 if($villages_id2 != ''){
                    foreach($villages_id2 as $tagg){
                      $comicsgo = new LokasiTugas();
                      $comicsgo->id_petugas = decrypt($id);
                      $comicsgo->id_koordinator = $request->id_koordinator;
                      $comicsgo->district_id = $request->district_id2;
                      $comicsgo->villages_id = $tagg;
                      $comicsgo->save();
                   }
                 }

                 $villages_id3 = $request->input('villages_id3');
                   if($villages_id3 != ''){
                      foreach($villages_id3 as $taggg){
                        $comicsgonew = new LokasiTugas();
                        $comicsgonew->id_petugas = decrypt($id);
                        $comicsgonew->id_koordinator = $request->id_koordinator;
                        $comicsgonew->district_id = $request->district_id3;
                        $comicsgonew->villages_id = $taggg;
                        $comicsgonew->save();
                     }
                   }
            }

          return redirect('/devadmin/datapetugas')->with('success','Data Petugas Berhasil Di Edit');
                
            
        }
       
    }

    public function detailpetugas(Request $request,$id)
    {
        try{
            $detail = DB::table('petugas as a')
                ->select('a.id', 'a.id_koordinator','a.nik','a.nama','a.hp','a.username','a.email','a.image','a.created_at','a.updated_at','a.alamat','a.is_active','a.email_verify','b.nama as namakoordinator','c.nama as namazona','c.id as idzona')
                ->leftJoin('koordinator as b','a.id_koordinator','=','b.id')
                ->leftJoin('zona as c','b.id_zona','=','c.id')
                ->where('a.id',decrypt($id))
                ->first();

            if($detail)
            {
                $zona = DB::table('detail_zona as a')
                    ->select('a.id', 'a.id_districts','a.id_zona','d.is_active','d.nama as namazona','b.name as namakec','c.name as namagampong')
                    ->leftJoin('zona as d','a.id_zona','=','d.id')
                    ->leftJoin('districts as b','a.id_districts','=','b.id')
                    ->leftJoin('villages as c','b.id','=','c.district_id')
                    ->where('d.id',$detail->idzona)
                    // ->where('d.is_active',1)
                    ->get();

                $lokasitugas = DB::table('lokasi_tugas as a')
                    ->select('a.*','b.name as namakec','c.name as namagampong')
                    ->leftJoin('districts as b','a.district_id','=','b.id')
                    ->leftJoin('villages as c','a.villages_id','=','c.id')
                    ->where('a.id_petugas',$detail->id)
                    ->get();
                
                
                return view('admin.pegawai.detailpetugas', compact('detail','zona','lokasitugas'))->with(["page" => "Petugas"]);
            }
            else
            {
                return view('error.404');
            }
        } catch (DecryptException $ex) {
            return view('error.404');
        }
    }

    public function aktifpetugas(Request $request){
        try{
            $id = $request->a;
            $detail = Petugas::where('id',decrypt($id))->first();

            if($detail)
            {
                $detail->is_active = 1;
                $detail->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Petugas Atas Nama '.$detail->nama.' Berhasil Di Aktifkan';

                return response($this->response);
            }
            else
            {
                return view('error.404');
            }
        } catch (DecryptException $ex) {
            return view('error.404');
        }
    }

    public function nonaktifpetugas(Request $request){
        try{
            $id = $request->a;
            $detail = Petugas::where('id',decrypt($id))->first();

            if($detail)
            {
                $detail->is_active = 0;
                $detail->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Petugas Atas Nama '.$detail->nama.' Berhasil Di NonAktifkan';

                return response($this->response);
            }
            else
            {
                return view('error.404');
            }
        } catch (DecryptException $ex) {
            return view('error.404');
        }
    }

//==========================GAMPONG / KOMERSIL============================
public function aktifpetugas_komersil(Request $request){
    try{
        $id = $request->a;
        $detail = Petugas::where('id',decrypt($id))->first();

        if($detail)
        {
            $detail->gampong = 1;
            $detail->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Petugas Atas Nama '.$detail->nama.' Berhasil Di Aktifkan Sebagai Petugas Komersil';

            return response($this->response);
        }
        else
        {
            return view('error.404');
        }
    } catch (DecryptException $ex) {
        return view('error.404');
    }
}

public function aktifpetugas_gampong(Request $request){
    try{
        $id = $request->a;
        $detail = Petugas::where('id',decrypt($id))->first();

        if($detail)
        {
            $detail->gampong = 0;
            $detail->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Petugas Atas Nama '.$detail->nama.' Berhasil Di Aktifkan Sebagai Petugas Gampong';

            return response($this->response);
        }
        else
        {
            return view('error.404');
        }
    } catch (DecryptException $ex) {
        return view('error.404');
    }
}



    public function petugasdelete(Request $request)
    {
        $id = $request->a;

        $data = Petugas::find($id);
        try {
            if ($data->image != "") {
                $path = $data->image;
                unlink(public_path($path));
            }
            $lokasi = LokasiTugas::where('id_petugas',$id)->delete();

            $data->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Data Petugas';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Data Petugas ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function editpasswordpetugasview($id)
    {
        $sumber = Petugas::find($id);

        return response()->json(['data' => $sumber]);
    }

    public function editpasswordpetugasaksi(Request $request)
    {
        $id = $request->idbrpw;

        $sponsor = Petugas::find($id);

        try {
            
              $hash               = $this->getHash($request->passwordpw);
              $encrypted_password = $hash['encrypted'];
              $salt               = $hash['salt'];


            $sponsor->password = $encrypted_password;
            $sponsor->salt = $salt;


            $sponsor->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Password Berhasil Di Ganti';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Password Gagal Di Ganti ' . $ex->getMessage();
        }

        return response($this->response);
    }

    //Data Koordinator --------------------------------------------------

    public function datakoordinator(Request $request){

        return view('admin.pegawai.koordinator')->with(["page" => "Koordinator"]);
    }

    public function data_koordinator(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'id_zona',
            2 => 'nik',
            3 => 'nama',
            4 => 'hp',
            5 => 'username',
            6 => 'email',
            7 => 'image',
            8 => 'created_at',
            9 => 'updated_at',
            10 => 'is_active'
        );

        $totalData = Koordinator::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('koordinator as a')
                ->select('a.id', 'a.id_zona','a.nik','a.nama','a.hp','a.username','a.email','a.image','a.created_at','a.updated_at','a.is_active','c.nama as namazona')
                ->leftJoin('zona as c','a.id_zona','=','c.id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('koordinator as a')
                ->select('a.id', 'a.id_zona','a.nik','a.nama','a.hp','a.username','a.email','a.image','a.created_at','a.updated_at','a.is_active','c.nama as namazona')
                ->leftJoin('zona as c','a.id_zona','=','c.id')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.email', 'LIKE', "%{$search}%")
                ->orWhere('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('c.nama', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('koordinator as a')
                ->select('a.id', 'a.id_zona','a.nik','a.nama','a.hp','a.username','a.email','a.image','a.created_at','a.updated_at','a.is_active','c.nama as namazona')
                ->leftJoin('zona as c','a.id_zona','=','c.id')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.email', 'LIKE', "%{$search}%")
                ->orWhere('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('c.nama', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {

                if($service->is_active != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs' a='".encrypt($service->id)."' b='$service->nik' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Aktifkan'><i class='icon-power-switch'></i> Tidak Aktif</button>";
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs' a='".encrypt($service->id)."' b='$service->nama' data-container='body' data-toggle='tooltip' data-placement='left' data-content='NonAktifkan'><i class='fa fa-check'></i> Aktif</button>";
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['nik'] = $service->nik;
                $nestedData['nama'] = $service->nama;
                $nestedData['hp'] = $service->hp;
                $nestedData['email'] = $service->email;
                $nestedData['namazona'] = $service->namazona;
                $nestedData['url'] = encrypt($service->id);
                $nestedData['is_active'] = $je;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        echo json_encode($json_data);
    }
   

    public function editkoordinatorview(Request $request,$id){
        try{
            $koordinator = Koordinator::where('id',decrypt($id))->first();
            

            if($koordinator)
            {
                $zona = Zona::get();

                return view('admin.pegawai.editkoordinator', compact('koordinator','zona'))->with(["page" => "Koordinator"]);
            }
            else
            {
                return view('error.404');
            }
        } catch (DecryptException $ex) {
            return view('error.404');
        }
    }

    public function editkoordinatoraksi(Request $request, $id){
        $validator = Validator::make($request->all(),   
    
        array(
                
                'id_zona' => 'required',
                'nik' => 'required',
                'nama' => 'required',
                'hp' => 'required',
                'username' => 'required',
                'email' => 'required'
             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/editkoordinatorview/koordinator/'.$id)->withInput($request->input())->withErrors($validator);
        
        }else {

            $admin = Koordinator::where('id',decrypt($id))->first();

              $admin->id_zona = $request->id_zona;
              $admin->nik = $request->nik;
              $admin->nama = $request->nama;
              $admin->hp = $request->hp;
              $admin->username = $request->username;
              $admin->email = $request->email;

               if (Input::file('image')) {
                    if ($admin->image != "") {
                        $path = $admin->image;
                        unlink(public_path($path));
                    }
                  $image = $request->file('image');
                  $input['imagename'] =  date('ymdhis').'.'.$image->getClientOriginalExtension();
                  $destinationPath = ('uploads/koordinator');
                  $img = Image::make($image->getRealPath());
                  $img->resize(200, 200, function ($constraint) {
                      $constraint->aspectRatio();
                  })->save(public_path($destinationPath.'/'.$input['imagename']));

                  $image->move(public_path($destinationPath, '/'.$input['imagename']));

                  $direktori = $destinationPath.'/'.$input['imagename'];
                  $admin->image = $direktori;
                }

              $admin->save();

              return redirect('/devadmin/koordinator')->with('success','Data koordinator Berhasil Di Edit');
        }
    }

    public function detailkoordinator(Request $request,$id)
    {
        try{
            $detail = DB::table('koordinator as a')
                ->select('a.*','c.nama as namazona','c.id as idzona')
                ->leftJoin('zona as c','a.id_zona','=','c.id')
                ->where('a.id',decrypt($id))
                ->first();

            if($detail)
            {
                $zona = DB::table('detail_zona as a')
                    ->select('a.id', 'a.id_districts','a.id_zona','d.is_active','d.nama as namazona','b.name as namakec','c.name as namagampong')
                    ->leftJoin('zona as d','a.id_zona','=','d.id')
                    ->leftJoin('districts as b','a.id_districts','=','b.id')
                    ->leftJoin('villages as c','b.id','=','c.district_id')
                    ->where('d.id',$detail->idzona)
                    // ->where('d.is_active',1)
                    ->get();
                
                
                return view('admin.pegawai.detailkoordinator', compact('detail','zona'))->with(["page" => "Koordinator"]);
            }
            else
            {
                return view('error.404');
            }
        } catch (DecryptException $ex) {
            return view('error.404');
        }
    }

    public function aktifkoordinator(Request $request){
        try{
            $id = $request->a;
            $detail = Koordinator::where('id',decrypt($id))->first();

            if($detail)
            {
                $detail->is_active = 1;
                $detail->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Koordinator Atas Nama '.$detail->nama.' Berhasil Di Aktifkan';

                return response($this->response);
            }
            else
            {
                return view('error.404');
            }
        } catch (DecryptException $ex) {
            return view('error.404');
        }
    }

    public function nonaktifkoordinator(Request $request){
        try{
            $id = $request->a;
            $detail = Koordinator::where('id',decrypt($id))->first();

            if($detail)
            {
                $detail->is_active = 0;
                $detail->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Koordinator Atas Nama '.$detail->nama.' Berhasil Di NonAktifkan';

                return response($this->response);
            }
            else
            {
                return view('error.404');
            }
        } catch (DecryptException $ex) {
            return view('error.404');
        }
    }

    public function koordinatordelete(Request $request)
    {
        $id = $request->a;

        $data = Koordinator::find($id);

        try {
            if ($data->image != "") {
                $path = $data->image;
                unlink(public_path($path));
            }
            $data->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Data Koordinator';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Data Koordinator ' . $ex->getMessage();
        }

        return response($this->response);
    }
    


    public function get_koordinator(Request $request)
    {

        $koordinator = DB::table('koordinator as a')
                ->select('a.id', 'a.id_zona','a.nik','a.nama','a.hp','a.username','a.email','a.image','a.created_at','a.updated_at','c.nama as namazona')
                ->leftJoin('zona as c','a.id_zona','=','c.id')
                ->get();

        $reg_data = array();
        try {
            $reg_data['status'] = 'SUCCESS';
            foreach ($koordinator as $reg)
            {
                $reg_data['data'][] = array(
                    'a' => $reg->id,
                    'b' => $reg->namazona." - ".$reg->nama,
                );
            }

            
        } catch (QueryException $ex) {
            $reg_data['status'] = 'FAILED';
            $reg_data['msg'] = 'Data Koordinator tidak ditemukan ' . $ex->getMessage();
        }

        echo json_encode($reg_data);
    }
    
    public function get_koordinator2(Request $request)
    {
        $id = $request->a;
        $koordinator = DB::table('koordinator as a')
                ->select('a.id', 'a.id_zona','a.nik','a.nama','a.hp','a.username','a.email','a.image','a.created_at','a.updated_at','c.nama as namazona')
                ->leftJoin('zona as c','a.id_zona','=','c.id')
                ->where('a.id',$id)
                ->get();

        $reg_data = array();
        try {
            $reg_data['status'] = 'SUCCESS';
            foreach ($koordinator as $reg)
            {
                $reg_data['data'][] = array(
                    'a' => $reg->id,
                    'b' => $reg->namazona." - ".$reg->nama,
                );
            }

            
        } catch (QueryException $ex) {
            $reg_data['status'] = 'FAILED';
            $reg_data['msg'] = 'Data Koordinator tidak ditemukan ' . $ex->getMessage();
        }

        echo json_encode($reg_data);
    }

    public function get_dist_koordinator(Request $request)
    {
        $id = $request->a;
        $koordinator = Koordinator::where('id',$id)->first();
        $zona = DB::table('detail_zona as a')
                    ->select('a.id_zona','b.name as nama_kecamatan','b.id as id_kecamatan')
                    ->leftJoin('districts as b','a.id_districts','=','b.id')
                    ->where('a.id_zona',$koordinator->id_zona)
                    // ->where('d.is_active',1)
                    ->get();

        // $districts = Districts::where('regency_id',$id)->orderBy('name','ASC')->get();
        $dist_data = array();
        try {
          if(!empty($id)){
            if(!empty($zona)){
                $dist_data['status'] = 'SUCCESS';
                foreach ($zona as $dist)
                {
                    $dist_data['data'][] = array(
                        'a' => $dist->id_kecamatan,
                        'b' => $dist->nama_kecamatan,
                    );
                }
              }else{
                $dist_data['status'] = 'FAILED';
                $dist_data['msg'] = 'Data tidak ditemukan ';
              }
          }else{
            $dist_data['status'] = 'FAILED';
            $dist_data['msg'] = 'Data tidak ditemukan';
          }
            
            

            
        } catch (QueryException $ex) {
            $dist_data['status'] = 'FAILED';
            $dist_data['msg'] = 'Data Pusat tidak ditemukan ' . $ex->getMessage();
        }

        echo json_encode($dist_data);
    }

    public function get_vill_koordinator(Request $request)
    {
        $id = $request->a;

        $villages = Villages::where('district_id',$id)->orderBy('name','ASC')->get();
        $dist_data = array();
        try {
          if(!empty($id)){
            if(!empty($villages)){
                $dist_data['status'] = 'SUCCESS';
                foreach ($villages as $dist)
                {
                    $dist_data['data'][] = array(
                        'a' => $dist->id,
                        'b' => $dist->name,
                    );
                }
              }else{
                $dist_data['status'] = 'FAILED';
                $dist_data['msg'] = 'Data tidak ditemukan ';
              }
          }else{
            $dist_data['status'] = 'FAILED';
            $dist_data['msg'] = 'Data tidak ditemukan';
          }
            
            

            
        } catch (QueryException $ex) {
            $dist_data['status'] = 'FAILED';
            $dist_data['msg'] = 'Data Pusat tidak ditemukan ' . $ex->getMessage();
        }

        echo json_encode($dist_data);
    }

}
