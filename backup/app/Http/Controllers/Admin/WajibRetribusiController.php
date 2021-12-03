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

use App\Http\Models\JenisRetribusi;
use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;
use App\Http\Models\Tagihan;
use App\Http\Models\UploadBukti;

use QrCode;
use Storage;
use Helperss;
use DateTime;
use DateInterval;
use DatePeriod;


class WajibRetribusiController extends Controller
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

    public function WajibRetribusi(Request $request){

    	return view('admin.wr.wajib_retribusi')->with(["page" => "Wajib Retribusi"]);
    }

    public function data_WajibRetribusi(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'regency_id',
            2 => 'district_id',
            3 => 'villages_id',
            4 => 'jenis_id',
            5 => 'nik',
            6 => 'nama',
            7 => 'alamat',
            8 => 'qrcode',
            9 => 'code',
            10 => 'created_at'
        );

        $totalData = WajibRetribusi::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->where('a.code', 'LIKE', "%{$search}%")
                ->where('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.alamat', 'LIKE', "%{$search}%")
                ->orWhere('b.name', 'LIKE', "%{$search}%")
                ->orWhere('c.name', 'LIKE', "%{$search}%")
                ->orWhere('d.luas', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->where('a.code', 'LIKE', "%{$search}%")
                ->where('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.alamat', 'LIKE', "%{$search}%")
                ->orWhere('b.name', 'LIKE', "%{$search}%")
                ->orWhere('c.name', 'LIKE', "%{$search}%")
                ->orWhere('d.luas', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {
                

                if($service->kota == 1){
                    $je = $service->namajenis.'- Luas:'.$service->luasjenis;
                    $tarf = 'Rp '.number_format($service->tarif_kota);
                }

                if($service->gampong == 1){
                    $je = $service->namajenis.'- Luas:'.$service->luasjenis;
                    $tarf = 'Rp '.number_format($service->tarif_gampong);
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['code'] = $service->code;
                $nestedData['nik'] = $service->nik;
                $nestedData['nama'] = $service->nama;
                $nestedData['alamat'] = $service->alamat.'-'.$service->namedistricts.'-'.$service->namevillages;
                $nestedData['jenis'] = $je;
                $nestedData['tarif'] = $tarf;
                $nestedData['url'] = encrypt($service->id);

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

    public function tambahWajibRetribusi(Request $request){
        $jenis = JenisRetribusi::get();
        return view('admin.wr.tambahwajib_retribusi',compact('jenis'))->with(["page" => "Wajib Retribusi"]);
    }

    public function tambahWajibRetribusiaksi(Request $request){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'regency_id' => 'required',
                'district_id' => 'required',
                'villages_id' => 'required',
                'jenis_id' => 'required',
                'nik' => 'required',
                'nama' => 'required',
                'alamat' => 'required',
                'username' => 'required',
                'email' => 'required',
                'password' => 'required',
                'image' => 'required',
                'image2' => 'required',
                'image3' => 'required',
             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/tambahwajib_retribusi')->withInput($request->input())->withErrors($validator);
        
        }else {

            if($request->kota == ''){
                return redirect('/devadmin/tambahwajib_retribusi')->withInput($request->input())->with('fail','Silahkan Pilih Kota Atau Gampong');
            }else{
                if($request->password2 != $request->password){
                    return redirect('/devadmin/tambahwajib_retribusi')->with('fail','Konfirmasi Password Tidak Sama!')->withInput($request->input());
                }else{
                    $hash               = $this->getHash($request->password);
                    $encrypted_password = $hash['encrypted'];
                    $salt               = $hash['salt'];

                  $admin = new WajibRetribusi;

                  $admin->regency_id = $request->regency_id;
                  $admin->district_id = $request->district_id;
                  $admin->villages_id = $request->villages_id;
                  $admin->jenis_id = $request->jenis_id;
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

                  if($request->kota == 'kota'){
                    $admin->kota = 1;
                    $admin->gampong = 0;
                  }elseif($request->kota == 'gampong'){
                    $admin->kota = 0;
                    $admin->gampong = 1;
                  }

                  $kode = WajibRetribusi::where('district_id',$request->district_id)->where('villages_id',$request->villages_id)->orderBy('code', 'desc')->first();
                      if($kode){
                          $kodebrg1 = substr($kode->code, 20,27)+1;
                          if($kodebrg1 < 10){
                              $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."000000".$kodebrg1;
                          }else if($kodebrg1 > 9 && $kodebrg1 < 99){
                              $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."00000".$kodebrg1;
                          }else if($kodebrg1 > 100){
                              $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."0000".$kodebrg1;
                          }else if($kodebrg1 > 1000){
                              $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."000".$kodebrg1;
                          }else if($kodebrg1 > 10000){
                              $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."00".$kodebrg1;
                          }else if($kodebrg1 > 100000){
                              $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."0".$kodebrg1;
                          }else if($kodebrg1 > 1000000){
                              $kodebrg = $request->regency_id.$request->district_id.$request->villages_id.$kodebrg1;
                          }
                      }else{
                          $kodebrg = $request->regency_id.$request->district_id.$request->villages_id.'0000001';
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

                    if (Input::file('image2')) {
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

                    $begin = new DateTime();
                    $begin->modify( 'first day of this month' );
                    $end = new DateTime(); 
                    $end->modify( 'first day of +2 year' );

                    $interval = DateInterval::createFromDateString('1 month');
                    $period = new DatePeriod($begin, $interval, $end);


                    $getjenis = JenisRetribusi::where('id',$request->jenis_id)->first();
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
                    

                  return redirect('/devadmin/wajib_retribusi')->with('success','Data Berhasil Di tambahkan');
                }
            } 
        }
       
    }


    public function WajibRetribusidelete(Request $request)
    {
        $id = $request->a;

        $data = WajibRetribusi::find($id);

        try {
            if ($data->photo != "") {
                $path = $data->photo;
                unlink(public_path($path));
            }

            if ($data->qrcode != "") {
                $path = $data->qrcode;
                unlink(public_path($path));
            }

            $detail = DetailImage::where('id_wr',$data->id)->first();
            if($detail){
              if ($detail->image != "") {
                  $path = $detail->image;
                  unlink(public_path($path));
              }

              if ($detail->imagedua != "") {
                  $path = $detail->imagedua;
                  unlink(public_path($path));
              }

              if ($detail->imagetiga != "") {
                  $path = $detail->imagetiga;
                  unlink(public_path($path));
              }

              $detail->delete();
            }


            

            $tagihan = Tagihan::where('id_wr',$data->id)->delete();

            $bukti = UploadBukti::where('id_wr',$data->id)->first();
            if($bukti){
              if ($bukti->bukti != "") {
                  $path = $bukti->bukti;
                  unlink(public_path($path));
              }

              $bukti->delete();
            }
            $data->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Data';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Data ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function detailWajibRetribusi(Request $request,$id)
    {
        try{
            $detail = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->where('a.id',decrypt($id))
                ->first();

            if($detail)
            {
                if($detail->kota == 1){
                    $je = $detail->namajenis.'- Luas:'.$detail->luasjenis;
                    $tarf = number_format($detail->tarif_kota);
                }

                if($detail->gampong == 1){
                    $je = $detail->namajenis.'- Luas:'.$detail->luasjenis;
                    $tarf = number_format($detail->tarif_gampong);
                }

                $zona = DB::table('zona as a')
                    ->select('a.*','b.id_districts','c.district_id','c.villages_id')
                    ->leftJoin('detail_zona as b','a.id','=','b.id_zona')
                    ->leftJoin('wajib_retribusi as c','b.id_districts','=','c.district_id')
                    ->where('c.villages_id',$detail->villages_id)
                    ->first();

                $photo_rumah = DetailImage::where('id_wr',$detail->id)->first();
                
                
                return view('admin.wr.detailwajibretribusi', compact('detail','je','tarf','photo_rumah','zona'))->with(["page" => "Wajib Retribusi"]);
            }
            else
            {
                return view('error.404');
            }
        } catch (DecryptException $ex) {
            return view('error.404');
        }
    }


    public function get_reg(Request $request)
    {
        $id = $request->a;

        $regencies = Regencies::where('province_id',$id)->orderBy('name','ASC')->get();
        $reg_data = array();
        try {
            $reg_data['status'] = 'SUCCESS';
            foreach ($regencies as $reg)
            {
                $reg_data['data'][] = array(
                    'a' => $reg->id,
                    'b' => $reg->name,
                );
            }

            
        } catch (QueryException $ex) {
            $reg_data['status'] = 'FAILED';
            $reg_data['msg'] = 'Data provinsi tidak ditemukan ' . $ex->getMessage();
        }

        echo json_encode($reg_data);
    }

    public function get_dist(Request $request)
    {
        $id = $request->a;

        $districts = Districts::where('regency_id',$id)->orderBy('name','ASC')->get();
        $dist_data = array();
        try {
          if(!empty($id)){
            if(!empty($districts)){
                $dist_data['status'] = 'SUCCESS';
                foreach ($districts as $dist)
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

    public function get_vill(Request $request)
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
