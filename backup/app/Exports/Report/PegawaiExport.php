<?php

namespace App\Exports\Report;

use App\Http\Models\Pegawai;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PegawaiExport implements FromView, ShouldAutoSize
{
   

    /**
     * @return View
     */
    public function view(): View
    {
        try{

            $datas =  DB::table('pegawai as a')
                ->select('a.*','b.jabatan as jabatannama','c.jabatan_fungsional as jabatan_fungsionalnama','d.nama as namabagian','e.nama as namauker','f.nama as namaes','g.nama as namapang','h.nama as namagol')
                ->leftJoin('jabatan as b', 'a.id_jabatan', '=', 'b.id')
                ->leftJoin('jabatan_fungsional as c', 'a.id_jabatan_fungsional', '=', 'c.id')
                ->leftJoin('bagian as d', 'a.id_bagian', '=', 'd.id')
                ->leftJoin('uker as e', 'a.id_uker', '=', 'e.id')
                ->leftJoin('eselon as f', 'a.id_esolon', '=', 'f.id')
                ->leftJoin('pangkat as g', 'a.id_pangkat', '=', 'g.id')
                ->leftJoin('golongan as h', 'a.id_gol', '=', 'h.id')
                ->orderBy('a.id_uker','ASC')
                ->orderBy('a.id_bagian','ASC')
                ->get();

                // $golongan = Golongan::where('id',$detail->id_gol)->first();
                // $pangkat = Pangkat::where('id',$detail->id_pangkat)->first();
                // $eselon = Eselon::where('id',$detail->id_esolon)->first();


            $data = (object) array(
                'title'     => 'Laporan Pegawai ',
                'report'    => $datas
            );

            return view('admin.pegawai.excel.pegawai', compact('data'));
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
