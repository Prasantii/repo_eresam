<?php
namespace App\Exports\Report;

use DateTime;
use DateInterval;
use DatePeriod;
use App\Http\Models\Uker;
use App\Http\Models\Bagian;
use App\Http\Models\Petugas;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
//use App\dataSudahverif;
//use App\Http\Controllers\LaporanController;

class sudahVerif implements FromView, ShouldAutoSize
{
	
    public function __construct($date1, $date2)
    {
        $this->date1        = $date1;
        $this->date2        = $date2;
        //$this->id_petugas   = $id_petugas;
        
    }

    /**
     * @return View
     */

    public function view(): View
    {
    try{
        $date1 = $this->date1;
        $date2 = $this->date2;

        if($this->date1 != 'all' && $this->date2 != 'all')
        {
            $date1 = date('Y-m-d H:i:s', strtotime($this->date1));
            $date2 = date('Y-m-d H:i:s', strtotime($this->date2));
        }
        $nmpt = '';
      

        $datas = DB::table('petugas as a')
                    ->select('a.*','b.nama as namakoordinator','c.nama as namazona','c.id as idzona')
                    ->leftJoin('koordinator as b','a.id_koordinator','=','b.id')
                    ->leftJoin('zona as c','b.id_zona','=','c.id')
                    ->where('a.is_active',1)
                    ->where('a.id','!=', 49)
                    ->where('a.id','!=', 54)
                    
                    
                    ->orderBy('a.nama', 'ASC')
                    ->get(); 


        $begin = new DateTime($date1);
        $end = new DateTime($date2);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        $jarak = $begin->diff($end);
        $hsil = $jarak->days+1;


        $data = (object) array(
            'title'     => 'Laporan Pendataan WR Oleh Petugas Berdasarkan Periode',
            'filter'    => (object) array(
                'period'    => date('d/F/Y',strtotime($date1)) . ' s/d ' . date('d/F/Y',strtotime($date2)),
                'status'       => $nmpt,
                'hasiljarak'       => $hsil,
                'tgl1'       => $date1,
                'tgl2'       => $date2,
            ),
            'report'    => $datas
        );

    return view('admin.laporan.excel.dataSudahverif', compact('data'));
    	//return view('admin/laporan/excel/dataSudahverif');

    }
    catch (QueryException $ex)
        {
            return abort(500);
        }
    }
    } 


