<?php

namespace App\Transformers;

use App\Http\Models\Petugas;
use App\Http\Models\AppVersion;
use League\Fractal\TransformerAbstract;

use DB;

class PetugasGetDataTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($lokasitgas)
    {
        
        return [
                'success'               => true,
                'nama_kecamatan'           => $lokasitgas->nama_kecamatan,
                'nama_gampong'                  => $lokasitgas->nama_gampong,
                'id_gampong'          => $lokasitgas->id_gampong,
        ];
    }
}
