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

use QrCode;
use Storage;
use Helperss;
use DateTime;
use DateInterval;
use DatePeriod;


class TagihanWajibController extends Controller
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

    public function TagihanWr(Request $request){

    	return view('admin.wr.tagihan')->with(["page" => "Data Tagihan Wr"]);
    }

    public function data_TagihanWr(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'id_wr',
            2 => 'bulan',
            3 => 'tarif',
            4 => 'status',
            5 => 'tgl_bayar',
            6 => 'created_at',
            7 => 'updated_at'
        );

        $totalData = DB::table('detail_trs_wr')->distinct('id_wr')->count('id_wr');

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('detail_trs_wr as a')
                ->select('a.*','b.kota','b.gampong','b.nama as namawr','b.code as kodewr','b.nik','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
                ->leftJoin('jenis_retribusi as d','b.jenis_id','=','d.id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->groupBy('a.id_wr')
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('detail_trs_wr as a')
                ->select('a.*','b.kota','b.gampong','b.nama as namawr','b.code as kodewr','b.nik','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
                ->leftJoin('jenis_retribusi as d','b.jenis_id','=','d.id')
                ->where('b.code', 'LIKE', "%{$search}%")
                ->orWhere('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('b.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.bulan', 'LIKE', "%{$search}%")
                ->orWhere('d.luas', 'LIKE', "%{$search}%")
                ->orWhere('d.tarif_kota', 'LIKE', "%{$search}%")
                ->orWhere('d.tarif_gampong', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->groupBy('a.id_wr')
                ->get();

            $totalFiltered = DB::table('detail_trs_wr as a')
                ->select('a.*','b.kota','b.gampong','b.nama as namawr','b.code as kodewr','b.nik','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
                ->leftJoin('jenis_retribusi as d','b.jenis_id','=','d.id')
                ->where('b.code', 'LIKE', "%{$search}%")
                ->orWhere('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('b.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.bulan', 'LIKE', "%{$search}%")
                ->orWhere('d.luas', 'LIKE', "%{$search}%")
                ->orWhere('d.tarif_kota', 'LIKE', "%{$search}%")
                ->orWhere('d.tarif_gampong', 'LIKE', "%{$search}%")
                ->distinct('id_wr')
                ->count('id_wr');
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

                $begin = new DateTime();
                $begin->modify( 'first day of this month' );
                $getdataa = Tagihan::where('bulan',$begin->format("Y-m-d"))->where('id',$service->id)->first();

                if($getdataa->status == 0 ){
                  $statuss = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs'><i class='icon-power-switch'></i> Belum Lunas</button>";
                }else{
                  $statuss = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs'><i class='fa fa-check'></i> Lunas</button>";
                }

                if($service->status == 0){
                    $statuss = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs'><i class='icon-power-switch'></i> Belum Lunas</button>";
                }elseif($service->status == 1){
                     $statuss = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs'><i class='fa fa-check'></i> Lunas</button>";
                }elseif($service->status == 2){
                     $statuss = "<button class='btn btn-success btn-shadowed popover-hover btn-xs'><i class='fa fa-check'></i> Verifikasi Petugas</button>";
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['code'] = $service->kodewr;
                $nestedData['nik'] = $service->nik;
                $nestedData['nama'] = $service->namawr;
                $nestedData['jenis'] = $je;
                $nestedData['tarif'] = $tarf;
                $nestedData['status'] = $statuss;
                $nestedData['url'] = encrypt($service->id_wr);

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

    public function TagihanWrKeseluruhan(Request $request,$id){
      $war = WajibRetribusi::where('id',decrypt($id))->first();
      return view('admin.wr.tagihan_keseluruhan',compact('war'))->with(["page" => "Data Tagihan Wr"]);

    }

    public function TagihanWrKeseluruhanData(Request $request,$id)
    {

        $columns = array(
            0 => 'id',
            1 => 'id_wr',
            2 => 'bulan',
            3 => 'tarif',
            4 => 'status',
            5 => 'tgl_bayar',
            6 => 'created_at',
            7 => 'updated_at'
        );

        $totalData = Tagihan::where('id_wr',$id)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('detail_trs_wr as a')
                ->select('a.*','b.kota','b.gampong','b.nama as namawr','b.code as kodewr','b.nik','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
                ->leftJoin('jenis_retribusi as d','b.jenis_id','=','d.id')
                ->where('id_wr',$id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('detail_trs_wr as a')
                ->select('a.*','b.kota','b.gampong','b.nama as namawr','b.code as kodewr','b.nik','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
                ->leftJoin('jenis_retribusi as d','b.jenis_id','=','d.id')
                ->where('id_wr',$id)
                ->orWhere('a.bulan', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('detail_trs_wr as a')
                ->select('a.*','b.kota','b.gampong','b.nama as namawr','b.code as kodewr','b.nik','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
                ->leftJoin('jenis_retribusi as d','b.jenis_id','=','d.id')
                ->where('id_wr',$id)
                ->orWhere('a.bulan', 'LIKE', "%{$search}%")
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

                if($service->status == 0){
                    $statuss = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs' a='".encrypt($service->id)."' b='".date('F/Y',strtotime($service->bulan))."' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Ubah Status'><i class='icon-power-switch'></i> Belum Lunas</button>";
                }elseif($service->status == 1){
                     $statuss = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs' a='".encrypt($service->id)."' b='".date('F/Y',strtotime($service->bulan))."' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Ubah Status'><i class='fa fa-check'></i> Lunas</button>";
                }elseif($service->status == 2){
                     $statuss = "<button class='btn btn-success btn-shadowed popover-hover activee btn-xs' a='".encrypt($service->id)."' b='".date('F/Y',strtotime($service->bulan))."' data-container='body'><i class='fa fa-check'></i> Verifikasi Petugas</button>";
                }

                if($service->tgl_bayar == ''){
                  $byr = '-';
                }else{
                  $byr = $service->tgl_bayar;
                }
                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['bulan'] = date('F/Y',strtotime($service->bulan));
                $nestedData['tarif'] = $tarf;
                $nestedData['status'] = $statuss;
                $nestedData['tgl_bayar'] =  $byr;
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

    
    public function aktifTagihanWr(Request $request){
        try{
            $id = $request->a;
            $detail = Tagihan::where('id',decrypt($id))->first();

            if($detail)
            {
                $detail->status = 1;
                $detail->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Tagihan Bulan '.date('F/Y',strtotime($detail->bulan)).' Berhasil Di Ubah Status Menjadi Lunas';

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

    public function nonaktifTagihanWr(Request $request){
        try{
            $id = $request->a;
            $detail = Tagihan::where('id',decrypt($id))->first();

            if($detail)
            {
                $detail->status = 0;
                $detail->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Tagihan Bulan '.date('F/Y',strtotime($detail->bulan)).' Berhasil Di Ubah Status Menjadi Belum Lunas';

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

}
