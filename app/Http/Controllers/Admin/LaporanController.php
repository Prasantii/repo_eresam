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
use App\Http\Models\UpahPetugas;
use App\Http\Models\LokasiTugas;

use Image;
use DateTime;
use PDF;
use Maatwebsite\Excel\Facades\Excel;


use App\Exports\Report\KeuanganExport;
use App\Exports\Report\PendidikanJenisKelaminExport;
use App\Exports\Report\VerifikasiExport;
use App\Exports\Report\sudahVerif;
use App\Exports\Report\sudahVerifExport;

use DateInterval;
use DatePeriod;


class LaporanController extends Controller
{

    
//Jenis Kelamin--------------------------------------------------
    public function LaporanKeuangan(Request $request){
    	return view('admin.laporan.keuangan')->with(["page" => "Laporan Keuangan"]);
    }

    public function LaporanKeuanganData(Request $request)
    {
    	try{
            $date1 = $request->date1;
            $date2 = $request->date2;

            if($request->date1 != 'all' && $request->date2 != 'all')
            {
                $date1 = date('Y-m-d H:i:s', strtotime($request->date1));
                $date2 = date('Y-m-d H:i:s', strtotime($request->date2));
            }

            $status        = $request->status;

            $datas = DB::table('upload_bukti_trs as a')
                ->select('a.*','b.nama as namapetugas','b.hp as hppetugas','c.nama','c.nik','c.code')
                ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                ->leftJoin('wajib_retribusi as c','a.id_wr','=','c.id')
                ->when($date1!='all', function ($query) use ($date1){
                    return $query->where('a.tgl_upload', '>=', $date1);
                })
                ->when($date2!='all', function ($query) use ($date2){
                    return $query->where('a.tgl_upload', '<=', $date2);
                })
                ->when($status=='all', function ($query) use ($status){
                    return $query->where('a.status','!=', '0')->where('a.status','!=', '3');
                })
                ->when($status!='all', function ($query) use ($status){
                    return $query->where('a.status', $status);
                })

                ->get();
            			

            if($datas)
            {
                $report_data    = '';
                $no             = 1;
                $totalSum       = 0;
                foreach ($datas as $data)
                {
                    $url = url('/'.$data->bukti);
                    if($data->bukti == ''){
                        $bb = "-";
                    }else{
                        $bb = '<div class="parent-container"> <a href="'.$url.'"  title="'.$data->nama.'" data-source="'.$url.'" target="_blank">
                    <img class="thumbnail" src="'.$url.'" style="width: 50px;height: 50px;"></a></div>';
                    }

                    if($data->status == 0){
                        $statuss = "<button class='btn btn-danger btn-shadowed popover-hover activee btn-xs'><i class='icon-power-switch'></i> Verifikasi Bukti Oleh Petugas</button>";
                    }elseif($data->status == 1){
                         $statuss = "<button class='btn btn-info btn-shadowed popover-hover shutt btn-xs'><i class='fa fa-check'></i> Pembayaran Melalui Aplikasi</button>";
                    }elseif($data->status == 2){
                         $statuss = "<button class='btn btn-success btn-shadowed popover-hover btn-xs'><i class='fa fa-check'></i> Pembayaran Manual Ke Petugas</button>";
                    }elseif($data->status == 3){
                         $statuss = "<button class='btn btn-danger btn-shadowed popover-hover btn-xs'><i class='fa fa-close'></i> Pembayaran Ditolak Petugas</button>";
                    }

                    $report_data .= "<tr>
                                        <td align='center'>" . $no++ . "</td>
                                        <td align='left'><strong>" . $data->code . "</strong></td>
                                        <td align='left'><strong>" . $data->nama . "</strong></td>
                                        <td align='center'>" . date('F/Y',strtotime($data->dari)).'-'.date('F/Y',strtotime($data->sampai)) . "</td>
                                        
                                        <td align='center'>" . date('d/M/Y H:i',strtotime($data->tgl_upload)) . "</td>
                                        <td align='left'><strong>" . $data->namapetugas . "</strong></td>
                                        <td align='center'>" . $statuss . "</td>
                                        
                                        <td align='center'>Rp." . number_format($data->total_bayar) . "</td>
                                    </tr>";

                    $totalSum += $data->total_bayar;
                }

                $report_data .= "<tr>
                                <td colspan='7' align='right'><strong>TOTAL KESELURUHAN</strong></td>
                                <td align='right''><strong>Rp." . number_format($totalSum) . "</strong></td>
                            </tr>";

                $response['status']     = 'success';
                $response['message']    = 'Data Laporan berhasil ditampilkan';
                $response['data']       = $report_data;
            }
            else
            {
                $response['status']     = 'fail';
                $response['message']    = 'Data Laporan tidak tersedia!';
            }

        } catch (QueryException $ex) {
            $response['status']     = 'fail';
            $response['message']    = 'Gagal memuat data laporan, coba lagi! ' . $ex->getMessage();
        }

        return response()->json($response);
    }


