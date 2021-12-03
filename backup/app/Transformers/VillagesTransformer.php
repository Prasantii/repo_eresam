<?php

namespace App\Transformers;

use App\Http\Models\Districts;
use App\Http\Models\Villages;
use App\Http\Models\AppVersion;
use League\Fractal\TransformerAbstract;

use DB;

class VillagesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Villages $villages)
    {

        
        return [
                'success'               => true,
                'id'           => $villages->id,
                'regency_id'   => $villages->district_id,
                'nama'         => $villages->name,
                
        ];
    }
}
