<?php

namespace App\Transformers;

use App\Http\Models\UploadBukti;
use App\Http\Models\AppVersion;
use League\Fractal\TransformerAbstract;

use DB;
use DateTime;
use DateInterval;
use DatePeriod;

class BuktiTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(UploadBukti $databukti)
    {


          $date1 = $databukti->dari;
          $date2 = $databukti->sampai;

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1) +1;

        return [
                'success'               => true,
                'id'           => $databukti->id,
                'id_wr'           => $databukti->id_wr,
                'dari'         => date('F-Y',strtotime($databukti->dari)),
                'sampai'         => date('F-Y',strtotime($databukti->sampai)),
                'total_bayar'         => $databukti->total_bayar,
                'tgl_upload'         => $databukti->tgl_upload,
                'bukti'         => $databukti->bukti,
                'total_bulan'         => $diff." Bulan",
                
        ];
    }
}
