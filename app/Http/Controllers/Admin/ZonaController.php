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
use PDF;

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
use App\Http\Models\Zonadetail;
use App\Http\Models\Koordinator;
use App\Http\Models\Petugas;


class ZonaController extends Controller
{
    //Data zona --------------------------------------------------

    public function datazona(Request $request){
        $districts = Districts::get();
    	return view('admin.lokasi.zona',compact('districts'))->with(["page" => "Data Zona"]);
    }

    public function data_zona(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'id_districts',
            2 => 'nama',
            3 => 'is_active'
        );

        $totalData = Zona::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('zona')
                ->select('id', 'nama','is_active')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->distinct()
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('zona')
                ->select('id', 'nama','is_active')
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('nama', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->distinct()
                ->get();

            $totalFiltered = DB::table('zona')
                ->select('id', 'nama','is_active')
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('nama', 'LIKE', "%{$search}%")
                ->distinct()
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {

                if($service->is_active != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs' a='$service->nama' b='$service->nama' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Active Menu'><i class='icon-power-switch'></i> Tidak Aktif</button>";                   
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs' a='$service->nama' b='$service->nama' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Inactive Menu'><i class='fa fa-check'></i> Aktif</button>";                   
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['nama'] = $service->nama;
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

    public function tambahzonaaksi(Request $request)
    {
        if ($request->isMethod('POST')) {
            
            if($request->is_active == ""){
                $is_active = 0;
            }else{
               $is_active = $request->is_active; 
            }

            try {

                if($request->data == ''){
                    $this->response['status'] = 'fail';
                    $this->response['msg'] = 'Kecamatan Wajib Dipilih';
                }else{
                    $zonn = new Zona();
                    $zonn->nama = $request->nama;
                    $zonn->is_active = $is_active;
                    $zonn->save();

                    foreach ($request->data as $dataaa)
                      {
                          $dataa[] = array(     
                                'id_districts'=> $dataaa['districts'],     
                                'id_zona'=> $zonn->id,     
                                'updated_at'=> date("Y-m-d H:i:s"),
                              );
                      }
                      
                      Zonadetail::insert($dataa);

                      $this->response['status'] = 'success';
                    $this->response['msg'] = 'Berhasil Simpan Zona';
                }
            } catch (QueryException $ex) {
                $this->response['status'] = 'fail';
                $this->response['msg'] = $ex->getMessage();
            }

        }
        return response($this->response);
    }

    public function editzonaview(Request $request,$id)
    {
        $zona = Zona::where('id',$id)->first();
        $districtsall = Districts::get();
      
         if ($request->ajax()) {
       
          return view('admin.lokasi.zonaedit', array('zona' => $zona,'districtsall' => $districtsall))->render();
        }
    }

    public function zonadelete(Request $request)
    {
        $id = $request->a;

        $sponsor = Zona::find($id);

        try {
            $detail = DB::table('detail_zona')
                      ->where('id_zona', $sponsor->id)
                      ->delete();
            
            $sponsor->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Zona';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Zona ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function editzonaaksi(Request $request)
    {
      
       
        
        if($request->data == ''){
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Kecamatan Wajib Dipilih';
        }else{
        
            $zonn = Zona::where('id',$request->idbr)->first();
            $zonn->nama = $request->namaedit;
            $zonn->save();

            $cek = DB::table('detail_zona')
                  ->where('id_zona', $request->idbr)
                  ->first();
            if ($cek) {
                DB::table('detail_zona')
                      ->where('id_zona', $request->idbr)
                      ->delete();

                foreach ($request->data as $dataaa)
                {
                  $dataa[] = array(     
                        'id_districts'=> $dataaa['districts'],     
                        'id_zona'=> $request->idbr,     
                        'updated_at'=> date("Y-m-d H:i:s"),
                      );
                }

                Zonadetail::insert($dataa);

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Berhasil Di Ubah';

            } else {

                foreach ($request->data as $dataaa)
                {
                  $dataa[] = array(     
                        'id_districts'=> $dataaa['districts'],     
                        'id_zona'=> $request->idbr,     
                        'updated_at'=> date("Y-m-d H:i:s"),
                      );
                }

                Zonadetail::insert($dataa);

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Data Berhasil Di Ubah';
            }
        }
        return response($this->response);
    }

    public function aktifzona(Request $request)
    {
        $id = $request->a;

        try {
            $sponsor = Zona::where('nama', $id)->update(['is_active' => 1]);

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Zona Berhasil Di Aktifkan!';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal Aktifkan Zona ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function nonaktifzona(Request $request)
    {
        $id = $request->a;

        try {
            
            $sponsor = Zona::where('nama', $id)->update(['is_active' => 0]);

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Zona Berhasil Di NonAktifkan!';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal NonAktifkan SubMenu ' . $ex->getMessage();
        }

        return response($this->response);
    }


    //////////////////////////////////// KECAMATAN

    public function data_kecamatan(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'name'
        );

        $totalData = Districts::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        // $start = $request->input('start');
        // $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('districts')
                ->select('id', 'name')
                // ->offset($start)
                ->limit($limit)
                ->orderBy('name', 'ASC')
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('districts')
                ->select('id', 'name')
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                // ->offset($start)
                ->limit($limit)
                ->orderBy('name', 'ASC')
                ->get();

            $totalFiltered = DB::table('districts')
                ->select('id', 'name')
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {


                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['name'] = $service->name;

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

    public function tambahkecamatanaksi(Request $request)
    {
        if ($request->isMethod('POST')) {
            $kode = Districts::orderBy('id', 'desc')->first();
            if($kode){
                $kodebrg1 = ($kode->id)+1;
              }

            $sponsor = new Districts();
            $sponsor->id = $kodebrg1;
            $sponsor->regency_id = '71';
            $sponsor->name = $request->judultitle;

            try {
                $sponsor->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Berhasil Simpan Kecamatan';
            } catch (QueryException $ex) {
                $this->response['status'] = 'fail';
                $this->response['msg'] = $ex->getMessage();
            }

        }
        return response($this->response);
    }

    public function editkecamatanview($id)
    {
        $sumber = Districts::find($id);


        return response()->json(['data' => $sumber]);
    }

    public function kecamatandelete(Request $request)
    {
        $id = $request->a;

        $sponsor = Districts::find($id);


        try {
            $cek = Villages::where('district_id',$id);
            if($cek){
                $sub = Villages::where('district_id',$id)->delete();
            }
            
            $sponsor->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Kecamatan';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Kecamatan ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function editkecamatanaksi(Request $request)
    {
        $id = $request->idbrtitle;

        $data = Districts::where('id', $id)->first();

        if ($data) {
            $data->name = $request->juduledittitle;

            $data->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Berhasil Di Ubah';

        } else {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Data tidak ditemukan!';
        }

        return response($this->response);
    }


    //////////////////////////////////// GAMPONG

    public function lokasi()
    {
        $districts = Districts::get();
        return view('admin.lokasi.lokasi',compact('districts'))->with(["page" => "Lokasi"]);
    }

    public function data_gampong(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'district_id',
            2 => 'name'
        );

        $totalData = Villages::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('villages as a')
                ->select('a.id', 'a.district_id','a.name','b.name as districtsname')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('villages as a')
                ->select('a.id', 'a.district_id','a.name','b.name as districtsname')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.name', 'LIKE', "%{$search}%")
                ->orWhere('b.name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('villages as a')
                ->select('a.id', 'a.district_id','a.name','b.name as districtsname')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.name', 'LIKE', "%{$search}%")
                ->orWhere('b.name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {


                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['districtsname'] = $service->districtsname;
                $nestedData['name'] = $service->name;

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

    public function tambahgampongaksi(Request $request)
    {
        if ($request->isMethod('POST')) {
            $sponsor = new Villages();
            $sponsor->district_id = '0'.$request->district_id;
            $sponsor->name = $request->judul;

            try {
                $sponsor->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Berhasil Simpan Gampong';
            } catch (QueryException $ex) {
                $this->response['status'] = 'fail';
                $this->response['msg'] = $ex->getMessage();
            }

        }
        return response($this->response);
    }

    public function editgampongview($id)
    {
        $sumber = Villages::find($id);

        $gampong = Districts::where('id', $sumber->district_id)->first();
        $gampongall = Districts::get();

        $sbb = view('admin.lokasi.carikecamatan', compact('sumber', 'gampong', 'gampongall'))->render();


        return response()->json(['data' => $sumber,'sbb' => $sbb]);
    }

    public function gampongdelete(Request $request)
    {
        $id = $request->a;

        $sponsor = Villages::find($id);


        try {
            $sponsor->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Gampong';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Gampong ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function editgampongaksi(Request $request)
    {
        $id = $request->idbr;

        $data = Villages::where('id', $id)->firstOrFail();

        if ($data) {
            $data->name = $request->juduledit;
            $data->district_id = $request->district_idedit;

            $data->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Berhasil Di Ubah';

        } else {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Data tidak ditemukan!';
        }

        return response($this->response);
    }

    

}
