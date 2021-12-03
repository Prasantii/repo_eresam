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
use App\Http\Models\UploadBukti;

use App\Http\Models\JenisRetribusi;
use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;
use App\Http\Models\Tagihan;
use App\Http\Models\UpahPungut;
use App\Http\Models\UpahPetugas;

use QrCode;
use Storage;
use Helperss;
use DateTime;
use DateInterval;
use DatePeriod;


class DataBukti extends Controller
{

    //Data DataBukti --------------------------------------------------

    public function DataBukti(Request $request){

    	return view('admin.wr.bukti')->with(["page" => "Data Bukti Pembayaran"]);
    }

    public function data_DataBukti(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'id_wr',
            2 => 'dari',
            3 => 'sampai',
            4 => 'total_bayar',
            5 => 'tgl_upload',
            6 => 'bukti',
            7 => 'status',
            8 => 'id_petugas',
            9 => 'created_at',
            10 => 'updated_at'
        );

        $totalData = UploadBukti::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('upload_bukti_trs as a')
                ->select('a.*','b.nama as namapetugas','b.hp as hppetugas','c.nama','c.nik','c.code')
                ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                ->leftJoin('wajib_retribusi as c','a.id_wr','=','c.id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('upload_bukti_trs as a')
                ->select('a.*','b.nama as namapetugas','b.hp as hppetugas','c.nama','c.nik','c.code')
                ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                ->leftJoin('wajib_retribusi as c','a.id_wr','=','c.id')
                ->where('c.code', 'LIKE', "%{$search}%")
                ->orWhere('c.nama', 'LIKE', "%{$search}%")
                ->orWhere('c.nik', 'LIKE', "%{$search}%")
                ->orWhere('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.dari', 'LIKE', "%{$search}%")
                ->orWhere('a.sampai', 'LIKE', "%{$search}%")
                ->orWhere('a.tgl_upload', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('upload_bukti_trs as a')
                ->select('a.*','b.nama as namapetugas','b.hp as hppetugas','c.nama','c.nik','c.code')
                ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                ->leftJoin('wajib_retribusi as c','a.id_wr','=','c.id')
                ->where('c.code', 'LIKE', "%{$search}%")
                ->orWhere('c.nama', 'LIKE', "%{$search}%")
                ->orWhere('c.nik', 'LIKE', "%{$search}%")
                ->orWhere('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.dari', 'LIKE', "%{$search}%")
                ->orWhere('a.sampai', 'LIKE', "%{$search}%")
                ->orWhere('a.tgl_upload', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {
                


                if($service->status == 0){
                    $statuss = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs'><i class='icon-power-switch'></i> Verifikasi Petugas</button>";
                }elseif($service->status == 1){
                     $statuss = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs'><i class='fa fa-check'></i> Pembayaran Melalui Aplikasi</button>";
                }elseif($service->status == 2){
                     $statuss = "<button class='btn btn-success btn-shadowed popover-hover btn-xs'><i class='fa fa-check'></i> Pembayaran Manual Ke Petugas</button>";
                }elseif($service->status == 3){
                     $statuss = "<button class='btn btn-danger btn-shadowed popover-hover btn-xs'><i class='fa fa-close'></i> Pembayaran Ditolak Petugas</button>";
                }

                $url = url('/'.$service->bukti);
                if($service->bukti == ''){
                    $bb = "";
                }else{
                    $bb = '<div class="parent-container"> <a href="'.$url.'"  title="'.$service->nama.'" data-source="'.$url.'" target="_blank">
                <img class="thumbnail" src="'.$url.'" style="width: 50px;height: 50px;"></a></div>';
                }

                
                

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['nama'] = $service->nama;
                $nestedData['code'] = $service->code;
                $nestedData['dari'] = date('F/Y',strtotime($service->dari)).'-'.date('F/Y',strtotime($service->sampai));
                $nestedData['total_bayar'] = 'Rp '.number_format($service->total_bayar);
                $nestedData['tgl_upload'] = date('M/d/Y H:i',strtotime($service->tgl_upload));
                $nestedData['bukti'] = $bb;
                $nestedData['status'] = $statuss;
                $nestedData['petugas'] = $service->namapetugas;
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

    //UPAH --------------------------------------------------

    public function UpahPungut(Request $request){

        return view('admin.pegawai.upah_pungut')->with(["page" => "Upah Pungut Petugas"]);
    }

    public function data_UpahPungut(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'id_petugas',
            2 => 'total_pungut',
            3 => 'created_at',
            4 => 'updated_at'
        );

        $totalData = DB::table('upah_petugas')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('upah_petugas as a')
                ->select('a.*','b.nama as namapetugas','b.hp as hppetugas', DB::raw('SUM(c.total_bayar) as total_bayar'))
                ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                ->leftJoin('upload_bukti_trs as c','a.id','=','c.id_upah')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->groupBy('a.id')
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('upah_petugas as a')
                ->select('a.*','b.nama as namapetugas','b.hp as hppetugas', DB::raw('SUM(c.total_bayar) as total_bayar'))
                ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                ->leftJoin('upload_bukti_trs as c','a.id','=','c.id_upah')
                ->where('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('b.hp', 'LIKE', "%{$search}%")
                ->orWhere('c.total_bayar', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->groupBy('a.id')
                ->get();

            $totalFiltered = DB::table('upah_petugas as a')
                ->select('a.*','b.nama as namapetugas','b.hp as hppetugas', DB::raw('SUM(c.total_bayar) as total_bayar'))
                ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                ->leftJoin('upload_bukti_trs as c','a.id','=','c.id_upah')
                ->where('b.nama', 'LIKE', "%{$search}%")
                ->orWhere('b.hp', 'LIKE', "%{$search}%")
                ->orWhere('c.total_bayar', 'LIKE', "%{$search}%")
                ->distinct('a.id')
                ->count('a.id');
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {
                
                
               

                if($service->status != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs' a='".encrypt($service->id)."' b='$service->namapetugas' data-container='body' data-toggle='tooltip' data-placement='left' data-content='SETOR'><i class='icon-power-switch'></i> SETOR TUNAI </button>";
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover  btn-xs'><i class='fa fa-check'></i> SUDAH DI TERIMA</button>";
                }

                if($service->status_upah != 1){
                    $jeee = "<button class='btn btn-danger btn-shadowed popover-hover bayar btn-xs' a='".encrypt($service->id)."' b='$service->namapetugas' data-container='body' data-toggle='tooltip' data-placement='left' data-content='SETOR'><i class='icon-power-switch'></i> Bayar Upah Petugas </button>";
                }else{
                    $jeee = "<button class='btn btn-info btn-shadowed popover-hover  btn-xs'><i class='fa fa-check'></i> SUDAH DI TERIMA</button>";
                }
                
                if($service->tgl_diterima_setor != ""){
                    $strr = date('d-M-Y H:i',strtotime($service->tgl_diterima_setor));
                }else{
                    $strr = '-';
                }

                if($service->tgl_diterima_upah != ""){
                    $strru = date('d-M-Y H:i',strtotime($service->tgl_diterima_upah));
                }else{
                    $strru = '-';
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id_petugas;
                $nestedData['nama'] = $service->namapetugas;
                $nestedData['hp'] = $service->hppetugas;
                $nestedData['total_pungut'] = 'Rp '.number_format($service->total_pungut*1000).' '.$jeee;
                $nestedData['total_bayar'] = 'Rp '.number_format($service->total_bayar).' '.$je;
                $nestedData['url'] = encrypt($service->id_petugas);
                $nestedData['is_active'] = $je;
                $nestedData['status_upah'] = $jeee;
                $nestedData['tgl_diterima_setor'] = $strr;
                $nestedData['tgl_diterima_upah'] = $strru;
                $nestedData['status_upah'] = $jeee;

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


    public function aktifUpahPungut(Request $request){
        try{
            $id = $request->a;
            $detail = UpahPetugas::where('id',decrypt($id))->first();

            if($detail)
            {
                $detail->status = 1;
                $detail->tgl_diterima_setor = date("Y-m-d H:i:s");
                $detail->save();

                $petugas = Petugas::where('id',$detail->id_petugas)->first();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Setoran Atas Nama '.$petugas->nama.' Berhasil Di Terima';

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

    public function bayarUpahPungut(Request $request){
        try{
            $id = $request->a;
            $detail = UpahPetugas::where('id',decrypt($id))->first();

            if($detail)
            {
                $detail->status_upah = 1;
                $detail->tgl_diterima_upah = date("Y-m-d H:i:s");
                $detail->save();

                $petugas = Petugas::where('id',$detail->id_petugas)->first();
                
                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Upah Pungut Atas Nama '.$petugas->nama.' Berhasil Di Bayar';

                return response($this->response);
            }
            else
            {
                $this->response['status'] = 'fail';
                $this->response['msg'] = 'Data Tidak Ditemukan';

                return response($this->response);
            }
        } catch (DecryptException $ex) {
            $this->response['status'] = 'fail';
                $this->response['msg'] = 'Data Tidak Ditemukan';

                return response($this->response);
        }
    }

}
