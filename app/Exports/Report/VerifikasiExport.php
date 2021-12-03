<?php

namespace App\Exports\Report;

use App\Http\Models\Uker;
use App\Http\Models\Bagian;
use App\Http\Models\Petugas;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VerifikasiExport implements FromView, ShouldAutoSize
{
    public function __construct($id_petugas)
    {
        $this->id_petugas        = $id_petugas;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        try{

            $id_petugas        = $this->id_petugas;

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

            return view('admin.laporan.excel.dataverifikasi', compact('data'));
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
