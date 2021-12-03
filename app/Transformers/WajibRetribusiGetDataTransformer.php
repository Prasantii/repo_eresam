<?php

namespace App\Transformers;

use App\Http\Models\WajibRetribusi;
use App\Http\Models\AppVersion;
use League\Fractal\TransformerAbstract;

use DB;

class WajibRetribusiGetDataTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($warr)
    {
        $data = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->where('a.id',$warr->id)
                ->first();
        

        return [
                'success'               => true,
                'id_wr'           => $warr->id,
                'nik'         => $warr->nik,
                'nama'         => $warr->nama,
                'alamat'         => $data->alamat.' - GAP.'.$data->namevillages.' - KEC.'.$data->namedistricts,
                'code'                  => $warr->code,
                
        ];
    }
}
