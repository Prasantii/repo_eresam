<?php

namespace App\Exports\Report;

use App\Http\Models\Uker;
use App\Http\Models\Golongan;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GolonganExport implements FromView, ShouldAutoSize
{
    public function __construct($uker, $golongan)
    {
        $this->uker        = $uker;
        $this->golongan        = $golongan;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        try{
            $uker = $this->uker;
            $golongan = $this->golongan;

            $datas =  "SELECT e.nama as namauker,d.nama as namabagian  ,a.id_uker,f.nama as namagol ,a.id_gol,a.LAKI,a.PEREMPUAN,(a.LAKI+a.PEREMPUAN) as total 
                    FROM (
                        SELECT id_uker,id_gol,id_bagian,
                        COUNT(CASE WHEN (jenis_kelamin)='LAKI-LAKI' THEN 1 END) AS LAKI,
                        COUNT(CASE WHEN (jenis_kelamin)='PEREMPUAN' THEN 1 END) AS PEREMPUAN
                        FROM pegawai GROUP BY id_bagian,id_uker,id_gol
                    ) AS a
                    LEFT JOIN uker as e ON a.id_uker = e.id
                    LEFT JOIN bagian as d ON a.id_bagian = d.id
                    LEFT JOIN golongan as f ON a.id_gol = f.id WHERE a.id_uker IS NOT NULL ";

            if($uker!='all'){
                  $datas .= 'AND a.id_uker = '.$uker;
            }
            if($golongan!='all'){
                  $datas .= ' AND a.id_gol = '.$golongan;
            }

            $datas .= ' ORDER BY a.id_uker,a.id_bagian ASC';

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

            if($golongan == 'all')
            {
                $golongan_name = 'SEMUA GOLONGAN';
            }
            else
            {
                $golongan_      = Golongan::where('id', $golongan)->first();
                $golongan_name  = $golongan_->nama;
            }

            if($golongan == 'all'){
                $data = (object) array(
                    'title'     => 'Laporan Pegawai Berdasarkan Golongan',
                    'filter'    => (object) array(
                        'uker'       => $uker_name,
                        'golongan'       => $golongan_name,
                    ),
                    'report'    => $enddata
                );
                libxml_use_internal_errors(true);
                return view('admin.pegawai.excel.golongan', compact('data')); 
            }

            if($golongan == 12 || $golongan == 11 || $golongan == 10 || $golongan == 9){
                $data = (object) array(
                    'title'     => 'Laporan Pegawai Berdasarkan Golongan',
                    'filter'    => (object) array(
                        'uker'       => $uker_name,
                        'golongan'       => $golongan_name,
                    ),
                    'report'    => $enddata
                );
                libxml_use_internal_errors(true);
                return view('admin.pegawai.excel.golongandua', compact('data')); 
            }

            if($golongan == 8 || $golongan == 7 || $golongan == 6 || $golongan == 5){
                $data = (object) array(
                    'title'     => 'Laporan Pegawai Berdasarkan Golongan',
                    'filter'    => (object) array(
                        'uker'       => $uker_name,
                        'golongan'       => $golongan_name,
                    ),
                    'report'    => $enddata
                );
                libxml_use_internal_errors(true);
                return view('admin.pegawai.excel.golongantiga', compact('data')); 
            }

            if($golongan == 4 || $golongan == 3 || $golongan == 2){
                $data = (object) array(
                    'title'     => 'Laporan Pegawai Berdasarkan Golongan',
                    'filter'    => (object) array(
                        'uker'       => $uker_name,
                        'golongan'       => $golongan_name,
                    ),
                    'report'    => $enddata
                );
                libxml_use_internal_errors(true);
                return view('admin.pegawai.excel.golonganempat', compact('data')); 
            }

           
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
