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



class JenisRetribusiController extends Controller
{
   
    //Data Petugas --------------------------------------------------

    public function jenis_retribusi(Request $request){

    	return view('admin.wr.jenis_retribusi')->with(["page" => "Jenis Objek Retribusi"]);
    }

    public function data_jenis_retribusi(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'nama',
            2 => 'luas',
            3 => 'tarif_kota',
            4 => 'tarif_gampong',
            8 => 'created_at'
        );

        $totalData = JenisRetribusi::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('jenis_retribusi as a')
                ->select('a.*')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('jenis_retribusi as a')
                ->select('a.*')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.luas', 'LIKE', "%{$search}%")
                ->orWhere('a.tarif_kota', 'LIKE', "%{$search}%")
                ->orWhere('a.tarif_gampong', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('jenis_retribusi as a')
                ->select('a.*')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.luas', 'LIKE', "%{$search}%")
                ->orWhere('a.tarif_kota', 'LIKE', "%{$search}%")
                ->orWhere('a.tarif_gampong', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {
           

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['nama'] = $service->nama;
                $nestedData['luas'] = $service->luas;
                $nestedData['tarif_kota'] = "Rp. ".number_format($service->tarif_kota);
                $nestedData['tarif_gampong'] = "Rp. ".number_format($service->tarif_gampong);
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

    public function tambahjenis_retribusi(Request $request){
        return view('admin.wr.tambahjenis_retribusi')->with(["page" => "Jenis Objek Retribusi"]);
    }

    public function tambahjenis_retribusiaksi(Request $request){
        
        $validator = Validator::make($request->all(),   
    
        array(
                
                'nama' => 'required',
                'luas' => 'required',
                'tarif_kota' => 'required',
                'tarif_gampong' => 'required'
             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/tambahjenis_retribusi')->withInput($request->input())->withErrors($validator);
        
        }else {

              $admin = new JenisRetribusi;

              $admin->nama = $request->nama;
              $admin->luas = $request->luas;
              $admin->tarif_kota = str_replace(',', '', $request->tarif_kota);
              $admin->tarif_gampong = str_replace(',', '', $request->tarif_gampong);

              $admin->save();

              return redirect('/devadmin/jenis_retribusi')->with('success','Data Berhasil Di tambahkan');
                
        }
       
    }

    public function editjenis_retribusiview(Request $request,$id){
        try{
            $jenis_retribusi = JenisRetribusi::where('id',decrypt($id))->first();
            

            if($jenis_retribusi)
            {
                return view('admin.pegawai.editjenis_retribusi', compact('jenis_retribusi'))->with(["page" => "Jenis Objek Retribusi"]);
            }
            else
            {
                return view('errors.404');
            }
        } catch (DecryptException $ex) {
            return view('errors.404');
        }
    }

    public function editjenis_retribusiaksi(Request $request, $id){
        $validator = Validator::make($request->all(),   
    
        array(
                
                'nama' => 'required',
                'luas' => 'required',
                'tarif_kota' => 'required',
                'tarif_gampong' => 'required'
             )
        );

        
        if($validator->fails()){

            $eror = $validator->messages()->all();

            return redirect('/devadmin/editjenis_retribusiview/jenis_retribusi/'.$id)->withInput($request->input())->withErrors($validator);
        
        }else {

            $admin = JenisRetribusi::where('id',decrypt($id))->first();

              $admin->nama = $request->nama;
              $admin->luas = $request->luas;
              $admin->tarif_kota = str_replace(',', '', $request->tarif_kota);
              $admin->tarif_gampong = str_replace(',', '', $request->tarif_gampong);

              $admin->save();

              return redirect('/devadmin/jenis_retribusi')->with('success','Data Berhasil Di Edit');
        }
    }

    public function jenis_retribusidelete(Request $request)
    {
        $id = $request->a;

        $data = JenisRetribusi::find($id);

        try {
            $data->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Data';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Data ' . $ex->getMessage();
        }

        return response($this->response);
    }

}
