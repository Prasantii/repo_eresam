<?php

namespace App\Exports\Report;

use App\Http\Models\Pegawai;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KontrakExport implements FromView, ShouldAutoSize
{
   

    /**
     * @return View
     */
    public function view(): View
    {
        try{

            $datas =  DB::table('datakontrak as a')
                ->select('a.*','b.nama as namajab')
                ->leftJoin('jabatan_kontrak as b', 'a.id_jabatan', '=', 'b.id')
                ->get();


            $data = (object) array(
                'title'     => 'Laporan PPNPN(KONTRAK) ',
                'report'    => $datas
            );

            return view('admin.pegawai.excel.kontrak', compact('data'));
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
