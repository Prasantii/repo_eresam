<?php

namespace App\Transformers;

use App\Http\Models\JenisRetribusi;
use App\Http\Models\AppVersion;
use League\Fractal\TransformerAbstract;

use DB;

class JenisRetribusiTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(JenisRetribusi $jenis_retribusi)
    {

        
        return [
                'success'               => true,
                'id'           => $jenis_retribusi->id,
                'nama'         => $jenis_retribusi->nama,
                'luas'         => $jenis_retribusi->luas,
                'tarif_kota'         => $jenis_retribusi->tarif_kota,
                'tarif_gampong'         => $jenis_retribusi->tarif_gampong,
                
        ];
    }
}
