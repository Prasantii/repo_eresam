<?php

namespace App\Transformers;

use App\Http\Models\Petugas;
use App\Http\Models\AppVersion;
use App\Http\Models\LokasiTugas;
use League\Fractal\TransformerAbstract;

use DB;

class PetugasTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Petugas $petugas)
    {

        $app = AppVersion::where('appid','1')->first();

        $data = DB::table('petugas as a')
                ->select('a.id','a.lat','a.lng', 'a.id_koordinator','a.nik','a.nama','a.hp','a.username','a.email','a.image','a.created_at','a.email_verify','a.token','a.token_expiry','a.updated_at','a.is_active','a.gampong','b.nama as namakoordinator','c.nama as namazona','c.id as idzona')
                ->leftJoin('koordinator as b','a.id_koordinator','=','b.id')
                ->leftJoin('zona as c','b.id_zona','=','c.id')
                ->where('a.id',$petugas->id)
                ->first();
                
        $cekemail = DB::table('petugas_email_ver')
                ->where('email',$petugas->email)
                ->first();
        if(!empty($cekemail)){
            $email_tokencek = $cekemail->token;
        }else{
            $email_tokencek = 0;
        }

        $zona = DB::table('detail_zona as a')
                    ->select('a.id_zona','d.is_active','d.nama as nama_zona','b.name as nama_kecamatan','c.name as nama_gampong','c.id as id_gampong')
                    ->leftJoin('zona as d','a.id_zona','=','d.id')
                    ->leftJoin('districts as b','a.id_districts','=','b.id')
                    ->leftJoin('villages as c','b.id','=','c.district_id')
                    ->where('d.id',$data->idzona)
                    // ->where('d.is_active',1)
                    ->get();

        $lokasitgas = DB::table('lokasi_tugas as a')
                    ->select('b.name as nama_kecamatan','c.name as nama_gampong','c.id as id_gampong')
                    ->leftJoin('districts as b','a.district_id','=','b.id')
                    ->leftJoin('villages as c','a.villages_id','=','c.id')
                    ->where('a.id_petugas',$data->id)
                    ->get();

        
        return [
            'petugas' => array(
                'success'               => true,
                'id'           => $data->id,
                'koordinator'           => $data->namakoordinator,
                'zona'                  => $data->namazona,
                'status_petugas'        => $data->gampong,
                'lokasi_tugas'          => $lokasitgas,
                'nik'                   => $data->nik,
                'nama'                  => $data->nama,
                'hp'                    => $data->hp,
                'username'              => $data->username,
                'email'                 => $data->email,
                'image'                 => $data->image,
                'is_active'             => $data->is_active,
                'token'                 => $data->token,
                'token_expiry'          => $data->token_expiry,
                'registered'            => $data->created_at,
                'email_verify'          => $data->email_verify,
                'lat'          => $data->lat,
                'lng'          => $data->lng,
                'email_token'           => $email_tokencek,
                'app_id'                => $app->appid,
                'app_version'           => $app->versi,
                )
        ];
    }
}
