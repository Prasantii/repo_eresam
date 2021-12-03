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
use DateTime;

use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Http\Models\Admin;
use App\Http\Models\Role;
use App\Http\Models\Aksesmenu;
use App\Http\Models\Submenu;
use App\Http\Models\TitleMenu;
use App\Http\Models\Menu;
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

class WebController extends Controller
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


    ///////////////////////////////////////////// HOME

     public function index(Request $request){

      return redirect('/devadmin/dashboard');
    }

    public function dashboard(Request $request){
          $wr = WajibRetribusi::count();
          $petugas = Petugas::count();
          $koordinator = Koordinator::count();
          
          $wrdata = WajibRetribusi::whereRaw('gampong!=0 AND is_active!=0')->count();
          $wrdata1 = WajibRetribusi::whereRaw('kota =1 AND is_active=1')->count();
          $wrbelumverif = WajibRetribusi::whereRaw('is_active=0')->count();

          $wrjumlah = $wrdata + $wrdata1;
        

        return view('admin.layout.dashboard',compact('wr','petugas','koordinator','wrdata','wrbelumverif','wrjumlah','wrdata1'))->with(["page" => "Dashboard"]);
       
    }

    public function data_kontrakdata(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'nik',
            2 => 'nama',
            3 => 'id_jabatan',
            4 => 'masa_kerja',
            5 => 'is_active',
            6 => 'masa_kerja2',
            7 => 'created_at'
        );

        $totalData = Datakontrak::where('is_active',0)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('datakontrak as a')
                ->select('a.id', 'a.nik', 'a.nama', 'a.id_jabatan', 'a.masa_kerja','a.masa_kerja2', 'a.is_active','a.created_at')
                ->where('a.is_active',0)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('datakontrak as a')
                ->select('a.id', 'a.nik', 'a.nama', 'a.id_jabatan', 'a.masa_kerja','a.masa_kerja2', 'a.is_active','a.created_at')
                ->where('a.is_active',0)
                ->orWhere('a.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('datakontrak as a')
                ->select('a.id', 'a.nik', 'a.nama', 'a.id_jabatan', 'a.masa_kerja','a.masa_kerja2', 'a.is_active','a.created_at')
                ->where('a.is_active',0)
                ->orWhere('a.nik', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {

               
                if($service->is_active != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs' a='".encrypt($service->id)."' b='$service->nik' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Lihat & Verifikasi'><i class='icon-power-switch'></i> Belum Di Verifikasi</button>";
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs' a='".encrypt($service->id)."' b='$service->nama' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Batal Verifikasi'><i class='fa fa-check'></i> Sudah Di Verifikasi</button>";
                }

                
               
                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['nik'] = $service->nik;
                $nestedData['nama'] = $service->nama;
                $nestedData['is_active'] = $je;
                $nestedData['url'] = encrypt($service->id);
                $nestedData['urledit'] = encrypt($service->id);

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

    public function datapegawaijenis(Request $request,$jenis_kelamin){
        $jenis_kelamin = $jenis_kelamin;
        return view('admin.pegawai.datapegawai_jenis_kelmain',compact('jenis_kelamin'))->with(["page" => "Pegawai"]);
    }

    public function data_pegawaijenis(Request $request,$jenis_kelamin)
    {

        $columns = array(
            0 => 'id',
            1 => 'nip_lama',
            2 => 'nip_baru',
            3 => 'nama',
            4 => 'jenis_kelamin',
            5 => 'id_jabatan',
            6 => 'id_jabatan_fungsional',
            7 => 'id_bagian',
            8 => 'id_uker'
        );

        $totalData = Pegawai::where('jenis_kelamin',$jenis_kelamin)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('pegawai as a')
                ->select('a.id', 'a.nip_lama', 'a.nip_baru', 'a.nama', 'a.jenis_kelamin','a.id_jabatan','a.id_jabatan_fungsional','a.id_bagian','a.id_uker','b.jabatan as jabatan','c.jabatan_fungsional as jabatan_fungsional','d.nama as namabagian','e.nama as namauker')
                ->leftJoin('jabatan as b', 'a.id_jabatan', '=', 'b.id')
                ->leftJoin('jabatan_fungsional as c', 'a.id_jabatan_fungsional', '=', 'c.id')
                ->leftJoin('bagian as d', 'a.id_bagian', '=', 'd.id')
                ->leftJoin('uker as e', 'a.id_uker', '=', 'e.id')
                ->where('jenis_kelamin',$jenis_kelamin)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('pegawai as a')
                ->select('a.id', 'a.nip_lama', 'a.nip_baru', 'a.nama', 'a.jenis_kelamin','a.id_jabatan','a.id_jabatan_fungsional','a.id_bagian','a.id_uker','b.jabatan as jabatan','c.jabatan_fungsional as jabatan_fungsional','d.nama as namabagian','e.nama as namauker')
                ->leftJoin('jabatan as b', 'a.id_jabatan', '=', 'b.id')
                ->leftJoin('jabatan_fungsional as c', 'a.id_jabatan_fungsional', '=', 'c.id')
                ->leftJoin('bagian as d', 'a.id_bagian', '=', 'd.id')
                ->leftJoin('uker as e', 'a.id_uker', '=', 'e.id')
                ->where('a.jenis_kelamin',$jenis_kelamin)
                ->orWhere('a.nip_baru', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('b.jabatan', 'LIKE', "%{$search}%")
                ->orWhere('c.jabatan_fungsional', 'LIKE', "%{$search}%")
                ->orWhere('d.nama', 'LIKE', "%{$search}%")
                ->orWhere('e.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.jenis_kelamin', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('pegawai as a')
                ->select('a.id', 'a.nip_lama', 'a.nip_baru', 'a.nama', 'a.jenis_kelamin','a.id_jabatan','a.id_jabatan_fungsional','a.id_bagian','a.id_uker','b.jabatan as jabatan','c.jabatan_fungsional as jabatan_fungsional','d.nama as namabagian','e.nama as namauker')
                ->leftJoin('jabatan as b', 'a.id_jabatan', '=', 'b.id')
                ->leftJoin('jabatan_fungsional as c', 'a.id_jabatan_fungsional', '=', 'c.id')
                ->leftJoin('bagian as d', 'a.id_bagian', '=', 'd.id')
                ->leftJoin('uker as e', 'a.id_uker', '=', 'e.id')
                ->where('a.jenis_kelamin',$jenis_kelamin)
                ->orWhere('a.nip_baru', 'LIKE', "%{$search}%")
                ->orWhere('a.nama', 'LIKE', "%{$search}%")
                ->orWhere('b.jabatan', 'LIKE', "%{$search}%")
                ->orWhere('c.jabatan_fungsional', 'LIKE', "%{$search}%")
                ->orWhere('d.nama', 'LIKE', "%{$search}%")
                ->orWhere('e.nama', 'LIKE', "%{$search}%")
                ->orWhere('a.jenis_kelamin', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {

                if($service->jabatan != NULL){
                    $jab = $service->jabatan;
                }else{
                    $jab = '';
                }

                if($service->jabatan_fungsional != NULL){
                    $jabf = $service->jabatan_fungsional;
                }else{
                    $jabf = '';
                }
                
                // $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['nip_lama'] = $service->nip_lama;
                $nestedData['nip_baru'] = $service->nip_baru;
                $nestedData['nama'] = $service->nama;
                $nestedData['jenis_kelamin'] = $service->jenis_kelamin;
                $nestedData['jabatan'] = $jab.$jabf;
                
                $nestedData['uker'] = $service->namauker;
                $nestedData['bagian'] = $service->namabagian;
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

    //////////////////////////// ROLE

    public function role()
    {
        return view('admin.role.role')->with(["page" => "Role Akses Menu"]);
    }

    public function data_role(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'role'
        );

        $totalData = Role::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('user_role')
                ->select('id', 'role')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('user_role')
                ->select('id', 'role')
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('role', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('user_role')
                ->select('id', 'role')
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('role', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {


                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['role'] = $service->role;

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

    public function tambahroleaksi(Request $request)
    {
        if ($request->isMethod('POST')) {
            $sponsor = new Role();
            $sponsor->role = $request->judul;

            try {
                $sponsor->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Berhasil Simpan Role';
            } catch (QueryException $ex) {
                $this->response['status'] = 'fail';
                $this->response['msg'] = $ex->getMessage();
            }

        }
        return response($this->response);
    }

    public function editroleview($id)
    {
        $sumber = Role::find($id);


        return response()->json(['data' => $sumber]);
    }

    public function roledelete(Request $request)
    {
        $id = $request->a;

        $sponsor = Role::find($id);


        try {
            $sponsor->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Role';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Role ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function editroleaksi(Request $request)
    {
        $id = $request->idbr;

        $data = Role::where('id', $id)->firstOrFail();

        if ($data) {
            $data->role = $request->juduledit;

            $data->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Berhasil Di Ubah';

        } else {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Data tidak ditemukan!';
        }

        return response($this->response);
    }

    public function editroleakses(Request $request,$id)
    {

        $menuuu = TitleMenu::orderBy('id','ASC')->get();
        $role = Role::where('id',$id)->first();
         if ($request->ajax()) {
       
          return view('admin.role.datarole', array('menuuu' => $menuuu,'role' => $role))->render();
        }

        // return response()->json(['data' => $sumber]);
    }

    public function editroleaksesaksi(Request $request)
    {
        $menu_id = $request->menuId;
        $role_id = $request->roleId;

        $akses = DB::table('user_access_menu')->where('role_id',$role_id)->where('menu_id',$menu_id)->first();

        if (empty($akses)) {
            $data = new Aksesmenu;
            $data->role_id = $role_id;
            $data->menu_id = $menu_id;

            $data->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Role Access Berhasil Di Ubah';

        } else {
            $aksess = DB::table('user_access_menu')->where('role_id',$role_id)->where('menu_id',$menu_id)->delete();
            
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Data Role Access Berhasil Di Ubah';
        }

        return response($this->response);
    }

    //////////////////////////////////// MENU

    public function menu()
    {
        $titlemenu = TitleMenu::where('id','!=','1')->get();
        return view('admin.role.menu',compact('titlemenu'))->with(["page" => "Menu Management"]);
    }

    public function data_menu(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'id_titile_menu',
            2 => 'menu',
            3 => 'icon'
        );

        $totalData = Menu::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('user_menu as a')
                ->select('a.id', 'a.menu','a.icon','b.menu as titlemenu')
                ->leftJoin('user_title_menu as b','a.id_titile_menu','=','b.id')
                ->where('a.id','!=','1')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('user_menu as a')
                ->select('a.id', 'a.menu','a.icon','b.menu as titlemenu')
                ->leftJoin('user_title_menu as b','a.id_titile_menu','=','b.id')
                ->where('a.id','!=','1')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.menu', 'LIKE', "%{$search}%")
                ->orWhere('b.menu', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('user_menu as a')
                ->select('a.id', 'a.menu','a.icon','b.menu as titlemenu')
                ->leftJoin('user_title_menu as b','a.id_titile_menu','=','b.id')
                ->where('a.id','!=','1')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->orWhere('a.menu', 'LIKE', "%{$search}%")
                ->orWhere('b.menu', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {

               
                $iconn = "<span class='icons-preview fa $service->icon'></span>";

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['titlemenu'] = $service->titlemenu;
                $nestedData['menu'] = $service->menu;
                $nestedData['icon'] = $iconn;

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

    public function tambahmenuaksi(Request $request)
    {
        if ($request->isMethod('POST')) {
            $sponsor = new Menu();
            $sponsor->id_titile_menu = $request->id_titile_menu;
            $sponsor->menu = $request->judul;
            $sponsor->icon = 'fa '.$request->icon;

            try {
                $sponsor->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Berhasil Simpan Menu';
            } catch (QueryException $ex) {
                $this->response['status'] = 'fail';
                $this->response['msg'] = $ex->getMessage();
            }

        }
        return response($this->response);
    }

    public function editmenuview($id)
    {
        $sumber = Menu::find($id);

        $menuuu = TitleMenu::where('id', $sumber->id_titile_menu)->first();
        $menuall = TitleMenu::where('id','!=','1')->get();

        $sbb = view('admin.role.carititlemenu', compact('sumber', 'menuuu', 'menuall'))->render();
        $icc = view('admin.role.cariicon', compact('sumber', 'menuuu', 'menuall', 'icon'))->render();


        return response()->json(['data' => $sumber,'sbb' => $sbb,'icc' => $icc]);
    }

    public function menudelete(Request $request)
    {
        $id = $request->a;

        $sponsor = Menu::find($id);


        try {
            // $sub = Submenu::where('menu_id',$id)->delete();
            // $sub = Aksesmenu::where('menu_id',$id)->delete();
            $sponsor->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Menu';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Menu ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function editmenuaksi(Request $request)
    {
        $id = $request->idbr;

        $data = Menu::where('id', $id)->firstOrFail();

        if ($data) {
            $data->menu = $request->juduledit;
            $data->id_titile_menu = $request->id_titile_menuedit;
            $data->icon = 'fa '.$request->iconedit;

            $data->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Berhasil Di Ubah';

        } else {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Data tidak ditemukan!';
        }

        return response($this->response);
    }

    //////////////////////////////////// TITLE MENU

    public function data_menutitle(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'menu'
        );

        $totalData = TitleMenu::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        // $start = $request->input('start');
        // $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('user_title_menu')
                ->select('id', 'menu')
                ->where('id','!=','1')
                // ->offset($start)
                ->limit($limit)
                ->orderBy('menu', 'ASC')
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('user_title_menu')
                ->select('id', 'menu')
                ->where('id','!=','1')
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('menu', 'LIKE', "%{$search}%")
                // ->offset($start)
                ->limit($limit)
                ->orderBy('menu', 'ASC')
                ->get();

            $totalFiltered = DB::table('user_title_menu')
                ->select('id', 'menu')
                ->where('id','!=','1')
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('menu', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {


                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['menu'] = $service->menu;

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

    public function tambahmenutitleaksi(Request $request)
    {
        if ($request->isMethod('POST')) {
            $sponsor = new TitleMenu();
            $sponsor->menu = $request->judultitle;

            try {
                $sponsor->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Berhasil Simpan TitleMenu';
            } catch (QueryException $ex) {
                $this->response['status'] = 'fail';
                $this->response['msg'] = $ex->getMessage();
            }

        }
        return response($this->response);
    }

    public function editmenutitleview($id)
    {
        $sumber = TitleMenu::find($id);


        return response()->json(['data' => $sumber]);
    }

    public function menutitledelete(Request $request)
    {
        $id = $request->a;

        $sponsor = TitleMenu::find($id);
        $cek =  Menu::where('id_titile_menu',$id)->first();

        try {
            $sub1 = Aksesmenu::where('menu_id',$id)->delete();
            if($sub1){
                $sub2 = Submenu::where('menu_id',$cek->id)->delete();
                if($sub2){
                   $sub3 = Menu::where('id_titile_menu',$id)->delete(); 
                }
                
            }
            
            
            $sponsor->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus TitleMenu';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus TitleMenu ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function editmenutitleaksi(Request $request)
    {
        $id = $request->idbrtitle;

        $data = TitleMenu::where('id', $id)->first();

        if ($data) {
            $data->menu = $request->juduledittitle;

            $data->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Berhasil Di Ubah';

        } else {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Data tidak ditemukan!';
        }

        return response($this->response);
    }

    //////////////////////////////////// SUB MENU

    public function submenu()
    {
        $menuuu = Menu::where('id','!=','1')->get();
        $icon = Icons::all();
        return view('admin.role.submenu',compact('menuuu','icon'))->with(["page" => "Submenu Management"]);
    }

    public function data_submenu(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'menu_id',
            2 => 'title',
            3 => 'url',
            4 => 'icon',
            5 => 'is_active'
        );

        $totalData = Submenu::where('is_active',1)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        // $start = $request->input('start');
        // $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('user_sub_menu as a')
                ->select('a.id', 'a.menu_id', 'a.title', 'a.url', 'a.icon', 'a.is_active','b.menu')
                ->leftJoin('user_menu as b', 'a.menu_id', '=', 'b.id')
                // ->offset($start)
                ->limit($limit)
                ->orderBy('b.menu', 'ASC')
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('user_sub_menu as a')
                ->select('a.id', 'a.menu_id', 'a.title', 'a.url', 'a.icon', 'a.is_active','b.menu')
                ->leftJoin('user_menu as b', 'a.menu_id', '=', 'b.id')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->where('a.title', 'LIKE', "%{$search}%")
                ->orWhere('b.menu', 'LIKE', "%{$search}%")
                // ->offset($start)
                ->limit($limit)
                ->orderBy('b.menu', 'ASC')
                ->get();

            $totalFiltered = DB::table('user_sub_menu as a')
                ->select('a.id', 'a.menu_id', 'a.title', 'a.url', 'a.icon', 'a.is_active','b.menu')
                ->leftJoin('user_menu as b', 'a.menu_id', '=', 'b.id')
                ->where('a.id', 'LIKE', "%{$search}%")
                ->where('a.title', 'LIKE', "%{$search}%")
                ->orWhere('b.menu', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {


                if($service->is_active != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs' a='$service->id' b='$service->title' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Active Menu'><i class='icon-power-switch'></i> Tidak Aktif</button>";
                    $iconn = "<span class='icons-preview fa $service->icon'></span>";
                    
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs' a='$service->id' b='$service->title' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Inactive Menu'><i class='fa fa-check'></i> Aktif</button>";
                    $iconn = "<span class='icons-preview fa $service->icon'></span>";
                    
                }

                if($service->menu_id != 1){
                    $menuuuu = $service->menu;
                    
                }else{
                    $menuuuu = 'Single Menu';
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['menu'] = $menuuuu;
                $nestedData['title'] = $service->title;
                $nestedData['icon'] = $iconn;
                $nestedData['is_active'] = $je;
                $nestedData['url'] = $service->url;

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

    public function tambahsubmenuaksi(Request $request)
    {
        if ($request->isMethod('POST')) {
            $sponsor = new Submenu();
            $sponsor->menu_id = $request->menu_id;
            $sponsor->title = $request->title;
            $sponsor->url = $request->url;
            $sponsor->icon = 'fa '.$request->icon;
            if($request->is_active == ""){
                $sponsor->is_active = 0;
            }else{
               $sponsor->is_active = $request->is_active; 
            }


            try {
                $sponsor->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Berhasil Simpan Sub Menu';
            } catch (QueryException $ex) {
                $this->response['status'] = 'fail';
                $this->response['msg'] = $ex->getMessage();
            }

        }
        return response($this->response);
    }

    public function editsubmenuview($id)
    {
        $sumber = Submenu::find($id);

        $menuuu = Menu::where('id', $sumber->menu_id)->first();
        $menuall = Menu::where('id','!=','1')->get();

        $sbb = view('admin.role.carimenu', compact('sumber', 'menuuu', 'menuall'))->render();
        $icc = view('admin.role.cariicon', compact('sumber', 'menuuu', 'menuall'))->render();


        return response()->json(['data' => $sumber,'sbb' => $sbb,'icc' => $icc]);
    }

    public function submenudelete(Request $request)
    {
        $id = $request->a;

        $sponsor = Submenu::find($id);

        try {
            
            $sponsor->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus SubMenu';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus SubMenu ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function editsubmenuaksi(Request $request)
    {
        $id = $request->idbr;

        $data = Submenu::where('id', $id)->firstOrFail();

        if ($data) {
            $data->menu_id = $request->menu_idedit;
            $data->title = $request->titleedit;
            $data->url = $request->urledit;
            $data->icon = 'fa '.$request->iconedit;

            $data->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Berhasil Di Ubah';

        } else {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Data tidak ditemukan!';
        }

        return response($this->response);
    }

    public function aktifsubmenu(Request $request)
    {
        $id = $request->a;

        $sponsor = Submenu::find($id);

        try {
            
            $sponsor->is_active = 1;
            $sponsor->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Sub Menu Berhasil Di Aktifkan!';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal Aktifkan SubMenu ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function nonaktifsubmenu(Request $request)
    {
        $id = $request->a;

        $sponsor = Submenu::find($id);

        try {
            
            $sponsor->is_active = 0;
            $sponsor->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Sub Menu Berhasil Di NonAktifkan!';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal NonAktifkan SubMenu ' . $ex->getMessage();
        }

        return response($this->response);
    }

    //////////////////////// MANAJEMENT USER

    public function manajementuser()
    {
        $roleak = Role::where('role','!=','Super Admin')->get();
        return view('admin.datauser.datauser',compact('roleak'))->with(["page" => "Data User"]);
    }

    public function data_manajementuser(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'username',
            4 => 'role_id',
            5 => 'is_active',
            6 => 'created_at'
        );

        $totalData = Admin::where('role_id','!=','3')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = DB::table('user as a')
                ->select('a.id', 'a.name', 'a.email', 'a.username', 'a.image', 'a.role_id', 'a.is_active', 'a.created_at','b.role as rolenama')
                ->leftJoin('user_role as b', 'a.role_id', '=', 'b.id')
                ->where('a.role_id','!=','3')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $services = DB::table('user as a')
                ->select('a.id', 'a.name', 'a.email', 'a.username', 'a.image', 'a.role_id', 'a.is_active', 'a.created_at','b.role as rolenama')
                ->leftJoin('user_role as b', 'a.role_id', '=', 'b.id')
                ->where('a.role_id','!=','3')
                ->where('a.name', 'LIKE', "%{$search}%")
                ->where('a.username', 'LIKE', "%{$search}%")
                ->where('a.email', 'LIKE', "%{$search}%")
                ->orWhere('b.role', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('user as a')
                ->select('a.id', 'a.name', 'a.email', 'a.username', 'a.image', 'a.role_id', 'a.is_active', 'a.created_at','b.role as rolenama')
                ->leftJoin('user_role as b', 'a.role_id', '=', 'b.id')
                ->where('a.role_id','!=','3')
                ->where('a.name', 'LIKE', "%{$search}%")
                ->where('a.username', 'LIKE', "%{$search}%")
                ->where('a.email', 'LIKE', "%{$search}%")
                ->orWhere('b.role', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($services)) {

            $no = 1;
            foreach ($services as $service) {


                if($service->is_active != 1){
                    $je = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs' a='$service->id' b='$service->name' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Active Menu'><i class='icon-power-switch'></i> Tidak Aktif</button>";
                    
                }else{
                    $je = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs' a='$service->id' b='$service->name' data-container='body' data-toggle='tooltip' data-placement='left' data-content='Inactive Menu'><i class='fa fa-check'></i> Aktif</button>";
                    
                }

                $nestedData['no'] = $no++;
                $nestedData['id'] = $service->id;
                $nestedData['name'] = $service->name;
                $nestedData['email'] = $service->email;
                $nestedData['username'] = $service->username;
                $nestedData['role_id'] = $service->rolenama;
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

    public function tambahmanajementuseraksi(Request $request)
    {
        if ($request->isMethod('POST')) {
            $sponsor = new Admin();
            $sponsor->name = $request->name;
            $sponsor->email = $request->email;
            $sponsor->username = $request->username;
            $sponsor->role_id = $request->role_id;

          $hash               = $this->getHash($request->password);
          $encrypted_password = $hash['encrypted'];
          $salt               = $hash['salt'];


            $sponsor->password = $encrypted_password;
            $sponsor->salt = $salt;

            if($request->is_active == ""){
                $sponsor->is_active = 0;
            }else{
               $sponsor->is_active = $request->is_active; 
            }

            if (Input::file('image')) {
              $image = $request->file('image');
              $input['imagename'] =  date('ymdhis').'.'.$image->getClientOriginalExtension();
              $destinationPath = ('uploads/profile');
              $img = Image::make($image->getRealPath());
              $img->resize(200, 200, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path($destinationPath.'/'.$input['imagename']));

              $image->move(public_path($destinationPath, '/'.$input['imagename']));

              $direktori = $destinationPath.'/'.$input['imagename'];
              $sponsor->image = $direktori;
            }



            try {
                $sponsor->save();

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Berhasil Simpan Data User';
            } catch (QueryException $ex) {
                $this->response['status'] = 'fail';
                $this->response['msg'] = $ex->getMessage();
            }

        }
        return response($this->response);
    }

    public function editmanajementuserview($id)
    {
        $sumber = Admin::find($id);

        $rolee = Role::where('id', $sumber->role_id)->first();
        $roleeall = Role::where('role','!=','Super Admin')->get();

        $sbb = view('admin.datauser.carirole', compact('sumber', 'rolee', 'roleeall'))->render();


        return response()->json(['data' => $sumber,'sbb' => $sbb]);
    }

    public function editmanajementuseraksi(Request $request)
    {
        $id = $request->idbr;

        $sponsor = Admin::where('id', $id)->firstOrFail();

        if ($sponsor) {
            $sponsor->name = $request->nameedit;
            $sponsor->email = $request->emailedit;
            $sponsor->username = $request->usernameedit;
            $sponsor->role_id = $request->role_idedit;
            

            if (Input::file('imageedit')) {
                if ($sponsor->image != "") {
                    $path = $sponsor->image;
                    unlink(public_path($path));
                }
              $image = $request->file('imageedit');
              $input['imagename'] =  date('ymdhis').'.'.$image->getClientOriginalExtension();
              $destinationPath = ('uploads/profile');
              $img = Image::make($image->getRealPath());
              $img->resize(200, 200, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path($destinationPath.'/'.$input['imagename']));

              $image->move(public_path($destinationPath, '/'.$input['imagename']));

              $direktori = $destinationPath.'/'.$input['imagename'];
              $sponsor->image = $direktori;
            }

            $sponsor->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data Berhasil Di Ubah';

        } else {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Data tidak ditemukan!';
        }

        return response($this->response);
    }

    public function editpassowrdmanajementuserview($id)
    {
        $sumber = Admin::find($id);

        return response()->json(['data' => $sumber]);
    }

    public function editpassowrdmanajementuseraksi(Request $request)
    {
        $id = $request->idbrpw;

        $sponsor = Admin::find($id);

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

    public function manajementuserdelete(Request $request)
    {
        $id = $request->a;

        $sponsor = Admin::find($id);

        try {
            if ($sponsor->image != "") {
                    $path = $sponsor->image;
                    unlink(public_path($path));
                }
            
            $sponsor->delete();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Berhasil Hapus Data User';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal hapus Data User ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function aktifmanajementuser(Request $request)
    {
        $id = $request->a;

        $sponsor = Admin::find($id);

        try {
            
            $sponsor->is_active = 1;
            $sponsor->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data User Berhasil Di Aktifkan!';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal Aktifkan Data User ' . $ex->getMessage();
        }

        return response($this->response);
    }

    public function nonaktifmanajementuser(Request $request)
    {
        $id = $request->a;

        $sponsor = Admin::find($id);

        try {
            
            $sponsor->is_active = 0;
            $sponsor->save();

            $this->response['status'] = 'success';
            $this->response['msg'] = 'Data User Berhasil Di NonAktifkan!';
        } catch (QueryException $ex) {
            $this->response['status'] = 'fail';
            $this->response['msg'] = 'Gagal NonAktifkan Data User ' . $ex->getMessage();
        }

        return response($this->response);
    }
}
