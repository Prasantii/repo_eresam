<?php

namespace App\Transformers;

use App\Http\Models\WajibRetribusi;
use App\Http\Models\UploadBukti;
use App\Http\Models\AppVersion;
use League\Fractal\TransformerAbstract;

use DB;
use DateTime;
use DateInterval;
use DatePeriod;

class BuktiPerWrTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($bukti)
    {
          $date1 = $bukti->dari;
            $date2 = $bukti->sampai;

            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);

            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);

            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);

            $diff = (($year2 - $year1) * 12) + ($month2 - $month1) +1;

            if($bukti->status == 1){
                $metode = 'Pembayaran Melalui Aplikasi (Transfer Tunai)';
            }elseif($bukti->status == 2){
                $metode = 'Pembayaran Manual Ke Petugas';
            }else{
                $metode = '-';
            }

        return [
          
                'success'               => true,
                'id_pembayaran'           => $bukti->id,
                'tgl_resi'  => date('d M Y, H:i',strtotime($bukti->tgl_resi)),
                'banyak_bulan'  => $diff." Bulan",
                'total'  => ''.$bukti->total_bayar.'',
                'metode'  => $metode,                
        ];
    }
}
