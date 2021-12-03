<?php

namespace App\Exports\Report;

use App\Http\Models\Pegawai;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BpnBahagiaExports implements FromView, ShouldAutoSize
{
   

    /**
     * @return View
     */
    public function view(): View
    {
        try{

                
            $datas =  DB::table('bpn_bahagia as a')
                ->select('a.*','e.nip_baru','e.nama as namapegawai','e.id as idpegawai')
                ->leftJoin('pegawai as e', 'a.pegawai_id', '=', 'e.id')
                ->orderBy('a.pegawai_id','ASC')
                ->get();


                

            $data = (object) array(
                'title'     => 'Laporan BPN BAHAGIA ',
                'report'    => $datas
            );
            libxml_use_internal_errors(true);
            return view('admin.pegawai.excel.bpnbahagia', compact('data'));
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