    public function LaporanKeuanganPrint(Request $request)
    {
    	try{
	            $date1 = $request->date1;
                $date2 = $request->date2;

                if($request->date1 != 'all' && $request->date2 != 'all')
                {
                    $date1 = date('Y-m-d H:i:s', strtotime($request->date1));
                    $date2 = date('Y-m-d H:i:s', strtotime($request->date2));
                }

                $status        = $request->status;

                $datas = DB::table('upload_bukti_trs as a')
                    ->select('a.*','b.nama as namapetugas','b.hp as hppetugas','c.nama','c.nik','c.code')
                    ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                    ->leftJoin('wajib_retribusi as c','a.id_wr','=','c.id')
                    ->when($date1!='all', function ($query) use ($date1){
                        return $query->where('a.tgl_upload', '>=', $date1);
                    })
                    ->when($date2!='all', function ($query) use ($date2){
                        return $query->where('a.tgl_upload', '<=', $date2);
                    })
                    ->when($status=='all', function ($query) use ($status){
                        return $query->where('a.status','!=', '0')->where('a.status','!=', '3');
                    })
                    ->when($status!='all', function ($query) use ($status){
                        return $query->where('a.status', $status);
                    })

                    ->get();
                
                if($status == 'all')
                {
                    $status_nama = 'SEMUA STATUS PEMBAYARAN';
                }
                elseif($status == '1')
                {
                    $status_nama = 'Pembayaran Melalui Aplikasi';
                }
                elseif($status == '2')
                {
                    $status_nama = 'Pembayaran Manual Ke Petugas';
                }
                elseif($status == '3')
                {
                    $status_nama = 'Pembayaran Ditolak Petugas';
                }

                $data = (object) array(
                    'title'     => 'Laporan Keuangan Bedasarkan Status Dan Tanggal',
                    'filter'    => (object) array(
                        'period'    => date('d/F/Y',strtotime($date1)) . ' s/d ' . date('d/F/Y',strtotime($date2)),
                        'status'       => $status_nama
                    ),
                    'report'    => $datas
                );

                $pdf = PDF::loadView('admin.laporan.pdf.keuangan', compact('data'))->setPaper('legal', 'landscape');
                return $pdf->stream('Laporan Keuangan Bedasarkan Status Dan Tanggal.pdf');
            }
            catch (QueryException $ex)
            {
                return abort(500);
            }
    }

    public function LaporanKeuanganExport(Request $request)
    {
    	return Excel::download(new KeuanganExport($request->date1, $request->date2, $request->status), 'Laporan Keuangan Bedasarkan Status Dan Tanggal.xlsx');
    }
    
     public function lokasi_petugas(Request $request){
        $petugas = Petugas::where('lat','<>', '')->get();
        return view('admin.pegawai.lokasi_petugas',compact('petugas'))->with(["page" => "Lokasi Petugas"]);
    }

    
    
//PROGRESS BY DATA VERIFIKASI--------------------------------------------------
    public function Laporanverifikasidata(Request $request){
        $petugas = Petugas::get();
        return view('admin.laporan.dataverifikasi',compact('petugas'))->with(["page" => "Verifikasi Data Oleh Petugas"]);
    }

