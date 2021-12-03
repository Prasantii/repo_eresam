<?php

namespace App\Exports\Report;

use App\Http\Models\Uker;
use App\Http\Models\Bagian;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KelompokUmurExport implements FromView, ShouldAutoSize
{
    public function __construct($uker, $bagian)
    {
        $this->uker        = $uker;
        $this->bagian        = $bagian;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        try{
            $uker = $this->uker;
            $bagian = $this->bagian;

            $datas =  "SELECT 
                  concat(10*floor(age/10), '-', 10*floor(age/10) + 10) as `range`, 
                  count(*) as total ,
                  COUNT(CASE WHEN (jenis_kelamin)='LAKI-LAKI' THEN 1 END) AS LAKI,
                  COUNT(CASE WHEN (jenis_kelamin)='PEREMPUAN' THEN 1 END) AS PEREMPUAN,id_bagian,id_uker,namabagian,namauker
                FROM (
                      SELECT 
                        a.id_bagian,a.id_uker,a.tgl_lahir, a.jenis_kelamin,d.nama as namabagian,e.nama as namauker,
                        TIMESTAMPDIFF(YEAR,tgl_lahir,CURDATE()) AS age
                      FROM 
                        pegawai as a 
                        LEFT JOIN bagian as d ON a.id_bagian = d.id
                        LEFT JOIN uker as e ON a.id_uker = e.id
                    ) as t WHERE id_uker IS NOT NULL ";

            if($uker!='all'){
                  $datas .= 'AND id_uker = '.$uker;
            }
            if($bagian!='all'){
                  $datas .= ' AND id_bagian = '.$bagian;
            }

            $datas .= ' GROUP BY `range`,id_bagian ORDER BY id_uker,id_bagian';

            $enddata = DB::select($datas);

            
            if($uker == 'all')
            {
                $uker_name = 'SEMUA UNIT KERJA';
            }
            else
            {
                $uker_      = Uker::where('id', $uker)->first();
                $uker_name  = $uker_->nama;
            }

            if($bagian == 'all')
            {
                $bagian_name = 'SEMUA BAGIAN';
            }
            else
            {
                $bagian_      = Bagian::where('id', $bagian)->first();
                $bagian_name  = $bagian_->nama;
            }

            $data = (object) array(
                'title'     => 'Laporan Pegawai Berdasarkan Kelompok Umur',
                'filter'    => (object) array(
                    'uker'       => $uker_name,
                    'bagian'       => $bagian_name,
                ),
                'report'    => $enddata
            );
            libxml_use_internal_errors(true);
            return view('admin.pegawai.excel.kelompok_umur', compact('data')); 
            
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
