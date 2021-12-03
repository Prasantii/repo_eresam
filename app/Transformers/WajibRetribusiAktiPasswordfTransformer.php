<?php

namespace App\Transformers;

use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;
use App\Http\Models\AppVersion;
use App\Http\Models\Tagihan;
use League\Fractal\TransformerAbstract;

use DB;

class WajibRetribusiAktiPasswordfTransformer extends TransformerAbstract
{

    public function getHash($password){
        $salt       = sha1(rand());
        $salt       = substr($salt, 0, 10);
        $encrypted  = password_hash($password.$salt, PASSWORD_DEFAULT);
        $hash       = array("salt" => $salt, "encrypted" => $encrypted);

        return $hash;
    }

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


        $warrdata = WajibRetribusi::where('id',$warr->id)->first();

        $pwbr       = sha1(rand());
        $pwbr       = substr($pwbr, 0, 5);

        $hash               = $this->getHash($pwbr);
        $encrypted_password = $hash['encrypted'];
        $salt               = $hash['salt'];

        $warrdata->password = $encrypted_password;
        $warrdata->salt = $salt;

        $warrdata->save();

        
        return [
            'wajib_retribusi' => array(
                'success'               => true,
                'id'           => $data->id,
                'nik'                   => $data->nik,
                'nama'                  => $data->nama,
                'alamat'                => $data->alamat.' - KEC.'.$data->namedistricts.' - GAP.'.$data->namevillages,
                'username'              => $data->username,
                'password'                 => $pwbr,
                'code'                  => $data->code,
                'qrcode'                => $data->qrcode
                )
        ];
    }
}
