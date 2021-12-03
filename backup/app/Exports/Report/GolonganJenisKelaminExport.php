<?php

namespace App\Exports\Report;

use App\Http\Models\Uker;
use App\Http\Models\Bagian;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GolonganJenisKelaminExport implements FromView, ShouldAutoSize
{
    

    /**
     * @return View
     */
    public function view(): View
    {
        try{
            $datas =  "SELECT f.nama as namagol ,a.id_gol,a.LAKI,a.PEREMPUAN,(a.LAKI+a.PEREMPUAN) as total 
                        FROM (
                            SELECT id_gol,
                            COUNT(CASE WHEN (jenis_kelamin)='LAKI-LAKI' THEN 1 END) AS LAKI,
                            COUNT(CASE WHEN (jenis_kelamin)='PEREMPUAN' THEN 1 END) AS PEREMPUAN
                            FROM pegawai GROUP BY id_gol
                        ) AS a
                        LEFT JOIN golongan as f ON a.id_gol = f.id WHERE a.id_gol IS NOT NULL ";

            $datas .= ' ORDER BY f.nama ASC';

            $enddata = DB::select($datas);

            $data = (object) array(
                'title'     => 'Laporan Pegawai Berdasarkan Golongan Dan Jenis Kelamin',
                'report'    => $enddata
            );

            return view('admin.pegawai.excel.golongan_jenis_kelamin', compact('data'));
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