    public function LaporanverifikasidataData(Request $request)
    {
        try{
            // $date1 = $request->date1;
            // $date2 = $request->date2;

            // if($request->date1 != 'all' && $request->date2 != 'all')
            // {
            //     $date1 = date('Y-m-d H:i:s', strtotime($request->date1));
            //     $date2 = date('Y-m-d H:i:s', strtotime($request->date2));
            // }

            $id_petugas        = $request->id_petugas;

            $namapet = Petugas::where('id',$id_petugas)->first();

            $datas = DB::table('lokasi_tugas as a')
                    ->select('b.id as id_kecamatan','c.id as id_gampong','b.name as nama_kecamatan','c.name as nama_gampong')
                    ->leftJoin('districts as b','a.district_id','=','b.id')
                    ->leftJoin('villages as c','a.villages_id','=','c.id')
                    ->where('a.id_petugas',$id_petugas)
                    ->get();

            
                        

            if($datas)
            {
                $report_data    = '';
                $no             = 1;
                $totalSum       = 0;
                foreach ($datas as $data)
                {

                    
                    $datawr = DB::table('wajib_retribusi as a')
                        ->select('a.*','b.name as namedistricts','c.name as namevillages')
                        ->leftJoin('districts as b','a.district_id','=','b.id')
                        ->leftJoin('villages as c','a.villages_id','=','c.id')
                        ->where('a.is_active',0)
                        ->where('a.villages_id',$data->id_gampong)
                        // ->when($date1!='all', function ($query) use ($date1){
                        //     return $query->where('a.created_at', '>=', $date1);
                        // })
                        // ->when($date2!='all', function ($query) use ($date2){
                        //     return $query->where('a.created_at', '<=', $date2);
                        // })
                        ->orderBy('a.code', 'ASC')
                        ->get(10);



                    $report_data    = '';
                    $no             = 1;
                    $totalSum       = 0;
                    foreach ($datawr as $wrrr)
                    {
                        $report_data .= "<tr>
                                            <td align='center'>" . $no++ . "</td>
                                            <td align='left'><strong>" . $wrrr->code . "</strong></td>
                                            <td align='left'><strong>" . $wrrr->nik . "</strong></td>
                                            <td align='left'><strong>" . $wrrr->nama . "</strong></td>
                                            <td align='left'><strong>" . $wrrr->alamat.'-'.$wrrr->namedistricts.'-'.$wrrr->namevillages . "</strong></td>
                                            <td align='left'><strong>" . $namapet->nama . "</strong></td>
                                        </tr>";

                        $totalSum = $no - 1;
                    }

                    $report_data .= "<tr>
                                    <td colspan='5' align='right'><strong>TOTAL KESELURUHAN</strong></td>
                                    <td align='right''><strong>" . number_format($totalSum) . " WR</strong></td>
                                </tr>";

                    $response['status']     = 'success';
                    $response['message']    = 'Data Laporan berhasil ditampilkan';
                    $response['data']       = $report_data;
                    
                }

                
            }
            else
            {
                $response['status']     = 'fail';
                $response['message']    = 'Data Laporan tidak tersedia!';
            }

        } catch (QueryException $ex) {
            $response['status']     = 'fail';
            $response['message']    = 'Gagal memuat data laporan, coba lagi! ' . $ex->getMessage();
        }

        return response()->json($response);
    }

    public function LaporanverifikasidataPrint(Request $request)
    {
        try{
                $id_petugas        = $request->id_petugas;

                $namapet = Petugas::where('id',$id_petugas)->first();

                $datas = DB::table('lokasi_tugas as a')
                        ->select('b.id as id_kecamatan','c.id as id_gampong','b.name as nama_kecamatan','c.name as nama_gampong')
                        ->leftJoin('districts as b','a.district_id','=','b.id')
                        ->leftJoin('villages as c','a.villages_id','=','c.id')
                        ->where('a.id_petugas',$id_petugas)
                        ->get();
                
                

                $data = (object) array(
                    'title'     => 'Laporan Data WR Yang Belum Diverifikasi Petugas Bedasarkan Petugas',
                    'filter'    => (object) array(
                        'status'       => $namapet->nama
                    ),
                    'report'    => $datas
                );

                $pdf = PDF::loadView('admin.laporan.pdf.dataverifikasi', compact('data'))->setPaper('legal', 'landscape');
                return $pdf->stream('Laporan Data WR Yang Belum Diverifikasi Petugas Bedasarkan Petugas.pdf');
            }
            catch (QueryException $ex)
            {
                return abort(500);
            }
    }



    public function LaporanverifikasidataExport(Request $request)
    {
        return Excel::download(new VerifikasiExport($request->id_petugas), 'Laporan Data WR Yang Belum Diverifikasi Petugas Bedasarkan Petugas.xlsx');
    }


//PROGRESS DATA SUDAH DI VERIFIKASI PETUGAS--------------------------------------------------
    public function Laporansudahverifikasidata(Request $request){
        $petugas = Petugas::get();
        return view('admin.laporan.datasudahverifikasi',compact('petugas'))->with(["page" => "Pendataan Oleh Petugas"]);
    }

