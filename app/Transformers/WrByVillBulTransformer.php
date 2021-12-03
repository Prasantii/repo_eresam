<?php

namespace App\Transformers;

use App\Http\Models\JenisRetribusi;
use App\Http\Models\AppVersion;
use League\Fractal\TransformerAbstract;

use DB;

class WrByVillBulTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($wrzona)
    {

        $data = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->where('a.id',$wrzona->id)
                ->first();

        return [
                'success'               => true,
                'id_wr'           => $wrzona->id,
                'nik'         => $wrzona->nik,
                'nama'         => $wrzona->nama,
                'alamat'         => $data->alamat.' - KEC.'.$data->namedistricts.' - GAP.'.$data->namevillages,
                'code'                  => $wrzona->code,
                
        ];
    }
}
