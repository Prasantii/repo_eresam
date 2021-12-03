<?php

namespace App\Exports\Report;

use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class datawr implements FromView, ShouldAutoSize
{
    
    // public function __construct($date1, $date2, $status)
    // {
    //     $this->date1        = $date1;
    //     $this->date2        = $date2;
    //     $this->status        = $status;
    // }

    /**
     * @return View
     */
    public function view(): View
    {
    //     try{
    //         // $date1 = $this->date1;
    //         // $date2 = $this->date2;

    //         if($this->date1 != 'all' && $this->date2 != 'all')
    //         {
    //             $date1 = date('Y-m-d H:i:s', strtotime($this->date1));
    //             $date2 = date('Y-m-d H:i:s', strtotime($this->date2));
    //         }

        
            $data = (object) array(
                'title'     => 'Laporan Data WR ',
            );

            return view('admin.laporan.excel.verifikasi2export', compact('data'));
        }
        
}