    public function LaporansudahverifikasidataData(Request $request)
    {
        try{
            $date1 = $request->date1;
            $date2 = $request->date2;

            if($request->date1 != 'all' && $request->date2 != 'all')
            {
                $date1 = date('Y-m-d H:i:s', strtotime($request->date1));
                $date2 = date('Y-m-d H:i:s', strtotime($request->date2));
            }

            $id_petugas        = $request->id_petugas;

            $namapet = Petugas::where('id',$id_petugas)->first();

            if($namapet){
                $nmpt = $namapet->nama;
            }else{
                $nmpt = '';
            }

            $datas = DB::table('petugas as a')
                        ->select('a.*','b.nama as namakoordinator','c.nama as namazona','c.id as idzona')
                        ->leftJoin('koordinator as b','a.id_koordinator','=','b.id')
                        ->leftJoin('zona as c','b.id_zona','=','c.id')
                        ->where('a.is_active',1)
                        ->when($id_petugas!='all', function ($query) use ($id_petugas){
                            return $query->where('a.id_petugas', '=', $id_petugas);
                        })
                        ->orderBy('a.nama', 'ASC')
                        ->get(); 

            $report_data    = '';



            $begin = new DateTime($date1);
            $end = new DateTime($date2);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $jarak = $begin->diff($end);
            $hsil = $jarak->days+1;


            $report_data   .= '<thead>
                                <tr>
                                    <th rowspan="2" width="5%">NO</th>
                                    <th rowspan="2">NAMA PETUGAS</th>
                                    <th rowspan="2">ZONA</th>
                                    <th rowspan="2">KECAMATAN-GAMPONG</th>
                                    
                                    <th colspan="'.$hsil.'" style="text-align:center;">TANGGAL</th>
                                    <th rowspan="2" style="text-align:center;">TOTAL WR</th>
                                    
                                </tr><tr>';

            foreach ($period as $dt) {                        
                $report_data   .= '
                                        <th>' . $dt->format("d-m-Y") .'</th>
                                    ';
            }
                
            $report_data   .= '</tr></thead><tbody>';

                
            if($datas)
            {

                $no             = 1;
                $totalSum       = 0;
                foreach ($datas as $data)
                {

                    $datawr = DB::table('wajib_retribusi as a')
                            ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namapet')
                            ->leftJoin('districts as b','a.district_id','=','b.id')
                            ->leftJoin('villages as c','a.villages_id','=','c.id')
                            ->leftJoin('petugas as d','a.id_petugas','=','d.id')
                            ->where('a.is_active',1)
                            ->where('a.id_petugas',$data->id)
                            ->when($date1!='all', function ($query) use ($date1){
                                return $query->where('a.wkt_verifikasi_data', '>=', $date1);
                            })
                            ->when($date2!='all', function ($query) use ($date2){
                                return $query->where('a.wkt_verifikasi_data', '<=', $date2);
                            })
                            ->orderBy('a.code', 'ASC')
                            ->count(); 


                        

                        $report_data .= "<tr>
                                            <td align='center'>" . $no++ . "</td>
                                            <td align='left'><strong>" . $data->nama . "</strong></td>
                                            <td align='center'><strong>" . $data->namazona . "</strong></td>
                                            
                                            <td align='left'>";

                        $dpet = DB::table('lokasi_tugas as a')
                                ->select('b.id as id_kecamatan','c.id as id_gampong','b.name as nama_kecamatan','c.name as nama_gampong')
                                ->leftJoin('districts as b','a.district_id','=','b.id')
                                ->leftJoin('villages as c','a.villages_id','=','c.id')
                                ->where('a.id_petugas',$data->id)
                                ->get();

                            
                        foreach ($dpet as $pettt) {
                            if($pettt->nama_kecamatan == ''){
                                $diss = '';
                            }else{
                                $diss = $pettt->nama_kecamatan;
                            }

                            if($pettt->nama_gampong == ''){
                                $vill = '';
                            }else{
                                $vill = $pettt->nama_gampong.' /';
                            }

                           
                        

                            $report_data .= "<strong>" . $diss ."-". $vill ." </strong>";

                        }

                        foreach ($period as $dt) {
                            $tgll1 = date('Y-m-d H:i:s', strtotime($dt->format("Y-m-d 00:00:00")));
                            $tgll2 = date('Y-m-d H:i:s', strtotime($dt->format("Y-m-d 23:59:00")));
                            $datawrper = DB::table('wajib_retribusi as a')
                                    ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namapet')
                                    ->leftJoin('districts as b','a.district_id','=','b.id')
                                    ->leftJoin('villages as c','a.villages_id','=','c.id')
                                    ->leftJoin('petugas as d','a.id_petugas','=','d.id')

                                    ->where('a.wkt_verifikasi_data', '>=', $tgll1)
                                    
                                    ->where('a.wkt_verifikasi_data', '<=', $tgll2)
                                    ->where('a.id_petugas',$data->id)
                                    ->count(); 


                            $report_data .= "</td><td align='left'><strong>" . $datawrper . " </strong></td>";
                        }

                            $report_data .= "<td align='left'><strong>" . $datawr . "</strong></td>
                                        </tr>";


                        $totalSum += $datawr;

                    
                    
                }

                $hsila = $hsil+4;
                $report_data .= "<tr>
                                    <td colspan='".$hsila."' align='right'><strong>TOTAL KESELURUHAN</strong></td>
                                    <td align='right''><strong>" . number_format($totalSum) . " WR</strong></td>
                                </tr></tbody>";

                $response['status']     = 'success';
                $response['message']    = 'Data Laporan berhasil ditampilkan';
                $response['data']       = $report_data;
                
            }
            else
            {
                $response['status']     = 'fail';
                $response['message']    = 'Data Laporan tidak tersedia!';
            }

        } catch (QueryException $ex) {
            $response['status']     = 'fail';
            $response['message']    = 'Gagal memuat data laporan, coba lagi! ' . $ex->getMessage();
        }

        return response()->json($response);
    }

