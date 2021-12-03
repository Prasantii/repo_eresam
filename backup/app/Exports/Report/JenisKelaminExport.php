<?php

namespace App\Exports\Report;

use App\Http\Models\Uker;
use App\Http\Models\Bagian;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JenisKelaminExport implements FromView, ShouldAutoSize
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

            $datas =  "SELECT d.nama as namabagian,e.nama as namauker ,a.LAKI,a.PEREMPUAN,(a.LAKI+a.PEREMPUAN) as total FROM (
                    SELECT id_bagian,id_uker,
                    COUNT(CASE WHEN (jenis_kelamin)='LAKI-LAKI' THEN 1 END) AS LAKI,
                    COUNT(CASE WHEN (jenis_kelamin)='PEREMPUAN' THEN 1 END) AS PEREMPUAN
                    FROM pegawai GROUP BY id_bagian,id_uker
                ) AS a
                LEFT JOIN bagian as d ON a.id_bagian = d.id
                LEFT JOIN uker as e ON a.id_uker = e.id WHERE a.id_bagian IS NOT NULL ";

            if($uker!='all'){
                  $datas .= 'AND a.id_uker = '.$uker;
            }
            if($bagian!='all'){
                  $datas .= ' AND a.id_bagian = '.$bagian;
            }

            $datas .= ' ORDER BY  a.id_uker,a.id_bagian ASC';
            
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
                $bagian_name = 'SEMUA UNIT BAGIAN';
            }
            else
            {
                $bagian_      = Bagian::where('id', $bagian)->first();
                $bagian_name  = $bagian_->nama;
            }

            $data = (object) array(
                'title'     => 'Laporan Pegawai Berdasarkan Jenis Kelamin',
                'filter'    => (object) array(
                    'uker'       => $uker_name,
                    'bagian'       => $bagian_name,
                ),
                'report'    => $enddata
            );

            return view('admin.pegawai.excel.jenis_kelamin', compact('data'));
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
