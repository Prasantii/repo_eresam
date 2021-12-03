<?php

namespace App\Transformers;

use App\Http\Models\WajibRetribusi;
use App\Http\Models\UploadBukti;
use App\Http\Models\AppVersion;
use League\Fractal\TransformerAbstract;
use App\Http\Models\Tagihan;
use App\Http\Models\Petugas;

use DB;
use DateTime;
use DateInterval;
use DatePeriod;

class BuktiPerWrDetailTransformer extends TransformerAbstract
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

            $warrr = WajibRetribusi::where('id',$bukti->id_wr)->first();
            $tagihan = Tagihan::where('id_wr',$warrr->id)
                    ->where('status',0)
                    ->orderBy('bulan','ASC')
                    ->first();

            $totalharga = $tagihan->tarif*$diff;

            $ambilpetugas = Petugas::where('id',$bukti->id_petugas)->first();

        return [
          
                'success'  => true,
                'tgl_resi'  => date('d M Y, H:i',strtotime($bukti->tgl_resi)),
                'id_pembayaran'  => $bukti->id,
                'no_kohir'  => $bukti->no_kohir,
                'code'  => $warrr->code,
                'nama'  => $warrr->nama,
                'metode'  => $metode,
                'pembayaran'  => date('F/Y',strtotime($bukti->dari)).' - '.date('F/Y',strtotime($bukti->sampai)),
                'banyak_bulan'  => $diff." Bulan",
                'tarif'  => $tagihan->tarif,
                'total'  => ''.$totalharga.'',
                'penanggung_jawab'  => $ambilpetugas->nama,
                'hp'  => $ambilpetugas->hp,             
        ];
    }
}
