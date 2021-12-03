<?php

namespace App\Transformers;

use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;
use App\Http\Models\AppVersion;
use App\Http\Models\Tagihan;
use League\Fractal\TransformerAbstract;

use DB;

class WajibRetribusiDetailTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(WajibRetribusi $warr)
    {
        $data = DB::table('wajib_retribusi as a')
                ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namajenis','d.luas as luasjenis','d.tarif_kota','d.tarif_gampong')
                ->leftJoin('districts as b','a.district_id','=','b.id')
                ->leftJoin('villages as c','a.villages_id','=','c.id')
                ->leftJoin('jenis_retribusi as d','a.jenis_id','=','d.id')
                ->where('a.id',$warr->id)
                ->first();

        if($data->kota == 1){
            $je = $data->namajenis.'- Luas:'.$data->luasjenis;
            $tarf = number_format($data->tarif_kota);
        }else{
            $je = '-';
            $tarf = '-';
        }

        if($data->gampong == 1){
            $je = $data->namajenis.'- Luas:'.$data->luasjenis;
            $tarf = number_format($data->tarif_gampong);
        }else{
            $je = '-';
            $tarf = '-';
        }

        $zona = DB::table('zona as a')
                    ->select('a.*','b.id_districts','c.district_id','c.villages_id')
                    ->leftJoin('detail_zona as b','a.id','=','b.id_zona')
                    ->leftJoin('wajib_retribusi as c','b.id_districts','=','c.district_id')
                    ->where('c.villages_id',$data->villages_id)
                    ->first();

        $photo_rumah = DetailImage::where('id_wr',$data->id)->first();

        
        return [
            'wajib_retribusi' => array(
                'success'               => true,
                'id'           => $data->id,
                'nik'                   => $data->nik,
                'nama'                  => $data->nama,
                'hp'                    => $data->hp,
                'alamat'                => $data->alamat.' - KEC.'.$data->namedistricts.' - GAP.'.$data->namevillages,
                'district_id'              => $data->district_id,
                'villages_id'              => $data->villages_id,
                'username'              => $data->username,
                'email'                 => $data->email,
                'photo'                 => $data->photo,
                'ktp'                 => $data->ktp,
                'jenis_retribusi'       => $je,
                'jenis_retribusi_tarif' => $tarf,
                'code'                  => $data->code,
                'qrcode'                => $data->qrcode,
                'zona'                  => $zona->nama,
                'lat'                => $data->lat,
                'lng'                => $data->lng,
                'is_active'             => $data->is_active,
                'registered'            => $data->created_at,
                'email_verify'          => $data->email_verify,
                'photo_rumah'           => $photo_rumah,
                )
        ];
    }
}