    public function LaporansudahverifikasidataPrint(Request $request)
    {
        try{
                $date1 = $request->date1;
                $date2 = $request->date2;

                if($request->date1 != 'all' && $request->date2 != 'all')
                {
                    $date1 = date('Y-m-d H:i:s', strtotime($request->date1));
                    $date2 = date('Y-m-d H:i:s', strtotime($request->date2));
                }

                $id_petugas        = $request->id_petugas;

                $namapet = Petugas::where('id',$id_petugas)->first();

                if($namapet){
                    $nmpt = $namapet->nama;
                }else{
                    $nmpt = '';
                }

                $datas = DB::table('petugas as a')
                            ->select('a.*','b.nama as namakoordinator','c.nama as namazona','c.id as idzona')
                            ->leftJoin('koordinator as b','a.id_koordinator','=','b.id')
                            ->leftJoin('zona as c','b.id_zona','=','c.id')
                            ->where('a.is_active',1)
                            ->where('a.id','!=', 49)
                            ->where('a.id','!=', 54)
                            ->when($id_petugas!='all', function ($query) use ($id_petugas){
                                return $query->where('a.id_petugas', '=', $id_petugas);
                            })
                            ->orderBy('a.nama', 'ASC')
                            ->get(); 


                $begin = new DateTime($date1);
                $end = new DateTime($date2);

                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($begin, $interval, $end);

                $jarak = $begin->diff($end);
                $hsil = $jarak->days+1;


                $data = (object) array(
                    'title'     => 'Laporan Pendataan WR Oleh Petugas Berdasarkan Periode',
                    'filter'    => (object) array(
                        'period'    => date('d/F/Y',strtotime($date1)) . ' s/d ' . date('d/F/Y',strtotime($date2)),
                        'status'       => $nmpt,
                        'hasiljarak'       => $hsil,
                        'tgl1'       => $date1,
                        'tgl2'       => $date2,
                    ),
                    'report'    => $datas
                );

                $pdf = PDF::loadView('admin.laporan.pdf.datasudahverifikasi', compact('data'))->setPaper('legal', 'landscape');
                return $pdf->stream('Laporan Pendataan WR Oleh Petugas Berdasarkan Periode.pdf');
            }
            catch (QueryException $ex)
            {
                return abort(500);
            }
    }

    public function LaporansudahverifikasidataExport(Request $request)
    {
        //return Excel::download(new Verifikasi2Export($request->id_petugas), 'Laporan Data WR Yang Sudah Diverifikasi Petugas Bedasarkan Periode Dan Petugas.xlsx');
        return Excel::download(new sudahVerif($request->date1, $request->date2), 'Laporan Data WR Yang Sudah Diverifikasi Petugas Bedasarkan Periode Dan Petugas.xlsx');

    }

    public function Excel()
    {
        $nama_file = 'Excel'.date('Y-m-d').'xlsx';
        return Excel::download(new sudahVerif, 'udahni.xlsx');


    }

    public function exportExcel()
    {
        return Excel::download(new sudahVerif, 'sudah verikasi.xlsx');
    }

}
