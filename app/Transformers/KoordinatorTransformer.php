<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\Zona;
use App\Http\Models\Koordinator;
use DB;

class KoordinatorTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($messages)
    {
        $koordinator = DB::table('zona as a')
                    ->select('a.id as id_zona','a.nama as nama_zona','b.id as id_koordinator','b.nama as nama_koordinator')
                    ->leftJoin('koordinator as b','a.id','=','b.id_zona')
                    // ->where('d.is_active',1)
                    ->get();
        // $zona = Zona::get();
        return [
            'success'              => true,
            'koordinator'  => $koordinator,
            // 'zona' => $zona
            
        ];
    }
}
