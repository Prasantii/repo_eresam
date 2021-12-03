<?php

namespace App\Exports\Report;

use App\Http\Models\Uker;
use App\Http\Models\Bagian;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PendidikanJenisKelaminExport implements FromView, ShouldAutoSize
{
    public function __construct($pendidikan)
    {
        $this->pendidikan        = $pendidikan;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        try{
            $pendidikan = $this->pendidikan;

            $datas =  "SELECT a.pendidikan,a.jurusan,a.LAKI,a.PEREMPUAN,(a.LAKI+a.PEREMPUAN) as total FROM (
                    SELECT pendidikan,jurusan,
                    COUNT(CASE WHEN (jenis_kelamin)='LAKI-LAKI' THEN 1 END) AS LAKI,
                    COUNT(CASE WHEN (jenis_kelamin)='PEREMPUAN' THEN 1 END) AS PEREMPUAN
                    FROM pegawai GROUP BY jurusan,pendidikan
                ) AS a WHERE a.pendidikan IS NOT NULL ";

            
            if($pendidikan!='all'){
                  $datas .= ' AND a.pendidikan = "'.$pendidikan.'"';
            }

            $datas .= ' ORDER BY  a.pendidikan,a.jurusan ASC';

            $enddata = DB::select($datas);

            if($pendidikan == 'all')
            {
                $pendidikan_name = 'SEMUA PENDIDIKAN';
            }
            else
            {
                $pendidikan_      = Pegawai::where('pendidikan', $pendidikan)->first();
                $pendidikan_name  = $pendidikan_->pendidikan;
            }

            $data = (object) array(
                'title'     => 'Laporan Pegawai Berdasarkan Pendidikan Dan Jenis Kelamin',
                'filter'    => (object) array(
                    'pendidikan'       => $pendidikan_name
                ),
                'report'    => $enddata
            );

            return view('admin.pegawai.excel.pendidikan_jenis_kelamin', compact('data'));
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
