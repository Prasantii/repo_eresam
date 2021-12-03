<?php

namespace App\Exports\Report;

use App\Http\Models\Uker;
use App\Http\Models\Bagian;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KeuanganExport implements FromView, ShouldAutoSize
{
    public function __construct($date1, $date2, $status)
    {
        $this->date1        = $date1;
        $this->date2        = $date2;
        $this->status        = $status;
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

            $status= $this->status;
            $datas = DB::table('upload_bukti_trs as a')
                ->select('a.*','b.nama as namapetugas','b.hp as hppetugas','c.nama','c.nik','c.code')
                ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                ->leftJoin('wajib_retribusi as c','a.id_wr','=','c.id')
                ->when($date1!='all', function ($query) use ($date1){
                    return $query->where('a.tgl_upload', '>=', $date1);
                })
                ->when($date2!='all', function ($query) use ($date2){
                    return $query->where('a.tgl_upload', '<=', $date2);
                })
                ->when($status=='all', function ($query) use ($status){
                    return $query->where('a.status','!=', '0')->where('a.status','!=', '3');
                })
                ->when($status!='all', function ($query) use ($status){
                    return $query->where('a.status', $status);
                })

                ->get();

            if($status == 'all')
            {
                $status_nama = 'SEMUA STATUS PEMBAYARAN';
            }
            elseif($status == '1')
            {
                $status_nama = 'Pembayaran Melalui Aplikasi';
            }
            elseif($status == '2')
            {
                $status_nama = 'Pembayaran Manual Ke Petugas';
            }
            elseif($status == '3')
            {
                $status_nama = 'Pembayaran Ditolak Petugas';
            }

            $data = (object) array(
                'title'     => 'Laporan Keuangan Bedasarkan Status Dan Tanggal',
                'filter'    => (object) array(
                    'period'    => date('d-F-Y',strtotime($date1)) . ' sd ' . date('d-F-Y',strtotime($date2)),
                    'status'       => $status_nama
                ),
                'report'    => $datas
            );

            return view('admin.laporan.excel.keuangan', compact('data'));
        }
        catch (QueryException $ex)
        {
            return abort(500);
        }
    }
}
