<?php

namespace App\Exports\Report;

use App\Http\Models\Uker;
use App\Http\Models\Bagian;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KelompokUmurJenisKelaminExport implements FromView, ShouldAutoSize
{
    

    /**
     * @return View
     */
    public function view(): View
    {
        try{
            $datas =  "SELECT 
                    concat(10*floor(age/10), '-', 10*floor(age/10) + 10) as `range`, 
                    count(*) as total ,
                    COUNT(CASE WHEN (jenis_kelamin)='LAKI-LAKI' THEN 1 END) AS LAKI,
                    COUNT(CASE WHEN (jenis_kelamin)='PEREMPUAN' THEN 1 END) AS PEREMPUAN
                    FROM (
                        SELECT 
                        a.tgl_lahir, a.jenis_kelamin,
                        TIMESTAMPDIFF(YEAR,tgl_lahir,CURDATE()) AS age
                        FROM 
                        pegawai as a 
                    ) as t WHERE tgl_lahir IS NOT NULL GROUP BY `range` ORDER BY `range` ASC";

            $enddata = DB::select($datas);

            $data = (object) array(
                'title'     => 'Laporan Pegawai Kelompok Umur Dan Jenis Kelamin',
                'report'    => $enddata
            );

            return view('admin.pegawai.excel.kelompok_umur_jenis_kelamin', compact('data'));
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
