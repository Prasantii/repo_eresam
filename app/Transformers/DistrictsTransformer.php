<?php

namespace App\Transformers;

use App\Http\Models\Districts;
use App\Http\Models\Villages;
use App\Http\Models\AppVersion;
use League\Fractal\TransformerAbstract;

use DB;

class DistrictsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Districts $districts)
    {

        
        return [
                'success'               => true,
                'id'           => '0'.$districts->id,
                'nama'         => $districts->name,
                
        ];
    }
}
