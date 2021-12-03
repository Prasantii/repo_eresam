<?php

namespace App\Transformers;

use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;
use App\Http\Models\AppVersion;
use App\Http\Models\Tagihan;
use League\Fractal\TransformerAbstract;

use DB;

class TagihanTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Tagihan $tagihan)
    {

        if($tagihan->tgl_bayar == ""){
            $byr = '-';
        }else{
            $byr = $tagihan->tgl_bayar;
        }
        return [
            
            'success'      => true,
            'id'           => $tagihan->id,
            'bulan'         => date('F-Y',strtotime($tagihan->bulan)),
            'tarif'         => $tagihan->tarif,
            'status'        => $tagihan->status,
            'tgl_bayar'     => $byr,
                
        ];
    }
}
