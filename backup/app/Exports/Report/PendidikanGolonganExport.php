<?php

namespace App\Exports\Report;

use App\Http\Models\Pegawai;
use App\Http\Models\Golongan;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PendidikanGolonganExport implements FromView, ShouldAutoSize
{
    public function __construct($pendidikan, $golongan)
    {
        $this->pendidikan        = $pendidikan;
        $this->golongan        = $golongan;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        try{
            $pendidikan = $this->pendidikan;
            $golongan = $this->golongan;

            $datas =  "SELECT a.pendidikan,a.jurusan,f.nama as namagol ,a.id_gol,a.LAKI,a.PEREMPUAN,(a.LAKI+a.PEREMPUAN) as total 
                        FROM (
                            SELECT id_gol,pendidikan,jurusan,
                            COUNT(CASE WHEN (jenis_kelamin)='LAKI-LAKI' THEN 1 END) AS LAKI,
                            COUNT(CASE WHEN (jenis_kelamin)='PEREMPUAN' THEN 1 END) AS PEREMPUAN
                            FROM pegawai GROUP BY jurusan,id_gol
                        ) AS a
                        LEFT JOIN golongan as f ON a.id_gol = f.id WHERE a.id_gol IS NOT NULL  ";

            if($pendidikan!='all'){
                  $datas .= 'AND a.pendidikan = "'.$pendidikan.'"';
            }
            if($golongan!='all'){
                  $datas .= ' AND a.id_gol = '.$golongan;
            }

            $datas .= ' ORDER BY a.pendidikan,a.jurusan ASC';

            $enddata = DB::select($datas);

            
            if($pendidikan == 'all')
            {
                $pendidikan_name = 'SEMUA UNIT KERJA';
            }
            else
            {
                $pendidikan_      = Pegawai::where('pendidikan', $pendidikan)->first();
                $pendidikan_name  = $pendidikan_->pendidikan;
            }

            if($golongan == 'all')
            {
                $golongan_name = 'SEMUA GOLONGAN';
            }
            else
            {
                $golongan_      = Golongan::where('id', $golongan)->first();
                $golongan_name  = $golongan_->nama;
            }

            
            $data = (object) array(
                'title'     => 'Laporan Pegawai Berdasarkan Pendidikan Dan Golongan',
                'filter'    => (object) array(
                    'pendidikan'       => $pendidikan_name,
                    'golongan'       => $golongan_name,
                ),
                'report'    => $enddata
            );
            libxml_use_internal_errors(true);
            return view('admin.pegawai.excel.pendidikan_golongan', compact('data')); 
           
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
