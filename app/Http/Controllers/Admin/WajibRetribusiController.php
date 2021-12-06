<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;

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

use App\Imports\wrGampongimport;

use QrCode;
use Storage;
use Helperss;
use DateTime;
use DateInterval;
use DatePeriod;
use PDF;
use Excel;

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
            1 => 'code',
            2 => 'nik',
            3 => 'nama',
            4 => 'alamat',
            5 => 'jenis_id',
            6 => 'kota',
            7 => 'gampong',
            8 => 'is_active',
            9 => 'regency_id',
            10 => 'district_id',
            11 => 'villages_id',
            12 => 'qrcode',
            13 => 'created_at'
        );

        $totalData = WajibRetribusi::whereRaw('kota = 1 AND is_active = 1')->count();

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
                ->whereRaw('a.kota = 1 AND a.is_active = 1')
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
                
                ->whereRaw('(a.code LIKE "%'.$search.'%" OR a.nama LIKE "%'.$search.'%" OR a.nik LIKE "%'.$search.'%" OR a.alamat LIKE "%'.$search.'%" OR b.name LIKE "%'.$search.'%" OR c.name LIKE "%'.$search.'%" OR d.luas LIKE "%'.$search.'%") AND a.gampong = 0 AND a.kota = 1')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->whereRaw('(a.code LIKE "%'.$search.'%" OR a.nama LIKE "%'.$search.'%" OR a.nik LIKE "%'.$search.'%" OR a.alamat LIKE "%'.$search.'%" OR b.name LIKE "%'.$search.'%" OR c.name LIKE "%'.$search.'%" OR d.luas LIKE "%'.$search.'%") AND a.gampong = 0 AND a.kota = 1')
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {
                

                if($service->kota == 1){
                    $je = $service->namajenis.'- Luas:'.$service->luasjenis;
                    $tarf = 'Rp '.number_format($service->tarif_kota);
                }else if($service->gampong == 1){
                    $je = $service->namajenis.'- Luas:'.$service->luasjenis;
                    $tarf = 'Rp '.number_format($service->tarif_gampong);
                }else{
                    $je = '-';
                    $tarf = '-';
                }
                
                if($service->is_active != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover btn-xs' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Data Belum Diverifikasi'><i class='icon-power-switch'></i> Belum Diverifikasi</button>";
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover btn-xs' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Data Terverifikasi'><i class='fa fa-check'></i> Sudah Diverifikasi</button>";
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['code'] = $service->code;
                $nestedData['nik'] = $service->nik;
                $nestedData['nama'] = $service->nama;
                $nestedData['alamat'] = $service->alamat.'-'.$service->namedistricts.'-'.$service->namevillages;
                $nestedData['jenis'] = $service->namajenis;
                $nestedData['tarif'] = $tarf;
                $nestedData['is_active'] = $je;
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

    // public function wrPrint1(Request $request){
    //     try{
    //         $services = DB::table('wajib_retribusi as a')
    //             ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
    //             ->leftJoin('districts as b','a.district_id','=','b.id')
    //             ->leftJoin('villages as c','a.villages_id','=','c.id')
    //             ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
    //             ->get();

    //             $nestedData['no'] = $no++;
    //             $nestedData['id'] = $service->id;
    //             $nestedData['code'] = $service->code;
    //             $nestedData['nik'] = $service->nik;
    //             $nestedData['nama'] = $service->nama;
    //             $nestedData['alamat'] = $service->alamat.'-'.$service->namedistricts.'-'.$service->namevillages;
    //             $nestedData['jenis'] = $service->namajenis;
    //             $nestedData['tarif'] = $tarf;
    //             $nestedData['is_active'] = $je;
    //             $nestedData['url'] = encrypt($service->id);

    //             $data[] = $nestedData;

    //         $pdf = PDF::loadView(' ', compact('data'))->setPaper('legal', 'landscape');
    //             return $pdf->stream('Data WR.pdf');
    //     }
    //     catch (QueryException $ex)
    //         {
    //             return abort(500);
    //         }
    // }

    public function data_WajibRetribusigampong(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'code',
            2 => 'nik',
            3 => 'nama',
            4 => 'alamat',
            5 => 'jenis_id',
            6 => 'kota',
            7 => 'gampong',
            8 => 'is_active',
            9 => 'regency_id',
            10 => 'district_id',
            11 => 'villages_id',
            12 => 'qrcode',
            13 => 'created_at'
        );

        $totalData = WajibRetribusi::whereRaw('gampong=1 AND is_active=1')->count();

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
                ->whereRaw('a.gampong=1 AND a.is_active=1')
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
                ->whereRaw('(a.code LIKE "%'.$search.'%" OR a.nama LIKE "%'.$search.'%" OR a.nik LIKE "%'.$search.'%" OR a.alamat LIKE "%'.$search.'%" OR b.name LIKE "%'.$search.'%" OR c.name LIKE "%'.$search.'%" OR d.luas LIKE "%'.$search.'%") AND a.gampong = 1 AND a.kota = 0')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->whereRaw('(a.code LIKE "%'.$search.'%" OR a.nama LIKE "%'.$search.'%" OR a.nik LIKE "%'.$search.'%" OR a.alamat LIKE "%'.$search.'%" OR b.name LIKE "%'.$search.'%" OR c.name LIKE "%'.$search.'%" OR d.luas LIKE "%'.$search.'%") AND a.gampong = 1 AND a.kota = 0')
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {
                

                if($service->kota == 1){
                    $je = $service->namajenis.'- Luas:'.$service->luasjenis;
                    $tarf = 'Rp '.number_format($service->tarif_kota);
                }else if($service->gampong == 1){
                    $je = $service->namajenis.'- Luas:'.$service->luasjenis;
                    $tarf = 'Rp '.number_format($service->tarif_gampong);
                }else{
                    $je = '-';
                    $tarf = '-';
                }
                
                if($service->is_active != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover btn-xs' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Data Belum Diverifikasi'><i class='icon-power-switch'></i> Belum Diverifikasi</button>";
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover btn-xs' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Data Terverifikasi'><i class='fa fa-check'></i> Sudah Diverifikasi</button>";
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['code'] = $service->code;
                $nestedData['nik'] = $service->nik;
                $nestedData['nama'] = $service->nama;
                $nestedData['alamat'] = $service->alamat.'-'.$service->namedistricts.'-'.$service->namevillages;
                $nestedData['jenis'] = $service->namajenis;
                $nestedData['tarif'] = $tarf;
                $nestedData['is_active'] = $je;
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
    
    public function data_WajibRetribusinotverifikasi(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'code',
            2 => 'nik',
            3 => 'nama',
            4 => 'alamat',
            5 => 'jenis_id',
            6 => 'kota',
            7 => 'gampong',
            8 => 'is_active',
            9 => 'regency_id',
            10 => 'district_id',
            11 => 'villages_id',
            12 => 'qrcode',
            13 => 'created_at'
        );

        $totalData = WajibRetribusi::where('is_active',0)->count();

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
                ->whereRaw('a.is_active=0 AND a.email_verify=0')
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
                ->whereRaw('(a.code LIKE "%'.$search.'%" OR a.nama LIKE "%'.$search.'%" OR a.nik LIKE "%'.$search.'%" OR a.alamat LIKE "%'.$search.'%" OR b.name LIKE "%'.$search.'%" OR c.name LIKE "%'.$search.'%" OR d.luas LIKE "%'.$search.'%") AND a.gampong = 0 AND a.kota = 0')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->whereRaw('(a.code LIKE "%'.$search.'%" OR a.nama LIKE "%'.$search.'%" OR a.nik LIKE "%'.$search.'%" OR a.alamat LIKE "%'.$search.'%" OR b.name LIKE "%'.$search.'%" OR c.name LIKE "%'.$search.'%" OR d.luas LIKE "%'.$search.'%") AND a.gampong = 0 AND a.kota = 0')
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {
                

                if($service->kota == 1){
                    $je = $service->namajenis.'- Luas:'.$service->luasjenis;
                    $tarf = 'Rp '.number_format($service->tarif_kota);
                }else if($service->gampong == 1){
                    $je = $service->namajenis.'- Luas:'.$service->luasjenis;
                    $tarf = 'Rp '.number_format($service->tarif_gampong);
                }else{
                    $je = '-';
                    $tarf = '-';
                }
                
                if($service->is_active != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover btn-xs' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Data Belum Diverifikasi'><i class='icon-power-switch'></i> Belum Diverifikasi</button>";
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover btn-xs' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Data Terverifikasi'><i class='fa fa-check'></i> Sudah Diverifikasi</button>";
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['code'] = $service->code;
                $nestedData['nik'] = $service->nik;
                $nestedData['nama'] = $service->nama;
                $nestedData['alamat'] = $service->alamat.'-'.$service->namedistricts.'-'.$service->namevillages;
                $nestedData['jenis'] = $service->namajenis;
                $nestedData['tarif'] = $tarf;
                $nestedData['is_active'] = $je;
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
                // 'jenis_id' => 'required',
                // 'nik' => 'required',
                'nama' => 'required',
                'alamat' => 'required',
                'username' => 'required',
                // 'email' => 'required',
                'password' => 'required',
                // 'image' => 'required',
                // 'image2' => 'required',
                // 'image3' => 'required',
             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/tambahwajib_retribusi')->withInput($request->input())->withErrors($validator);
        
        }else {
            
            $warruseername = WajibRetribusi::where('username',$request->username)->first();

            if($request->kota == ''){
                return redirect('/devadmin/tambahwajib_retribusi')->withInput($request->input())->with('fail','Silahkan Pilih Kota Atau Gampong');
            }else{
                if($request->password2 != $request->password){
                    return redirect('/devadmin/tambahwajib_retribusi')->with('fail','Konfirmasi Password Tidak Sama!')->withInput($request->input());
                }else{
                   if($warruseername){
                      return redirect('/devadmin/tambahwajib_retribusi')->with('fail','Username Sudah Digunakan')->withInput($request->input());
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
                      $admin->is_active = 0;
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
                          $img->resize(500, 500, function ($constraint) {
                              $constraint->aspectRatio();
                          })->save(public_path($destinationPath.'/'.$input['imagename']));

                          $image->move(public_path($destinationPath, '/'.$input['imagename']));

                          $direktori = $destinationPath.'/'.$input['imagename'];
                          $admin->photo = $direktori;
                        }

                        if (Input::file('ktp')) {
                            $image = $request->file('ktp');
                            $input['imagename'] =  'ktp'.date('ymdhis').'.'.$image->getClientOriginalExtension();
                            $destinationPath = ('uploads/wr/ktp');
                            $img = Image::make($image->getRealPath());
                            $img->save(public_path($destinationPath.'/'.$input['imagename']));

                            $image->move(public_path($destinationPath, '/'.$input['imagename']));

                            $direktori = $destinationPath.'/'.$input['imagename'];
                            $admin->ktp = $direktori;
                          }

                        $admin->save();

                        $imagee = new DetailImage;
                        $imagee->id_wr = $admin->id;
                      if (Input::file('image')) {
                          $image = $request->file('image');
                          $input['imagename'] =  'image'.date('ymdhis').'.'.$image->getClientOriginalExtension();
                          $destinationPath = ('uploads/wrdetail');
                          $img = Image::make($image->getRealPath());
                          $img->save(public_path($destinationPath.'/'.$input['imagename']));

                          $image->move(public_path($destinationPath, '/'.$input['imagename']));

                          $direktori = $destinationPath.'/'.$input['imagename'];
                          $imagee->image = $direktori;
                        }

                        if (Input::file('image2')) {
                          $image = $request->file('image2');
                          $input['imagename'] =  'image2'.date('ymdhis').'.'.$image->getClientOriginalExtension();
                          $destinationPath = ('uploads/wrdetail');
                          $img = Image::make($image->getRealPath());
                          $img->save(public_path($destinationPath.'/'.$input['imagename']));

                          $image->move(public_path($destinationPath, '/'.$input['imagename']));

                          $direktori = $destinationPath.'/'.$input['imagename'];
                          $imagee->imagedua = $direktori;
                        }

                        if (Input::file('image3')) {
                          $image = $request->file('image3');
                          $input['imagename'] =  'image3'.date('ymdhis').'.'.$image->getClientOriginalExtension();
                          $destinationPath = ('uploads/wrdetail');
                          $img = Image::make($image->getRealPath());
                          $img->save(public_path($destinationPath.'/'.$input['imagename']));

                          $image->move(public_path($destinationPath, '/'.$input['imagename']));

                          $direktori = $destinationPath.'/'.$input['imagename'];
                          $imagee->imagetiga = $direktori;
                        }

                        $imagee->save();


                        if($request->jenis_id != ''){
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
                        }

                      return redirect('/devadmin/wajib_retribusi')->with('success','Data Berhasil Di tambahkan');
                  }
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
                    $tarf = 'Rp '.number_format($detail->tarif_kota);
                }else if($detail->gampong == 1){
                    $je = $detail->namajenis.'- Luas:'.$detail->luasjenis;
                    $tarf = 'Rp '.number_format($detail->tarif_gampong);
                }else{
                    $je = '-';
                    $tarf = '-';
                }

                $zona = DB::table('zona as a')
                    ->select('a.*','b.id_districts','c.district_id','c.villages_id')
                    ->leftJoin('detail_zona as b','a.id','=','b.id_zona')
                    ->leftJoin('wajib_retribusi as c','b.id_districts','=','c.district_id')
                    ->where('c.villages_id',$detail->villages_id)
                    ->first();
                    
                if($zona){
                    $zonama = $zona->nama;
                    
                }else{
                   $zonama = '-'; 
                }

                $photo_rumah = DetailImage::where('id_wr',$detail->id)->first();
                
                
                return view('admin.wr.detailwajibretribusi', compact('detail','je','tarf','photo_rumah','zona','zonama'))->with(["page" => "Wajib Retribusi"]);
            }
            else
            {
                return view('error.404');
            }
        } catch (DecryptException $ex) {
            return view('error.404');
        }
    }

    public function editWajibRetribusiview(Request $request,$id){
      try{
            $wajib_retribusi = WajibRetribusi::where('id',decrypt($id))->first();
            

            if($wajib_retribusi)
            {
                $jenis = JenisRetribusi::get();
                $photo_rumah = DetailImage::where('id_wr',$wajib_retribusi->id)->first(); 

                $regencies = Regencies::where('province_id','11')->where('id',$wajib_retribusi->regency_id)->orderBy('name','ASC')->first();
                return view('admin.wr.editwajib_retribusi', compact('wajib_retribusi','jenis','photo_rumah','regencies'))->with(["page" => "Wajib Retribusi"]);
            }
            else
            {
                return view('errors.404');
            }
        } catch (DecryptException $ex) {
            return view('errors.404');
        }
    }

    public function editWajibRetribusiaksi(Request $request,$id){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'regency_id' => 'required',
                'district_id' => 'required',
                'villages_id' => 'required',
                'jenis_id' => 'required',
                'nama' => 'required',
                'alamat' => 'required',
                'username' => 'required',
             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/editwajib_retribusiview/wajib_retribusi/'.$id)->withInput($request->input())->withErrors($validator);
        
        }else {
            $warr = WajibRetribusi::where('nik',$request->nik)->where('id','!=',decrypt($id))->first();
            $warruseername = WajibRetribusi::where('username',$request->username)->where('id','!=',decrypt($id))->first();

            if($warr){
              return redirect('/devadmin/editwajib_retribusiview/wajib_retribusi/'.$id)->withInput($request->input())->with('fail','NIK SUDAH DIGUNAKAN !');
            }else{
              if($warruseername){
                return redirect('/devadmin/editwajib_retribusiview/wajib_retribusi/'.$id)->withInput($request->input())->with('fail','USERNAME SUDAH DIGUNAKAN !');
              }else{
                if($request->kota == ''){
                  return redirect('/devadmin/editwajib_retribusiview/wajib_retribusi/'.$id)->withInput($request->input())->with('fail','Silahkan Pilih Kota Atau Gampong');
                }else{
                    if($request->password2 != $request->password){
                        return redirect('/devadmin/editwajib_retribusiview/wajib_retribusi/'.$id)->with('fail','Konfirmasi Password Tidak Sama!')->withInput($request->input());
                    }else{

                      $admin = WajibRetribusi::where('id',decrypt($id))->first();

                      $admin->regency_id = $request->regency_id;
                      $admin->district_id = '0'.$request->district_id;
                      $admin->villages_id = $request->villages_id;
                      $admin->jenis_id = $request->jenis_id;
                      $admin->nik = $request->nik;
                      $admin->nama = $request->nama;
                      $admin->alamat = $request->alamat;
                      $admin->hp = $request->hp;
                      $admin->username = $request->username;
                      $admin->email = $request->email;
                      $admin->is_active = 1;
                      // $admin->email_verify = 0;
                      

                      $getjenis = JenisRetribusi::where('id',$request->jenis_id)->first();
                      if($request->kota == 'kota'){
                        $admin->kota = 1;
                        $admin->gampong = 0;

                        $updttagihan = Tagihan::where('id_wr',decrypt($id))->first();
                        $trff = $getjenis->tarif_kota;

                        DB::table('detail_trs_wr')
                            ->whereRaw('id_wr = '.decrypt($id).'')
                            ->update([ 'tarif' => $trff ]); 
                      }elseif($request->kota == 'gampong'){
                        $admin->kota = 0;
                        $admin->gampong = 1;

                        $updttagihan = Tagihan::where('id_wr',decrypt($id))->first();
                        $trff = $getjenis->tarif_gampong;

                        DB::table('detail_trs_wr')
                            ->whereRaw('id_wr = '.decrypt($id).'')
                            ->update([ 'tarif' => $trff ]); 
                      }

                      // $kode = WajibRetribusi::where('district_id',$request->district_id)->where('villages_id',$request->villages_id)->orderBy('code', 'desc')->first();
                      //     if($kode){
                      //         $kodebrg1 = substr($kode->code, 20,27)+1;
                      //         if($kodebrg1 < 10){
                      //             $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."000000".$kodebrg1;
                      //         }else if($kodebrg1 > 9 && $kodebrg1 < 99){
                      //             $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."00000".$kodebrg1;
                      //         }else if($kodebrg1 > 100){
                      //             $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."0000".$kodebrg1;
                      //         }else if($kodebrg1 > 1000){
                      //             $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."000".$kodebrg1;
                      //         }else if($kodebrg1 > 10000){
                      //             $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."00".$kodebrg1;
                      //         }else if($kodebrg1 > 100000){
                      //             $kodebrg = $request->regency_id.$request->district_id.$request->villages_id."0".$kodebrg1;
                      //         }else if($kodebrg1 > 1000000){
                      //             $kodebrg = $request->regency_id.$request->district_id.$request->villages_id.$kodebrg1;
                      //         }
                      //     }else{
                      //         $kodebrg = $request->regency_id.$request->district_id.$request->villages_id.'0000001';
                      //     }

                      //   $admin->code = $kodebrg;

                        // $url = url('/api/get_wajib_retribusi/detailcode');
                        // $destinationPathqr = 'uploads/qrcode';
                        // $imageqr = QrCode::format('png')
                        //          ->size(300)->errorCorrection('H')
                        //          ->generate($kodebrg);
                        // $output_file = $kodebrg . '.png';
                        // Storage::disk('public_uploadsqrcode')->put($output_file, $imageqr);
                        // $direktoriqr = $destinationPathqr.'/'.$output_file;
                        // $admin->qrcode = $direktoriqr;

                        // $admin->token = Helperss::generate_token();

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
                        
                        if (Input::file('ktp')) {
                            if ($admin->ktp != "") {
                                $path = $admin->ktp;
                                unlink(public_path($path));
                            }
                            $image = $request->file('ktp');
                            $input['imagename'] =  'ktp'.date('ymdhis').'.'.$image->getClientOriginalExtension();
                            $destinationPath = ('uploads/wr/ktp');
                            $img = Image::make($image->getRealPath());
                            $img->save(public_path($destinationPath.'/'.$input['imagename']));
    
                            $image->move(public_path($destinationPath, '/'.$input['imagename']));
    
                            $direktori = $destinationPath.'/'.$input['imagename'];
                            $admin->ktp = $direktori;
                          }

                        $admin->save();

                        $imagee = DetailImage::where('id_wr',decrypt($id))->first();
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
                          if ($imagee->imagedua != "") {
                              $path = $imagee->imagedua;
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
                          if ($imagee->imagetiga != "") {
                              $path = $imagee->imagetiga;
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

                      return redirect('/devadmin/wajib_retribusi')->with('success','Data Berhasil Di Edit');
                    }
                } 
              }
            }
        }
       
    }

    public function editpasswordwrview($id)
    {
        $sumber = WajibRetribusi::find($id);

        return response()->json(['data' => $sumber]);
    }

    public function editpasswordwraksi(Request $request)
    {
        $id = $request->idbrpw;

        $sponsor = WajibRetribusi::find($id);

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

    public function get_dist_edit(Request $request)
    {
        $id = $request->a;
        $iddua = '0'.$request->b;

        $districtsedit = Districts::where('regency_id',$id)->where('id',$iddua)->orderBy('name','ASC')->first();
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
                        'aa' => $districtsedit->id,
                        'bb' => $districtsedit->name,
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

    public function get_vill_edit(Request $request)
    {
        $ida = '0'.$request->aa;
        $id = '0'.$request->a;
        $iddua = $request->b;

        $villagesedit = Villages::where('district_id',$id)->where('id',$iddua)->orderBy('name','ASC')->first();
        $villages = Villages::where('district_id',$ida)->orderBy('name','ASC')->get();
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
                        'aa' => $villagesedit->id,
                        'bb' => $villagesedit->name,
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
    
    public function cetak_qrcode(Request $request){
      $wr = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->orderBy('a.nama','ASC')
                ->paginate(4);
      return view('admin.wr.cetak_qrcode',compact('wr'))->with(["page" => "Cetak Qrcode"]);
    }

    public function cetak_qrcodePrint(Request $request)
    {
        try{

                $wr = DB::table('wajib_retribusi as a')
                    ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                    ->leftJoin('districts as b','a.district_id','=','b.id')
                    ->leftJoin('villages as c','a.villages_id','=','c.id')
                    ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                    ->orderBy('a.nama','ASC')
                    // ->where('is_active',1)
                    ->where('kota',1)
                    ->take(73)
                    ->get();
                
                

                return view('admin.laporan.pdf.cetak_qrcode',compact('wr'))->with(["page" => "Cetak Qrcode"]);
            }
            catch (QueryException $ex)
            {
                return abort(500);
            }
    }

    //cetak wr
    public function cetak(Request $request){
        $wr_gampong = DB::table('wajib_retribusi as a')
        ->select('a.*','b.nama as j_retribusi','b.tarif_gampong','c.name as namaDistrict','d.name as namaVillage')
        ->leftJoin('jenis_retribusi as b','a.jenis_id','=','b.id')
        ->leftJoin('districts as c','a.district_id','=','c.id')
        ->leftJoin('villages as d','a.villages_id','=','d.id')
        ->whereRaw('a.gampong = 1 AND a.is_active = 1')
        ->orderBy('a.code')
        ->get();
        return view('admin.wr.cetakWr', compact('wr_gampong'));
    }

    public function cetak_2(Request $request){
        $wr_kota = DB::table('wajib_retribusi as a')
        ->select('a.*','b.nama as j_retribusi','b.tarif_kota','c.name as namaDistrict','d.name as namaVillage')
        ->leftJoin('jenis_retribusi as b','a.jenis_id','=','b.id')
        ->leftJoin('districts as c','a.district_id','=','c.id')
        ->leftJoin('villages as d','a.villages_id','=','d.id')
        ->whereRaw('a.kota = 1 AND a.is_active = 1')
        ->orderBy('a.code')
        ->get();

        return view('admin.wr.cetakWr2', compact('wr_kota'));
    }

    public function cetak_3(Request $request){
        $wr_belumVerif = DB::table('wajib_retribusi as a')
        ->select('a.*','b.nama as j_retribusi','b.tarif_kota','c.name as namaDistrict','d.name as namaVillage')
        ->leftJoin('jenis_retribusi as b','a.jenis_id','=','b.id')
        ->leftJoin('districts as c','a.district_id','=','c.id')
        ->leftJoin('villages as d','a.villages_id','=','d.id')
        ->whereRaw('is_active!=1')
        ->orderBy('a.code','DESC')
        ->get();
       

        return view('admin.wr.cetakWr3', compact('wr_belumVerif'));
    }

    public function importGampong1(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('select_file')->getRealPath();
        $data = Excel::load($path)->get();

        if($data->count() > 0)
        {
            foreach($data->toArray() as $key => $value) 
            {
                foreach($value as $row) 
                {
                    $insert_data[] = array(
                        'KODE'              =>$row['code'],
                        'NIK'               =>$row['nik'],
                        'NAMA'              =>$row['nama'],
                        'ALAMAT'            =>$row['alamat'],
                        'JENIS RETRIBUSI'   =>$row[jenis_retribusi],
                        'TARIF'             =>$row['tarif_gampong'],
                        'VERIFIKASI'        =>$row['is_active']
                    );
                }
            }
            if(!empty($insert_data))
        {
            DB::table('wajib_retribusi')->insert($insert_data);
        }
    }
        return back()->with('success', 'Data Berhasil di Import!');
        
    }

    public function importGampong2(Request $request)
    {
        // set waktu agar tidak dibatasi oleh laravel
        set_time_limit(0);
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
 
        // menangkap file excel
        $file = $request->file('file');
 
        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();
 
        // upload ke folder file_siswa di dalam folder public
        $file->move('import',$nama_file);
 
        // import data
        Excel::import(new wrGampongimport, public_path('/uploads/import/'.$nama_file));

        // notifikasi dengan session
        Session::flash('sukses','Data Berhasil Diimport!');
 
        // alihkan halaman kembali
        return redirect('devadmin/wajib_retribusi');
    }
    
    public function importGampong(Request $request)
    {
        //  Excel::import(new wrGampongimport, $request->file('file'));
        //  return redirect()->back();
        $path1 = $request->file('file')->store(); 
$path=storage_path('app').'/'.$path1;  
$data = \Excel::import(new wrGampongimport,$path);
    //     try {         
    //    //dd($request->all());
    //   //  $file = $request->file('file');
    //     //Excel::import(new wrGampongimport,$file);
    //     Excel::import(new wrGampongimport, $request->file('file'));
        

    //     //dd("DONE");
        
    //     } catch (NoTypeDetectedException $e) {
            
    //             // flash("Sorry you are using a wrong format to upload files.")->error();
    //             // return Redirect::back();
    //             //return abort(500);
    //     }
        
    }
}

 